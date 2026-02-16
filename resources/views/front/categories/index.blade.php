@extends('front.layouts.app')

@section('title', 'Categories')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Browse Categories</h1>
        <p class="text-gray-400 mt-2">Explore our product categories</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($categories->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
        <a href="{{ route('category.show', $category->slug ?? $category->id) }}" class="group">
            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                <!-- Category Image/Icon -->
                <div class="h-48 bg-gradient-to-br from-primary-500 to-accent-600 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <img src="{{ asset('admin-assets/img/img.png') }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    <!-- Decorative blur -->
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>
                
                <!-- Category Info -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                        {{ $category->name }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ $category->products_count ?? 0 }} {{ Str::plural('product', $category->products_count ?? 0) }}
                        </span>
                        <span class="text-primary-600 dark:text-primary-400 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                            Browse
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No categories found</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Check back later for new categories</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors">
            Browse All Products
        </a>
    </div>
    @endif
</div>
@endsection
