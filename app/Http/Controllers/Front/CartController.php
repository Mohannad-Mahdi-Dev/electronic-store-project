<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * عرض صفحة السلة
     */
    public function index()
    {
        // جلب السلة من الـ session
        $cart = session()->get('cart', []);

        return view('front.cards.index', compact('cart'));
    }

    /**
     * إضافة منتج إلى السلة
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity  = $request->quantity ?? 1;

        // جلب بيانات المنتج من قاعدة البيانات
        $product = \App\Models\Product::with('mainImage')->find($productId);

        if (!$product) {
            return back()->with('error', 'Product not found');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            // إذا كان المنتج موجود، نزيد الكمية فقط
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // إضافة المنتج مع كامل البيانات
            $mainImage = $product->mainImage ? $product->mainImage->path : null;

            $cart[$productId] = [
                'quantity' => $quantity,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $mainImage,
            ];
        }

        session()->put('cart', $cart);

        // بعد الإضافة نعيد المستخدم لصفحة السلة
        return redirect()->route('front.cards.index')->with('success', 'Product added to cart successfully');
    }

    /**
     * حذف منتج من السلة
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('front.cards.index');
    }

    /**
     * تفريغ السلة بالكامل
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('front.cards.index');
    }
}
