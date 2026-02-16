@extends('front.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 py-12 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">Shopping Cart</h1>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4 text-center">Quantity</th>
                                <th class="px-6 py-4 text-right">Price</th>
                                <th class="px-6 py-4 text-right">Total</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @php $subtotal = 0; @endphp
                            @foreach($cart as $productId => $item)
                            @php 
                                $itemTotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemTotal;
                            @endphp
                            <tr>
                                <td class="px-6 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                            @if(isset($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                            @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrease" class="w-8 h-8 rounded-full border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">-</button>
                                            <span class="w-12 text-center font-semibold text-gray-800 dark:text-gray-200">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="action" value="increase" class="w-8 h-8 rounded-full border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-right text-gray-600 dark:text-gray-300">
                                    ${{ number_format($item['price'], 2) }}
                                </td>
                                <td class="px-6 py-6 text-right font-bold text-primary-600">
                                    ${{ number_format($itemTotal, 2) }}
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('shop.index') }}" class="text-primary-600 font-medium flex items-center hover:underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Continue Shopping
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-all">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Order Summary</h2>
                    
                    @php 
                        $tax = $subtotal * 0.15;
                        $total = $subtotal + $tax;
                    @endphp
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-gray-600 dark:text-gray-300">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-300 border-b border-gray-50 dark:border-gray-700 pb-4">
                            <span>Tax (VAT 15%)</span>
                            <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-extrabold text-gray-900 dark:text-white pt-2">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                  <a href="{{ route('checkout.index') }}" 
   class="w-full mt-8 bg-primary-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-primary-700 shadow-lg shadow-primary-200 transition-all flex items-center justify-center decoration-0">
    Proceed to Checkout
    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
    </svg>
</a>         

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Have a promo code?</label>
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Code" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 outline-none">
                            <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition-all">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Your cart is empty</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>
@endsection