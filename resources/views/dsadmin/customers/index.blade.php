@extends('dsadmin.layouts.app')

@section('page_title', 'العملاء')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">Customers</h3>
            <small class="text-muted">قائمة العملاء المسجلين</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الإيميل</th>
                            <th>تاريخ التسجيل</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customers as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td class="fw-semibold">{{ $c->name }}</td>
                                <td>{{ $c->email }}</td>
                                <td class="text-muted">{{ $c->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">لا يوجد عملاء</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $customers->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
