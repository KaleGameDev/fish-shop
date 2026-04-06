@extends('layouts.warehouse')
@section('title', 'Users')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h3 class="m-0">Danh sách Users</h3>
        <small class="text-muted">Quản lý người dùng (thêm / sửa / xóa)</small>
    </div>

    <a class="btn btn-primary" href="{{ route('users.create') }}">
        <span class="me-1">+</span> Thêm
    </a>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width:160px;">Phone</th>
                    <th style="width:180px;" class="text-end">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="fw-semibold">{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>
                            <a href="mailto:{{ $u->email }}" class="text-decoration-none">
                                {{ $u->email }}
                            </a>
                        </td>
                        <td>{{ $u->phone ?? '-' }}</td>

                        <td class="text-end">
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a class="btn btn-sm btn-outline-warning"
                                   href="{{ route('users.edit', $u) }}">
                                    Sửa
                                </a>

                                <form method="POST"
                                      action="{{ route('users.destroy', $u) }}"
                                      onsubmit="return confirm('Xóa user này?')"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Chưa có user nào. Bấm <b>+ Thêm</b> để tạo user mới.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($users, 'links'))
        <div class="card-body border-top">
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    @endif
</div>
@endsection