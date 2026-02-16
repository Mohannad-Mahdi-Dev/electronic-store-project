@extends('front.layouts.app')

@section('title', 'Search: ' . $query)

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Search Results</h1>
        <p class="text-gray-400 mt-2">Results for "{{ $query }}"</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Again -->
    <div class="mb-8">
        <form action="{{ route('shop.search') }}" method="GET" class="max-w-xl">
            <div class="flex gap-2">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search products..."
                       class="flex-1 px-6 py-3 border border-gray-200 rounded-full focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none">
                <button type="submit" class="px-8 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors">
                    Search
                </button>
            </div>
        </form>
    </div>
    
    @if($products->count() > 0)
    <p class="text-gray-600 mb-6">
        Found <span class="font-semibold text-gray-900">{{ $products->total() }}</span> products
    </p>
    
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No results found</h3>
        <p class="text-gray-600 mb-6">We couldn't find any products matching "{{ $query }}"</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors">
            Browse All Products
        </a>
    </div>
    @endif
</div>
@endsection
