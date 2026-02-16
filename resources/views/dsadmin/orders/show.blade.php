@extends('dsadmin.layouts.app')

@section('page_title', 'تفاصيل الطلب')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">طلب رقم #{{ $order->id }}</h3>
            <small class="text-muted">العميل: {{ $order->user->name ?? '-' }} — {{ $order->user->email ?? '' }}</small>
        </div>

        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">رجوع</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">ملخص مالي</h6>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Discount</span>
                        <span>${{ number_format($order->discount, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>

                    <hr>
                    <div class="text-muted small">
                        تم الإنشاء: {{ $order->created_at }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">تغيير الحالة</h6>

                    <form method="POST" action="{{ route('orders.status', $order) }}">
                        @csrf
                        @method('PATCH')

                        <select name="status" class="form-select mb-3">
                            @foreach(['pending','confirmed','cancelled','completed'] as $st)
                                <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary w-100">تحديث</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
