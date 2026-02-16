<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        // 1. الحصول على طلبات المستخدم الحالي فقط
        $query = Order::where('user_id', Auth::id())->latest();

        // 2. الفلترة حسب الحالة (Tabs)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 3. البحث بـ ID الطلب (Search)
        if ($request->filled('q')) {
            $searchTerm = str_replace('#ORD-', '', $request->q); // تنظيف البحث إذا أدخل المستخدم الرمز
            $query->where('id', 'like', "%{$searchTerm}%");
        }

        // 4. الترقيم (Pagination) مع الحفاظ على روابط البحث
        $orders = $query->paginate(10);

        return view('front.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // التأكد أن الطلب يخص المستخدم الحالي
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front.orders.show', compact('order'));
    }
}
