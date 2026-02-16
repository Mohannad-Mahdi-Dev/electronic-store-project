<!-- Product Card Component -->
<div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-gray-900/30 transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
    <!-- Product Image -->
    <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
        @if($product->images && $product->images->count() > 0)
            <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                 alt="{{ $product->title }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @elseif($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->title }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        {{-- @php 
        // 1. نبحث عن الصورة المشر عليها بأنها رئيسية، إذا لم توجد نأخذ أول صورة من جدول الصور
        $mainImage = $product->images->where('is_main', true)->first() ?? $product->images->first(); 
        @endphp --}}

        {{-- @if($mainImage) --}}
            {{-- عرض الصورة من جدول الصور الإضافية --}}
            {{-- <img src="{{ asset('storage/' . $mainImage->path) }}" 
                   alt="{{ $product->name }}" 
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
             
        @elseif($product->image) --}}
            {{-- خيار احتياطي: عرض الصورة من حقل image الأساسي في جدول المنتجات --}}
            {{-- <img src="{{ asset('storage/' . $product->image) }}" 
                alt="{{ $product->name }}" 
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
             
    @else --}}
        {{-- في حال عدم وجود أي صورة، نعرض أيقونة افتراضية --}}
        {{-- <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
            <svg class="w-16 h-16 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    @endif --}}

    {{-- يمكنك هنا إضافة badge "خصم" أو "مميز" فوق الصورة --}}
    {{-- @if($product->compare_price > $product->price)
        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">
            {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
        </span>
    @endif --}}

        <!-- Wishlist Button -->
        @auth
            @php
                $isFavorite = auth()->user()->wishlistItems->contains($product->id);
            @endphp
            <form action="{{ route('wishlist.store') }}" method="POST" class="absolute top-4 right-4 z-20">
                @csrf   
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit"
                        class="w-10 h-10 flex items-center justify-center bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-full shadow transition-all duration-300 hover:scale-110 {{ $isFavorite ? 'text-red-500' : 'text-gray-500 dark:text-gray-400 hover:text-red-500' }}"
                        aria-label="Add to wishlist">
                    <svg class="w-5 h-5 {{ $isFavorite ? 'fill-current' : '' }}" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-full shadow text-gray-500 dark:text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
        @endauth

        <!-- Quick actions overlay -->
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}" 
               class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                View Details
            </a>
        </div>
        
        <!-- Badges -->
        @if($product->is_featured || $product->status == 1)
        <div class="absolute top-4 left-4">
            <span class="px-3 py-1 bg-gradient-to-r from-primary-500 to-accent-600 text-white text-xs font-semibold rounded-full">
                Featured
            </span>
        </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-5">
        <!-- Category -->
        @if($product->categorie)
        <p class="text-xs font-medium text-primary-600 dark:text-primary-400 uppercase tracking-wide mb-2">
            {{ $product->categorie->name }}
        </p>
        @endif
        
        {{-- Brand --}}
        @if($product->brand)
        <p class="text-xs font-medium text-primary-600 dark:text-primary-400 uppercase tracking-wide mb-2">
            {{ $product->brand->name }}
        </p>
        @endif
        
        
        <!-- Title -->
        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
            <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                {{ $product->name }}
            </a>
        </h3>
        
        <!-- Price -->
        <div class="flex items-center justify-between">
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                @if($product->compare_price && $product->compare_price > $product->price)
                <span class="text-sm text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                @endif
            </div>
            
            <!-- Rating placeholder -->
            <div class="flex items-center text-yellow-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">4.5</span>
            </div>
            </div>
           
        <form action="{{ route('cart.add') }}" method="POST" class="pt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="flex items-center gap-4">
                <button type="submit" class="flex-1 px-8 py-4 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Add to Cart
                </button>
            </div>
        </form>
</div>
</div>
