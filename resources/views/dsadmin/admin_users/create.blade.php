@extends('dsadmin.layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">{{ $title }}</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ $role == 1 ? url('/super-admins') : url('/sub-admins') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الإيميل</label>
            <input name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-success">حفظ</button>

        <a class="btn btn-secondary"
            href="{{ $role == 1 ? url('/super-admins') : url('/sub-admins') }}">
            رجوع
        </a>
    </form>

</div>
@endsection