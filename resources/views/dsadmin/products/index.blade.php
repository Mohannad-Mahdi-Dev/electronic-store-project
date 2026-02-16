@extends('dsadmin.layouts.app')

@section('page_title', 'المنتجات')


@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">{{ __('messages.products') }}</h3>
            <small class="text-muted">{{ __('messages.products_management') }}</small>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ {{ __('messages.add_product') }}</a>
    </div>
    {{-- Alerts --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Search & Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row g-3 align-items-end">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('messages.search_by_name_or_sku') }}</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('messages.search_by_name_or_sku') }}">
                    </div>

                    {{-- القسم --}}
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.category') }}</label>
                        <select name="category_id" class="form-select">
                            <option value="">{{ __('messages.all') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- العلامة التجارية --}}
                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.brand') }}</label>
                        <select name="brand_id" class="form-select">
                            <option value="">{{ __('messages.all') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- الحالة --}}
                    <div class="col-md-2">
                        <label class="form-label">{{ __('messages.status') }}</label>
                        <select name="is_active" class="form-select">
                            <option value="">{{ __('messages.all') }}</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary me-2" type="submit"> {{ __('messages.search') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">{{ __('messages.reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>صورة</th>
                            <th>اسم المنتج</th>
                            <th>القسم</th>
                            <th>العلامة التجارية</th>
                            <th>السعر</th>
                            <th>المخزون</th>
                            <th>الحالة</th>
                            <th class="text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>

                                {{-- صورة أولى --}}
                                <td>
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ asset('storage/' . $product->images[0]->path) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width:50px; height:50px; object-fit:cover;">
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- اسم المنتج --}}
                                <td class="fw-semibold">
                                    {{ $product->name }}
                                    @if(!empty($product->sku))
                                        <div class="text-muted small">SKU: {{ $product->sku }}</div>
                                    @endif
                                </td>

                                {{-- القسم --}}
                                <td>{{ $product->category ? $product->category->name : 'بدون قسم' }}</td>

                                {{-- العلامة التجارية --}}
                                <td>{{ $product->brand ? $product->brand->name : 'بدون علامة تجارية' }}</td>

                                {{-- السعر --}}
                                <td>${{ number_format($product->price, 2) }}</td>

                                {{-- المخزون --}}
                                <td>
                                    @if($product->stock == 0)
                                        <span class="badge bg-danger">نفذ</span>
                                    @elseif($product->stock < 5)
                                        <span class="badge bg-warning text-dark">قليل</span>
                                    @else
                                        <span class="badge bg-success">متوفر</span>
                                    @endif
                                    <span class="text-muted">({{ $product->stock }})</span>
                                </td>

                                {{-- الحالة --}}
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </td>

                                {{-- الإجراءات --}}
                                <td class="text-end">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">تعديل</a>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('هل أنت متأكد من حذف المنتج؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    لا يوجد منتجات بعد
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
