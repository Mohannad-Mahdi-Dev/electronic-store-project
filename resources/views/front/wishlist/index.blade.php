@extends('front.layouts.app')

@section('content')
    {{-- إضافة خط الأيقونات --}}
    @push('styles')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @endpush

    <main class="bg-gray-50 dark:bg-gray-900 min-h-screen py-10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Alert Messages (رسائل النجاح) --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm animate-fade-in-down">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 space-x-reverse">
                    <li>
                        <a href="{{ url('/') }}" class="hover:text-red-600 transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">home</span>
                            الرئيسية
                        </a>
                    </li>
                    <li class="text-gray-300">/</li>
                    <li class="text-gray-900 font-medium" aria-current="page">قائمة الأمنيات</li>
                </ol>
            </nav>

            {{-- Page Header & Top Actions --}}
            {{-- تم تعديل هذا الجزء ليكون متجاوباً وتظهر الأزرار بجانب بعضها --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">قائمة أمنياتي</h1>
                    <p class="mt-2 text-sm text-gray-500">
                        لديك <span class="font-bold text-red-600">{{ $items->count() }}</span> منتجات مميزة في قائمتك.
                    </p>
                </div>
                
                @if($items->count() > 0)
                    <div class="flex flex-wrap items-center gap-3">
                        {{-- زر تابع التسوق --}}
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition-all">
                            تابع التسوق
                        </a>

                        {{-- زر نقل الكل للسلة --}}
                        <form method="POST" action="{{ route('wishlist.moveAllToCart') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-gray-800 focus:outline-none transition-all">
                                <span class="material-symbols-outlined text-sm ml-2">production_quantity_limits</span>
                                نقل الكل للسلة
                            </button>
                        </form>

                        {{-- زر تنظيف القائمة --}}
                        <form method="POST" action="{{ route('wishlist.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('هل أنت متأكد من حذف القائمة بالكامل؟')"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none transition-all">
                                <span class="material-symbols-outlined text-sm ml-2">delete_sweep</span>
                                تنظيف
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Wishlist Content --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                @if($items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        تفاصيل المنتج
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        السعر
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($items as $product)
                                    @php
                                        $imgSrc = ($product->images && $product->images->count() > 0) ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/150';
                                        $finalPrice = $product->sale_price ?? $product->price;
                                        $hasDiscount = $product->compare_price && $product->compare_price > $finalPrice;
                                        
                                        // حساب نسبة الخصم
                                        $discountPercent = 0;
                                        if($hasDiscount) {
                                            $discountPercent = round((($product->compare_price - $finalPrice) / $product->compare_price) * 100);
                                        }

                                        $isOutOfStock = $product->qty <= 0;
                                    @endphp
                                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        {{-- Product Info --}}
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="relative flex-shrink-0 h-24 w-24 rounded-xl border border-gray-200 overflow-hidden bg-gray-100 group-hover:shadow-md transition-all">
                                                    <img class="h-full w-full object-cover object-center" src="{{ $imgSrc }}" alt="{{ $product->name }}">
                                                    
                                                    @if($hasDiscount)
                                                        <span class="absolute top-0 right-0 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-bl-lg">
                                                            -{{ $discountPercent }}%
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="mr-6">
                                                    <div class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors">
                                                        <a href="{{ route('product.show', $product->slug ?? $product->id) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $product->category?->name ?? 'تصنيف عام' }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 mt-1">
                                                        كود: {{ $product->sku ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Price --}}
                                        <td class="px-6 py-6 whitespace-nowrap text-center">
                                            <div class="text-lg font-bold text-gray-900">
                                                ${{ number_format($finalPrice, 2) }}
                                            </div>
                                            @if($hasDiscount)
                                                <div class="text-sm text-gray-400 line-through mt-1">
                                                    ${{ number_format($product->compare_price, 2) }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Stock Status --}}
                                        <td class="px-6 py-6 whitespace-nowrap text-center">
                                            @if ($isOutOfStock)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full ml-1.5"></span>
                                                    غير متوفر
                                                </span>
                                            @elseif ($product->qty <= 5)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <span class="w-1.5 h-1.5 bg-yellow-600 rounded-full ml-1.5"></span>
                                                    متبقي {{ $product->qty }} فقط
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full ml-1.5"></span>
                                                    متوفر
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-6 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                
                                                {{-- Add to Cart --}}
                                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">

                                                    <button type="submit"
                                                        @if($isOutOfStock) disabled @endif
                                                        class="group/btn relative inline-flex items-center justify-center p-2 rounded-lg 
                                                        {{ $isOutOfStock ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-900 hover:bg-gray-800' }} 
                                                        text-white transition-all shadow-sm hover:shadow-md"
                                                        title="{{ $isOutOfStock ? 'نفذت الكمية' : 'إضافة للسلة' }}">
                                                        
                                                        <span class="material-symbols-outlined text-[20px]">shopping_cart_checkout</span>

                                                        <span class="absolute bottom-full mb-2 hidden group-hover/btn:block w-max bg-black text-white text-xs rounded py-1 px-2">
                                                            {{ $isOutOfStock ? 'غير متوفر' : 'إضافة للسلة' }}
                                                        </span>
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form method="POST" action="{{ route('wishlist.destroy', $product->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="group/btn relative inline-flex items-center justify-center p-2 rounded-lg border border-gray-200 text-gray-500 hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all shadow-sm" title="حذف">
                                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-full p-6 mb-6">
                            <span class="material-symbols-outlined text-6xl text-gray-300">favorite</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">قائمة الأمنيات فارغة</h3>
                        <p class="text-gray-500 max-w-sm mb-8">
                            لم تقم بإضافة أي منتجات إلى القائمة بعد. استعرض المتجر واحفظ ما يعجبك هنا!
                        </p>
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 transition-all transform hover:-translate-y-1">
                            تصفح المنتجات الآن
                        </a>
                    </div>
                @endif
            </div>

            {{-- Want to see more block --}}
            <div class="mt-10 bg-gray-50 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-10 text-center transition-colors duration-300">
                <div class="mx-auto w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-red-500">shopping_bag</span>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">تريد رؤية المزيد؟</h3>
                <p class="text-gray-500 mt-2 max-w-xl mx-auto">
                    استكشف مجموعاتنا المختارة واستمر في حفظ الأماكن والمنتجات التي تحبها في Yemen Trihal.
                </p>
                <a href="{{ url('/') }}"
                    class="inline-flex mt-6 px-6 py-3 rounded-lg border border-red-500 text-red-500 font-bold hover:bg-red-500 hover:text-white transition">
                    متابعة التسوق
                </a>
            </div>
       
        </div>
    </main>

    {{-- Simple Animation Style --}}
    @push('styles')
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    @endpush
@endsection