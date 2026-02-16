@extends('front.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Checkout</h1>
            <p class="text-gray-600 dark:text-gray-400">Complete your purchase securely</p>
        </div>

        <!-- Alert Messages -->
        @if(session('warning'))
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-yellow-800 dark:text-yellow-200 font-medium">{{ session('warning') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-200 dark:border-red-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- LEFT COLUMN: Order Summary & Coupon -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Order Items Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Order Items ({{ count($cart) }})
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($cart as $id => $item)
                                @php
                                    $qty = $item['qty'] ?? $item['quantity'] ?? 1;
                                    $name = $item['name'] ?? ('Product #' . $id);
                                    $price = $item['price'] ?? 0;
                                    $image = $item['image'] ?? null;
                                    $itemTotal = $price * $qty;
                                @endphp

                                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary-200 dark:hover:border-primary-800 transition-all hover:shadow-md">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                        @if($image)
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="{{ $name }}"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%23ccc%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z%22/%3E%3C/svg%3E';">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white text-base truncate">{{ $name }}</h3>
                                        <div class="flex items-center gap-3 mt-1 text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">
                                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($price, 2) }}</span> × {{ $qty }}
                                            </span>
                                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs font-medium">
                                                Qty: {{ $qty }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <div class="text-xl font-black text-primary-600 dark:text-primary-400">
                                            ${{ number_format($itemTotal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="font-bold text-gray-900 dark:text-white text-lg">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discountPreview > 0)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-green-600 dark:text-green-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Discount
                                </span>
                                <span class="font-bold text-green-600 dark:text-green-400">-${{ number_format($discountPreview, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                    Shipping
                                    @if($shipping == 0)
                                        <span class="ml-2 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-bold">FREE</span>
                                    @endif
                                </span>
                                <span class="font-bold text-gray-900 dark:text-white">${{ number_format($shipping, 2) }}</span>
                            </div>

                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                    <span class="text-3xl font-black bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                                        ${{ number_format($totalPreview, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coupon Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border-b border-purple-100 dark:border-purple-800">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                            Promo Code
                        </h2>
                    </div>

                    <div class="p-6">
                        @if($coupon && isset($coupon['code']))
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-green-600 dark:text-green-400 font-medium uppercase">Applied</div>
                                        <div class="font-black text-green-900 dark:text-green-100 text-lg">{{ $coupon['code'] }}</div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('coupon.remove') }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @else
                            <form method="POST" action="{{ route('coupon.apply') }}" class="space-y-2">
                                @csrf
                                <div class="flex gap-3">
                                    <div class="flex-1 relative">
                                        <input 
                                            type="text"
                                            name="code" 
                                            value="{{ old('code') }}"
                                            class="w-full h-12 pl-12 pr-4 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white font-medium"
                                            placeholder="Enter promo code">
                                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                    </div>
                                    <button type="submit" class="px-6 h-12 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl shadow-lg shadow-primary-200 dark:shadow-primary-900/30 transition-all hover:scale-105 active:scale-95">
                                        Apply
                                    </button>
                                </div>
                                @error('code')
                                <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </form>
                        @endif
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Checkout Form -->
            <div class="lg:col-span-5">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-24">
                    <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Shipping Information
                        </h2>
                    </div>

                    <form method="POST" action="{{ route('checkout.store') }}" class="p-6 space-y-5">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                name="name" 
                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                class="w-full h-12 px-4 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white @error('name') border-red-500 @enderror"
                                placeholder="John Doe">
                            @error('name') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email"
                                name="email" 
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                class="w-full h-12 px-4 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white @error('email') border-red-500 @enderror"
                                placeholder="john@example.com">
                            @error('email') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel"
                                name="phone" 
                                value="{{ old('phone') }}"
                                class="w-full h-12 px-4 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white @error('phone') border-red-500 @enderror"
                                placeholder="777 777 777">
                            @error('phone') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Street Address <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="address" 
                                rows="3"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white resize-none @error('address') border-red-500 @enderror"
                                placeholder="24">{{ old('address') }}</textarea>
                            @error('address') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                name="city" 
                                value="{{ old('city') }}"
                                class="w-full h-12 px-4 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white @error('city') border-red-500 @enderror"
                                placeholder="Sana'a">
                            @error('city') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Order Notes <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                            </label>
                            <textarea 
                                name="notes" 
                                rows="2"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-900/30 transition-all outline-none text-gray-900 dark:text-white resize-none"
                                placeholder="Any special instructions?">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Payment Methods -->
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Payment Method
                            </h3>

                            <div class="space-y-3">
                                <!-- Cash on Delivery -->
                                <label class="relative flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary-300 dark:hover:border-primary-700 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 dark:has-[:checked]:bg-primary-900/20 has-[:checked]:shadow-lg has-[:checked]:shadow-primary-100 dark:has-[:checked]:shadow-primary-900/30">
                                    <input type="radio" name="payment_method" value="cod" {{ old('payment_method','cod')==='cod' ? 'checked' : '' }} class="w-5 h-5 text-primary-600 focus:ring-primary-500 focus:ring-2">
                                    <div class="ml-4 flex items-center flex-1">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">Cash on Delivery</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Pay when you receive</div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Stripe -->
                                <label class="relative flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary-300 dark:hover:border-primary-700 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 dark:has-[:checked]:bg-primary-900/20 has-[:checked]:shadow-lg has-[:checked]:shadow-primary-100 dark:has-[:checked]:shadow-primary-900/30">
                                    <input type="radio" name="payment_method" value="stripe" {{ old('payment_method')==='stripe' ? 'checked' : '' }} class="w-5 h-5 text-primary-600 focus:ring-primary-500 focus:ring-2">
                                    <div class="ml-4 flex items-center flex-1">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">Credit/Debit Card</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Powered by Stripe</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 ml-auto">
                                        <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="currentColor"><path d="M15.245 2.25h4.505v1.5h-4.505zM9.75 18h4.5v1.5h-4.5z"/><path d="M0 7.5v9h24v-9H0zm21.75 7.5H2.25v-6h19.5v6z"/></svg>
                                        <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5.69h-2.12v1.06c-1.51.37-2.7 1.29-2.7 2.77 0 1.78 1.46 2.73 3.59 3.25 1.9.46 2.28 1.14 2.28 1.86 0 .57-.4 1.43-2.1 1.43-1.69 0-2.26-.77-2.35-1.64H7.82c.1 1.6 1.24 2.65 2.87 2.99v1.06h2.12v-1.05c1.51-.38 2.7-1.32 2.7-2.81-.01-2.17-1.76-2.94-3.2-3.32z"/></svg>
                                    </div>
                                </label>

                                <!-- PayPal -->
                                <label class="relative flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary-300 dark:hover:border-primary-700 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 dark:has-[:checked]:bg-primary-900/20 has-[:checked]:shadow-lg has-[:checked]:shadow-primary-100 dark:has-[:checked]:shadow-primary-900/30">
                                    <input type="radio" name="payment_method" value="paypal" {{ old('payment_method')==='paypal' ? 'checked' : '' }} class="w-5 h-5 text-primary-600 focus:ring-primary-500 focus:ring-2">
                                    <div class="ml-4 flex items-center flex-1">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-1.12 7.107h4.605c.456 0 .863-.332.936-.783l1.034-6.558c.073-.451.48-.783.936-.783h1.88c3.76 0 6.705-1.528 7.572-5.946.633-3.226-.083-5.41-1.618-6.957z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">PayPal</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Fast & secure</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            @error('payment_method') 
                            <div class="flex items-center text-sm text-red-600 dark:text-red-400 mt-3">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Security Badge -->
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400 py-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Secure SSL Encrypted Checkout</span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full h-14 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-lg font-black rounded-xl shadow-2xl shadow-primary-400/50 dark:shadow-primary-900/50 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center group">
                            <span>Complete Order</span>
                            <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </button>

                        <!-- Estimated Delivery -->
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400 pt-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Estimated delivery: 3-5 business days
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
