@extends('dsadmin.layouts.app')

@section('page_title', 'الأقسام')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">Categories</h3>
            <small class="text-muted">Categories Management</small>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                + Add Category
        </a>
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
                            <th>اسم القسم</th>
                            <th class="text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td class="fw-semibold">{{ $cat->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary">
                                        تعديل
                                    </a>

                                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('هل أنت متأكد من حذف القسم؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    لا توجد أقسام بعد
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>

        </div>
        <div class="card-footer clearfix">
		    <ul class="pagination pagination m-0 float-right">
				<li class="page-item"><a class="page-link" href="#">«</a></li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">»</a></li>
			</ul>
        </div>
    </div>

</div>
@endsection
