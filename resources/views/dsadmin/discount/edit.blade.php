@extends('dsadmin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Edit Coupon</h4>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Back</a>
    </div>
    <form method="POST" action="{{ route('admin.coupons.update', ['coupon' => $coupon->id])}}">
        @csrf @method('PUT')
        @include('dsadmin.discount._form', ['coupon' => $coupon])
    </form>
</div>
@endsection
