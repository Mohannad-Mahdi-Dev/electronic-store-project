@extends('dsadmin.layouts.app')

@section('page_title', 'تعديل قسم')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">تعديل قسم</h3>
            <small class="text-muted">عدّل بيانات القسم</small>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">رجوع</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="mb-3">
                    <label class="form-label">اسم القسم</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">تحديث</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
