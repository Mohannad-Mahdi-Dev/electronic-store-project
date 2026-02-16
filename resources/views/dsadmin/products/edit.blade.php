@extends('dsadmin.layouts.app')

@section('page_title', 'تعديل منتج')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">تعديل منتج</h3>
            <small class="text-muted">عدّل بيانات المنتج</small>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">رجوع</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- رسائل الأخطاء --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-semibold mb-2">يوجد أخطاء:</div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- رسالة نجاح --}}
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif


            {{-- ✅ الصور الحالية (خارج فورم التحديث لتجنب nested forms) --}}
            @if($product->images && $product->images->count())
            <div class="mb-4">
                <div class="fw-semibold mb-2">الصور الحالية</div>

                <div class="d-flex flex-wrap gap-3">
                    @foreach($product->images as $img)
                    <div class="border rounded p-2 text-center" style="width: 170px;">
                        <img
                            src="{{ asset('storage/'.$img->path) }}"
                            alt="product image"
                            style="width:150px;height:150px;object-fit:cover;border-radius:10px;">

                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            @if($img->is_main)
                            <span class="badge bg-success">رئيسية</span>
                            @else
                            <span class="badge bg-secondary">صورة</span>
                            @endif

                           
                            <form action="{{ route('products.images.delete', $img->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('هل تريد حذف هذه الصورة؟')">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="alert alert-info mb-4">
                لا توجد صور لهذا المنتج حتى الآن.
            </div>
            @endif


            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- القسم --}}
                <div class="mb-3">
                    <label class="form-label">القسم</label>
                    <select name="category_id" class="form-select">
                        <option value="">بدون قسم</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- العلامة التجارية --}}
                <div class="mb-3">
                    <label class="form-label">العلامة التجارية</label>
                    <select name="brand_id" class="form-select">
                        <option value="">بدون علامة تجارية</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- اسم المنتج --}}
                <div class="mb-3">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                {{-- الوصف --}}
                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- SKU --}}
                <div class="mb-3">
                    <label class="form-label">SKU (اختياري)</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" placeholder="مثال: IP15PRO-256">
                </div>

                {{-- السعر والمخزون --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">السعر</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">المخزون</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->qty) }}" required>
                    </div>
                </div>

                {{-- الصور --}}
                <div class="mb-3 mt-3">
                    <label class="form-label">إضافة صور جديدة (يمكن اختيار أكثر من صورة)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">الحد الأقصى 2MB لكل صورة (jpg/png/webp)</small>
                </div>

                {{-- الحالة --}}
                <input type="hidden" name="is_active" value="0">
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">نشط</label>
                </div>

                {{-- أزرار الحفظ --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">تحديث المنتج</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection