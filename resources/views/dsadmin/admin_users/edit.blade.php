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
{{-- 
    <form method="POST"
        action="{{ $role == 1 ? url('/super-admins/'.$user->id) : url('/sub-admins/'.$user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">الإيميل</label>
            <input name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <hr>
        <p class="text-muted">اترك كلمة المرور فارغة إذا لا تريد تغييرها</p>

        <div class="mb-3">
            <label class="form-label">كلمة المرور الجديدة</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-success">تحديث</button>

        <a class="btn btn-secondary"
            href="{{ $role == 1 ? url('/super-admins') : url('/sub-admins') }}">
            رجوع
        </a>
    </form> --}}

    <form method="POST" action="{{ $role == 1 ? route('super-admins.update', $user->id) : route('sub-admins.update', $user->id) }}">
    @csrf
    @method('PUT')

    {{-- باقي الحقول كما هي ... --}}
    <div class="mb-3">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ old('name', $user->name) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">الإيميل</label>
        <input name="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <hr>
    <p class="text-muted">اترك كلمة المرور فارغة إذا لا تريد تغييرها</p>

    <div class="mb-3">
        <label class="form-label">كلمة المرور الجديدة</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <button class="btn btn-success">تحديث</button>
    
    <a class="btn btn-secondary" 
       href="{{ $role == 1 ? route('super-admins.index') : route('sub-admins.index') }}">
        رجوع
    </a>

</form>

</div>
@endsection