@extends('dsadmin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Create Coupon</h4>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.coupons.store') }}">
        @csrf
        @include('dsadmin.discount._form')
    </form>
</div>
@endsection
