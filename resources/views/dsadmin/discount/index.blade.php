@extends('dsadmin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Coupons</h4>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">New Coupon</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Code</th><th>Type</th><th>Value</th><th>Min Cart</th><th>Expiry</th>
                <th>Limit</th><th>Used</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coupons as $c)
            <tr>
                <td>{{ $c->code }}</td>
                <td>{{ $c->type }}</td>
                <td>{{ $c->value }}</td>
                <td>{{ $c->cart_value ?? '-' }}</td>
                <td>{{ $c->expiry_date ?? '-' }}</td>
                <td>{{ $c->usage_limit ?? '-' }}</td>
                <td>{{ $c->used_count }}</td>
                <td>{{ $c->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="d-flex gap-1">
                    <a class="btn btn-sm btn-warning" href="{{ route('admin.coupons.edit', $c) }}">Edit</a>

                    <form method="POST" action="{{ route('admin.discounts.toggle', $c) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-info" type="submit">
                            {{ $c->is_active ? 'Disable' : 'Enable' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}"
                          onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $coupons->links() }}
</div>
@endsection
