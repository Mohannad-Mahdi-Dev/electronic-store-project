<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // عرض القائمة
    public function index(Request $request)
    {
        $items = $request->user()->wishlistItems()->latest()->get();
        return view('front.wishlist.index', compact('items'));
    }

    // إضافة أو إزالة (Toggle)
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        // يقوم بالإضافة إذا لم يكن موجوداً، وبالحذف إذا كان موجوداً
        $request->user()->wishlistItems()->toggle($request->product_id);

        return redirect()->back()->with('success', 'تم تحديث قائمة المفضلة');
    }

    // تنظيف القائمة بالكامل (Clear All)
    public function clear()
    {
        auth()->user()->wishlistItems()->detach();

        return redirect()->back()->with('success', 'تم تنظيف قائمة المفضلة بالكامل');
    }

    // حذف منتج واحد (Destroy)
    public function destroy($product_id)
    {
        // التحقق مما إذا كان القادم هو موديل (بسبب Model Binding) أو مصفوفة
        if ($product_id instanceof \App\Models\Product) {
            $product_id = $product_id->id;
        }
        if (is_array($product_id)) {
            $product_id = $product_id['id'] ?? null;
        }

        // الحذف
        auth()->user()->wishlistItems()->detach($product_id);

        return back()->with('success', 'تم حذف المنتج من المفضلة');
    }

    // نقل منتج واحد للسلة
    public function moveToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->qty <= 0) {
            return back()->with('error', 'عذراً، هذا المنتج نفذت كميته.');
        }

        $cart = session()->get('cart', []);
        $id = $product->id;
        $finalPrice = $product->sale_price ?? $product->price;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => (float) $finalPrice,
                'quantity' => 1,
                'image' => $product->image,
                'slug' => $product->slug
            ];
        }

        session()->put('cart', $cart);

        // حذف من المفضلة بعد النقل
        $request->user()->wishlistItems()->detach($productId);

        return back()->with('success', 'تم نقل المنتج إلى السلة بنجاح 🛒');
    }

    // نقل الكل للسلة
    public function moveAllToCart(Request $request)
    {
        $products = $request->user()->wishlistItems()->get();

        if ($products->isEmpty()) {
            return back()->with('error', 'القائمة فارغة بالفعل.');
        }

        $cart = session()->get('cart', []);
        $countMoved = 0;

        foreach ($products as $product) {
            if ($product->qty <= 0) continue;

            $id = $product->id;
            $finalPrice = $product->sale_price ?? $product->price;

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => (float) $finalPrice,
                    'quantity' => 1,
                    'image' => $product->image,
                    'slug' => $product->slug
                ];
            }
            $countMoved++;
        }

        session()->put('cart', $cart);
        $request->user()->wishlistItems()->detach();

        if ($countMoved == 0) {
            return back()->with('error', 'جميع المنتجات غير متوفرة حالياً.');
        }

        return back()->with('success', "تم نقل $countMoved منتج إلى السلة بنجاح 🛒");
    }
    public function remove($product_id)
    {
        return $this->destroy($product_id);
    }
}
