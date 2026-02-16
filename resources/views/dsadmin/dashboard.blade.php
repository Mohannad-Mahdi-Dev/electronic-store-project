@extends('dsadmin.layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted">إحصائيات سريعة + آخر الطلبات</div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Row 1: Top Statistics (4 Boxes) -->
            <div class="row">
                <!-- Box 1: Orders -->
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <div class="fs-2 fw-bold">{{ $ordersCount }}</div>
                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ url('/orders')}}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Box 2: Customers -->
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <div class="fs-2 fw-bold">{{ $customersCount }}</div>
                            <p>Total Customers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ url('/customers') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Box 3: Total Sale -->
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <div class="fs-2 fw-bold">{{ number_format($totalSales, 2) }}</div>
                            <p>Total Sale</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ url('/orders') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Box 4: Total Products -->
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <div class="fs-2 fw-bold">{{ $productsCount }}</div>
                            <p>Total Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ url('/products') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Row 2: Status Summary -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">ملخص حالات الطلبات</h6>
                            @php
                                $pending   = $ordersByStatus['pending']   ?? 0;
                                $confirmed = $ordersByStatus['confirmed'] ?? 0;
                                $completed = $ordersByStatus['completed'] ?? 0;
                                $cancelled = $ordersByStatus['cancelled'] ?? 0;
                            @endphp
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary px-3 py-2">Pending: {{ $pending }}</span>
                                <span class="badge bg-primary px-3 py-2">Confirmed: {{ $confirmed }}</span>
                                <span class="badge bg-success px-3 py-2">Completed: {{ $completed }}</span>
                                <span class="badge bg-danger px-3 py-2">Cancelled: {{ $cancelled }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Latest Orders Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <span class="fw-bold">آخر الطلبات</span>
                            <a href="{{ url('/dsadmin/orders') }}" class="small text-decoration-none">عرض الكل</a>
                        </div>
                        <div class="card-body p-0"> <!-- p-0 to make table fit nicely -->
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>العميل</th>
                                            <th>الإجمالي</th>
                                            <th>الحالة</th>
                                            <th>تاريخ</th>
                                            <th class="text-end">عرض</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestOrders as $o)
                                            <tr>
                                                <td>{{ $o->id }}</td>
                                                <td>{{ $o->user->name ?? '-' }}</td>
                                                <td>${{ number_format($o->total, 2) }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($o->status=='pending') bg-secondary
                                                        @elseif($o->status=='confirmed') bg-primary
                                                        @elseif($o->status=='completed') bg-success
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $o->status }}
                                                    </span>
                                                </td>
                                                <td class="text-muted">{{ $o->created_at->format('Y-m-d') }}</td>
                                                    <td class="text-end">
                                                 <a class="btn btn-sm btn-outline-primary"
                                                     href="{{ route('orders.show', $o->id) }}">
                                                    <i class="fas fa-eye"></i> فتح
                                                </a>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    لا يوجد طلبات بعد
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('customJs')
<script>
    console.log('Dashboard Loaded');
</script>
@endsection
