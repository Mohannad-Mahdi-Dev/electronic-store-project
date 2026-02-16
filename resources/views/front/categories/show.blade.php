@extends('front.layouts.app')

@section('title', $category->name)

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('category.index') }}" class="hover:text-white">Categories</a></li>
                <li><span>/</span></li>
                <li><span class="text-white">{{ $category->name }}</span></li>
            </ol>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $category->name }}</h1>
        <p class="text-gray-400 mt-2">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($products->count() > 0)
    <!-- Sort -->
    <div class="flex justify-end mb-8">
        <form action="{{ route('category.show', $category->slug ?? $category->id) }}" method="GET" class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Sort by:</label>
            <select name="sort" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary-500 outline-none bg-white">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
            </select>
        </form>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No products in this category</h3>
        <p class="text-gray-600 mb-6">Check back later for new products</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors">
            Browse All Products
        </a>
    </div>
    @endif
</div>
@endsection
