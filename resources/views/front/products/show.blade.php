@extends('front.layouts.app')

@section('title', $product->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600">Home</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('shop.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600">Shop</a></li>
            @if($product->categorie)
            <li><span class="text-gray-400">/</span></li>
            <li><a href="{{ route('category.show', $product->categorie->slug ?? $product->categorie->id) }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600">{{ $product->categorie->name }}</a></li>
            @endif
            <li><span class="text-gray-400">/</span></li>
            <li><span class="text-gray-900 dark:text-gray-100 font-medium">{{ Str::limit($product->title, 30) }}</span></li>
        </ol>
    </nav>
    
    <!-- Product Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div x-data="{ activeImage: 0 }" class="space-y-4">
            <!-- Main Image -->
            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                @if($product->images && $product->images->count() > 0)
                    @foreach($product->images as $index => $image)
                    <img x-show="activeImage === {{ $index }}" 
                         src="{{ asset('storage/' . $image->path) }}" 
                         alt="{{ $product->title }}" 
                         class="w-full h-full object-cover"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                    @endforeach
                @elseif($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Thumbnails -->
            @if($product->images && $product->images->count() > 1)
            <div class="flex gap-3 overflow-x-auto pb-2">
                @foreach($product->images as $index => $image)
                <button @click="activeImage = {{ $index }}" 
                        :class="{ 'ring-2 ring-primary-500': activeImage === {{ $index }} }"
                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 hover:border-primary-500 transition-colors">
                    <img src="{{ asset('storage/' . $image->path) }}" 
                         alt="Thumbnail {{ $index + 1 }}" 
                         class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="space-y-6">
            <!-- Category & Brand -->
            <div class="flex items-center gap-3">
                @if($product->categorie)
                <a href="{{ route('category.show', $product->categorie->slug ?? $product->categorie->id) }}" 
                   class="px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 text-sm font-medium rounded-full hover:bg-primary-200 dark:hover:bg-primary-900/50 transition-colors">
                    {{ $product->categorie->name }}
                </a>
                @endif
                @if($product->brand)
                <span class="text-gray-500 dark:text-gray-400 text-sm">by {{ $product->brand->name }}</span>
                @endif
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $product->title }}</h1>
            
            <!-- Rating (placeholder) -->
            <div class="flex items-center gap-2">
                <div class="flex text-yellow-400">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">(24 reviews)</span>
            </div>
            
            <!-- Price -->
            <div class="flex items-baseline gap-4">
                <span class="text-4xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                @if($product->compare_price && $product->compare_price > $product->price)
                <span class="text-xl text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                    Save {{ round((1 - $product->price / $product->compare_price) * 100) }}%
                </span>
                @endif
            </div>
            
            <!-- Description -->
            <div class="prose prose-gray dark:prose-invert max-w-none">
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $product->description }}</p>
            </div>
            
            <!-- Stock Status -->
            <div class="flex items-center gap-2">
                @if($product->qty > 0)
                <div class="flex items-center gap-2 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">In Stock</span>
                    <span class="text-gray-500 dark:text-gray-400">({{ $product->qty }} available)</span>
                </div>
                @else
                <div class="flex items-center gap-2 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-medium">Out of Stock</span>
                </div>
                @endif
            </div>
            
            <!-- Add to Cart -->
            <form action="{{ route('cart.add') }}" method="POST" class="pt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex items-center gap-4">
                    <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg" x-data="{ qty: 1 }">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-4 py-3 text-gray-600 dark:text-gray-300 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" name="quantity" x-model="qty" min="1" class="w-16 text-center border-x border-gray-200 dark:border-gray-600 py-3 outline-none bg-transparent dark:text-white">
                        <button type="button" @click="qty++" class="px-4 py-3 text-gray-600 dark:text-gray-300 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                    
                    <button type="submit" class="flex-1 px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Add to Cart
                    </button>
                    
                    <button type="button" class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-300 hover:text-red-500 hover:border-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </form>
            
            <!-- SKU -->
            @if($product->sku)
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">SKU: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $product->sku }}</span></p>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-20">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            @include('front.partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
        
    </section>
    @endif
</div>
@endsection
