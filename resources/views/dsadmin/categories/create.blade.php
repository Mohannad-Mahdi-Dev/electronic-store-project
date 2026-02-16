@extends('dsadmin.layouts.app')

@section('page_title', 'إضافة قسم')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">إضافة قسم</h3>
            <small class="text-muted">أضف قسم جديد</small>
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

            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">اسم القسم</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">حفظ</button>
                    <button type="reset" class="btn btn-outline-secondary">تفريغ</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
