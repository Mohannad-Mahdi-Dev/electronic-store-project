<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display single product detail page.
     */
    public function show(Product $product)
    {
        // Load related products from same category
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Load product images
        $product->load('images');

        return view('front.products.show', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|numeric|min:1',
        ]);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name ?? $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->images->first() ? $product->images->first()->path : null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('front.cards.index')->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('front.cards.index', compact('cart'));
    }

    public function updateCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $action = $request->input('action');

            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease') {
                $cart[$productId]['quantity']--;
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('front.cards.index');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('front.cards.index')->with('success', 'Product removed from cart!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('front.cards.index')->with('success', 'Cart cleared successfully!');
    }
}
