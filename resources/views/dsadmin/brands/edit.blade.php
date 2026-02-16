@extends('dsadmin.layouts.app')

@section('page_title', 'Edit Brand')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">تعديل الماركة</h3>
            <small class="text-muted">إدارة العلامات التجارية</small>
        </div>
        <a href="{{ route('dsadmin.brands.index') }}" class="btn btn-secondary">
            رجوع
        </a>
    </div>

    {{-- Form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dsadmin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">اسم الماركة</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $brand->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        required
                    >{{ old('description', $brand->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Visibility --}}
                <div class="mb-3">
                    <label class="form-label">الحالة</label>
                    <select
                        name="is_visible"
                        class="form-select @error('is_visible') is-invalid @enderror"
                        required
                    >
                        <option value="1" {{ old('is_visible', $brand->is_visible) == 1 ? 'selected' : '' }}>
                            ظاهرة
                        </option>
                        <option value="0" {{ old('is_visible', $brand->is_visible) == 0 ? 'selected' : '' }}>
                            مخفية
                        </option>
                    </select>
                    @error('is_visible')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        تحديث الماركة
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection