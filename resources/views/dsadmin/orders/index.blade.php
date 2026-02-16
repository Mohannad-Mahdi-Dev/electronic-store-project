@extends('dsadmin.layouts.app')

@section('page_title', 'الطلبات')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">Orders</h3>
            <small class="text-muted">Orders Management</small>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الإجمالي</th>
                            <th>الحالة</th>
                            <th>تاريخ</th>
                            <th class="text-end">إجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="fw-semibold">{{ $order->user->name ?? '-' }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($order->status=='pending') bg-secondary
                                        @elseif($order->status=='confirmed') bg-primary
                                        @elseif($order->status=='completed') bg-success
                                        @else bg-danger
                                        @endif
                                    ">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $order->created_at->format('Y-m-d') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        عرض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    لا يوجد طلبات حالياً
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
