<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        // 1) منع الدخول إذا السلة فارغة
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('warning', __('messages.cart_empty'));
        }

        // 2) تحميل بيانات المنتجات مع الصور (Security & Performance)
        $enrichedCart = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = Product::with('mainImage')->find($id);

            if ($product) {
                $qty = $details['quantity'] ?? $details['qty'] ?? 1;

                // إذا كانت البيانات موجودة في السيشن نستخدمها، وإلا نجلبها من قاعدة البيانات
                $mainImage = $details['image'] ?? ($product->mainImage ? $product->mainImage->path : null);

                $enrichedCart[$id] = [
                    'name' => $details['name'] ?? $product->name,
                    'price' => $product->price, // نستخدم السعر من قاعدة البيانات (Security)
                    'quantity' => $qty,
                    'qty' => $qty, // للتوافق مع الكود القديم
                    'image' => $mainImage,
                ];

                $subtotal += $product->price * $qty;
            }
        }

        // استبدال السلة بالنسخة المحسّنة
        $cart = $enrichedCart;

        // 3) الشحن (نفس منطقك)
        $shipping = $subtotal > 500 ? 0 : 10.00;

        // 4) Preview للخصم من Session coupon (عرض فقط)
        $coupon = session('coupon', null);
        $discountPreview = 0;

        if ($coupon && isset($coupon['code'])) {
            $dbCoupon = \App\Models\Coupon::query()
                ->where('code', $coupon['code'])
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>=', now()->toDateString());
                })->first();


            if ($dbCoupon) {
                if ($dbCoupon->type === 'fixed') {
                    $discountPreview = (float) $dbCoupon->value;
                } else {
                    $discountPreview = ((float)$subtotal * (float)$dbCoupon->value) / 100;
                }

                // لا تجعل الخصم يتجاوز subtotal
                $discountPreview = min($discountPreview, (float)$subtotal);

                // نمرر كوبون "رسمي" للعرض
                $coupon = [
                    'code'  => $dbCoupon->code,
                    'type'  => $dbCoupon->type,
                    'value' => $dbCoupon->value,
                ];
            } else {
                // الكوبون في السيشن غير صالح -> نحذفه لتجنب عرض خاطئ
                session()->forget('coupon');
                $coupon = null;
                $discountPreview = 0;
            }
        }

        // 5) الإجمالي للعرض
        $totalPreview = ($subtotal - $discountPreview) + $shipping;

        return view('front.checkout.index', compact(
            'cart',
            'subtotal',
            'shipping',
            'coupon',
            'discountPreview',
            'totalPreview'
        ));
    }

    // دالة تطبيق الكوبون
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->code));

        // السلة
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['code' => 'السلة فارغة.']);
        }

        // subtotal من DB (Security)
        $subtotal = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $qty = $item['quantity'] ?? $item['qty'] ?? 1;
                $subtotal += $product->price * $qty;
            }
        }

        // جلب الكوبون والتحقق (يدعم expiry_date null)
        $coupon = Coupon::query()
            ->where('code', $code)
            ->first();

        if (!$coupon) {
            return back()->withErrors(['code' => 'كود الخصم غير صحيح.']);
        }

        if (!$coupon->is_active) {
            return back()->withErrors(['code' => 'هذا الكوبون غير مفعل.']);
        }

        if ($coupon->expiry_date !== null && $coupon->expiry_date < now()->toDateString()) {
            return back()->withErrors(['code' => 'هذا الكوبون منتهي الصلاحية.']);
        }

        if ($coupon->cart_value !== null && $subtotal < (float)$coupon->cart_value) {
            return back()->withErrors(['code' => 'هذا الكوبون يتطلب حدًا أدنى للطلب.']);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return back()->withErrors(['code' => 'تم الوصول إلى الحد الأقصى لاستخدام هذا الكوبون.']);
        }

        // حساب الخصم (Preview)
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = (float) $coupon->value;
        } else {
            $discount = ((float)$subtotal * (float)$coupon->value) / 100;
        }
        $discount = min($discount, (float)$subtotal);

        // نخزن في السيشن "بيانات للعرض" فقط
        session()->put('coupon', [
            'code'  => $coupon->code,
            'type'  => $coupon->type,
            'value' => $coupon->value,
        ]);

        return redirect()->route('checkout.index')
            ->with('success', "تم تطبيق الكوبون {$coupon->code} بنجاح. الخصم: " . number_format($discount, 2));
    }

    // دالة إزالة الكوبون
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'تم إزالة الكوبون.');
    }


    public function store(Request $request)
    {
        // 1. التحقق الصارم من البيانات
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:9',
            'address' => 'required|string|max:500',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod,stripe,paypal',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('shop.index');

        // 2. استخدام Database Transaction
        DB::beginTransaction();

        try {
            // حساب المجموع الفرعي (Subtotal) بأمان من قاعدة البيانات
            $subtotal = 0;
            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                $subtotal += $product->price * $item['quantity'];
            }

            // --- منطق الخصم (Coupons) ---
            $discount = 0;
            $couponCode = null;

            if (session()->has('coupon')) {

                // اقفل صف الكوبون أثناء العملية لمنع تجاوز usage_limit بسبب طلبين بنفس الوقت
                $coupon = \App\Models\Coupon::query()
                    ->where('code', session('coupon')['code'])
                    ->lockForUpdate()
                    ->first();

                if ($coupon) {

                    // تحقق: فعال
                    if (!$coupon->is_active) {
                        $coupon = null;
                    }

                    // تحقق: تاريخ الانتهاء (يدعم null)
                    if ($coupon && $coupon->expiry_date !== null && $coupon->expiry_date < now()->toDateString()) {
                        $coupon = null;
                    }

                    // تحقق: حد أدنى للسلة
                    if ($coupon && $coupon->cart_value !== null && $subtotal < (float)$coupon->cart_value) {
                        $coupon = null;
                    }

                    // تحقق: حد الاستخدام
                    if ($coupon && $coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
                        $coupon = null;
                    }

                    if ($coupon) {
                        $couponCode = $coupon->code;

                        if ($coupon->type === 'fixed') {
                            $discount = (float) $coupon->value;
                        } else {
                            $discount = ((float)$subtotal * (float)$coupon->value) / 100;
                        }

                        // لا تجعل الخصم يتجاوز subtotal
                        $discount = min($discount, (float)$subtotal);

                        // زيادة عدد الاستخدام (بعد التحقق)
                        $coupon->increment('used_count');
                    } else {
                        // الكوبون غير صالح الآن -> احذفه من السيشن
                        session()->forget('coupon');
                    }
                } else {
                    session()->forget('coupon');
                }
            }
            // ---------------------------

            // ---------------------------

            $shipping = 10.00;
            // الحساب النهائي: (المجموع - الخصم) + الشحن
            $total = ($subtotal - $discount) + $shipping;

            // 3. إنشاء الطلب (بإضافة حقول الخصم)
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'coupon_code' => $couponCode,
                'shipping_fee' => $shipping,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'shipping_notes' => $request->notes,
                'shipping_name' => $request->name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'payment_status' => $request->payment_method == 'cod' ? 'unpaid' : 'paid',
                // 'shipping_address' => json_encode($validatedData),
            ]);

            // 4. إنشاء العناصر وتحديث المخزون
            // 4. إنشاء العناصر وتحديث المخزون ( آمن + يمنع overselling)
            foreach ($cart as $id => $item) {

                $qty = $item['quantity'] ?? $item['qty'] ?? 1;

                //  اقفل صف المنتج داخل نفس الـ Transaction
                $product = Product::query()
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                //  تحقق المخزون قبل الخصم
                if ((int)$product->stock < (int)$qty) {
                    throw new \Exception("الكمية غير متوفرة للمنتج: {$product->name}. المتاح حالياً: {$product->stock}");
                }

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $id,
                    'product_name' => $product->name,
                    'quantity'     => $qty,
                    'price'        => $product->price,
                ]);

                //  خصم المخزون بأمان
                $product->decrement('stock', $qty);
            }


            DB::commit();

            // تنظيف الجلسة (السلة والكوبون)
            session()->forget(['cart', 'coupon']);

            return redirect()->route('checkout.thank-you', $order->order_number)
                ->with('success', __('messages.order_success'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage());
        }
    }
    //
    /**
     * عرض صفحة الشكر بعد إتمام الطلب بنجاح
     * Display thank you page after successful order completion
     * 
     * @param string $order_number رقم الطلب الفريد
     * @return \Illuminate\View\View
     * 
     * Performance Optimization:
     * - استخدام Eager Loading لتجنب مشكلة N+1 queries
     * - تحميل العلاقات: items -> product -> images
     * 
     * Future Enhancements:
     * - إضافة إرسال بريد إلكتروني تأكيدي للعميل
     * - تكامل مع أنظمة الدفع الإلكتروني (Stripe, PayPal) لتأكيد الدفع
     * - إضافة QR code للطلب لسهولة التتبع
     * - إمكانية طباعة الفاتورة PDF
     * - إرسال إشعار SMS للعميل
     * - تسجيل Analytics event لتتبع معدل التحويل
     */
    public function thankYou($order_number)
    {
        // 1. جلب الطلب مع تحميل مسبق للعلاقات (Eager Loading)
        // Fetch order with eager loaded relationships to avoid N+1 problem
        $order = Order::where('order_number', $order_number)
            ->with([
                'items.product.images', // تحميل المنتجات وصورها
                'user' // تحميل بيانات المستخدم (للاستخدام المستقبلي)
            ])
            ->firstOrFail(); // رمي 404 إذا لم يتم العثور على الطلب

        // 2. التحقق الأمني: التأكد من أن الطلب يخص المستخدم الحالي
        // Security Check: Ensure the order belongs to the current authenticated user
        if (auth()->check() && $order->user_id !== auth()->id()) {
            // إذا كان المستخدم مسجل دخول ولكن الطلب لا يخصه
            abort(403, 'Unauthorized access to this order.');
        }

        // 3. تسجيل حدث المشاهدة (للتطوير المستقبلي)
        // Log view event for analytics (Future Enhancement)
        // event(new OrderThankYouViewed($order));

        // 4. إرسال إشعار بريد إلكتروني (للتطوير المستقبلي)
        // Send confirmation email (Future Enhancement)
        // Mail::to($order->user->email)->send(new OrderConfirmation($order));

        return view('front.checkout.thank-you', compact('order'));
    }
}
