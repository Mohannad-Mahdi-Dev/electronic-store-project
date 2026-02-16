@extends('front.layouts.app')

@section('title', 'Shop')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Shop All Products</h1>
        <p class="text-gray-400 mt-2">Discover our complete collection</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24 transition-colors duration-300">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Filters</h3>
                
                <form action="{{ route('shop.index') }}" method="GET">
                    <!-- Categories -->
                    @if($categories->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Categories</h4>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="category" value="{{ $category->id }}" 
                                       {{ request('category') == $category->id ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-600 focus:ring-primary-500">
                                <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Brands -->
                    @if($brands->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Brands</h4>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="brand" value="{{ $brand->id }}" 
                                       {{ request('brand') == $brand->id ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-600 focus:ring-primary-500">
                                <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $brand->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Price Range</h4>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" step="0.01" placeholder="Min" value="{{ request('min_price') }}"
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:border-primary-500 outline-none bg-white dark:bg-gray-700 dark:text-gray-100">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="max_price" step="0.01" placeholder="Max" value="{{ request('max_price') }}"
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:border-primary-500 outline-none bg-white dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                        Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['category', 'brand', 'min_price', 'max_price']))
                    <a href="{{ route('shop.index') }}" class="block w-full py-2 text-center text-gray-600 dark:text-gray-400 hover:text-primary-600 mt-2 text-sm">
                        Clear All Filters
                    </a>
                    @endif
                </form>
            </div>
        </aside>
        
        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Sort & Results Info -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <p class="text-gray-600 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $products->count() }}</span> of 
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $products->total() }}</span> products
                </p>
                
                <form action="{{ route('shop.index') }}" method="GET" class="flex items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-gray-400">Sort by:</label>
                    <select name="sort" onchange="this.form.submit()" 
                            class="px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:border-primary-500 outline-none bg-white dark:bg-gray-700 dark:text-gray-100">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </form>
            </div>
            
            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
                @include('front.partials.product-card', ['product' => $product])
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->withQueryString()->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No products found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Try adjusting your filters or browse all products</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors">
                    View All Products
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
