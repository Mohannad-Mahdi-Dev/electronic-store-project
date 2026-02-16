@extends('dsadmin.layouts.app') {{--  غيّر هذا المسار حسب هيكل مشروعك --}}

{{-- العنوان الديناميكي لصفحة المتصفح --}}
@section('title', $brand->name)

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- ======================= قسم رأس الصفحة (تفاصيل الماركة) ======================= --}}
    <div class="brand-header flex flex-col md:flex-row items-center border-b pb-8 mb-8">
        {{-- شعار الماركة --}}
        @if($brand->logo)
            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }} Logo" class="h-24 w-auto object-contain mb-4 md:mb-0 md:mr-8 flex-shrink-0">
        @endif
        
        <div class="text-center md:text-right">
            {{-- اسم الماركة --}}
            <h1 class="text-4xl font-bold">{{ $brand->name }}</h1>
            
            {{-- وصف الماركة (يظهر فقط إذا كان موجوداً) --}}
            @if($brand->description)
                <p class="mt-2 text-gray-600 max-w-2xl">{{ $brand->description }}</p>
            @endif
        </div>
    </div>

    {{-- ======================= قسم المنتجات ======================= --}}
    <h2 class="text-2xl font-bold mb-6">منتجات ماركة {{ $brand->name }}</h2>

    @forelse ($products as $product)
        {{-- شبكة عرض المنتجات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- بطاقة المنتج --}}
            {{-- نفترض أن لديك رابط لصفحة المنتج اسمه 'products.show' --}}
            <a href="#" class="product-card block border rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                
                {{-- صورة المنتج (نفترض أن حقل الصورة في جدول المنتجات اسمه cover_image) --}}
                <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                
                <div class="p-4">
                    {{-- اسم المنتج --}}
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                    
                    {{-- سعر المنتج (نفترض أن الحقل اسمه price) --}}
                    <p class="text-blue-600 font-bold mt-2">{{ number_format($product->price, 2) }} ريال</p>
                </div>
            </a>
        
        </div>
    @empty
        {{-- رسالة في حال عدم وجود منتجات لهذه الماركة --}}
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <p class="text-xl text-gray-500">عذراً، لا توجد منتجات تابعة لهذه الماركة حالياً.</p>
        </div>
    @endforelse

    {{-- ======================= قسم ترقيم الصفحات (Pagination) ======================= --}}
    <div class="mt-8">
        {{-- هذا السطر الصغير سيقوم بعرض أزرار التنقل بين الصفحات تلقائياً --}}
        {{ $products->links() }}
    </div>

</div>
@endsection
