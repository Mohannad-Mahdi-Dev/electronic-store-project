@extends('dsadmin.layouts.app')

@section('page_title', 'Brands')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Brands</h3>
            <small class="text-muted">Brands Management</small>
        </div>

        <a href="{{ route('dsadmin.brands.create') }}" class="btn btn-primary">
            + Add Brand
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search & Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('dsadmin.brands.index') }}">
                <div class="row g-3 align-items-end">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label">بحث بالاسم</label>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="اكتب اسم الماركة..."
                        >
                    </div>

                    {{-- Filter --}}
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="is_visible" class="form-select">
                            <option value="">الكل</option>
                            <option value="1" {{ request('is_visible') === '1' ? 'selected' : '' }}>
                                ظاهرة
                            </option>
                            <option value="0" {{ request('is_visible') === '0' ? 'selected' : '' }}>
                                مخفية
                            </option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-3">
                        <button class="btn btn-primary me-2" type="submit">
                            بحث
                        </button>

                        <a href="{{ route('dsadmin.brands.index') }}"
                           class="btn btn-outline-secondary">
                            إعادة تعيين
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th class="text-end">الإجراءات</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>

                        <td class="fw-semibold">
                            {{ $brand->name }}
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($brand->description, 50) }}
                        </td>

                        <td>
                            @if($brand->is_visible)
                                <span class="badge bg-success">ظاهرة</span>
                            @else
                                <span class="badge bg-secondary">مخفية</span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('dsadmin.brands.edit', $brand) }}"
                               class="btn btn-sm btn-outline-primary">
                                تعديل
                            </a>

                            <a href="{{ route('dsadmin.brands.toggle', $brand) }}"
                               class="btn btn-sm btn-outline-warning">
                                تبديل الحالة
                            </a>

                            <form action="{{ route('dsadmin.brands.destroy', $brand) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            لا توجد علامات تجارية بعد
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $brands->links() }}
    </div>

</div>
@endsection
