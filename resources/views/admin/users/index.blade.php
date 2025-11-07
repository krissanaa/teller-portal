@extends('layouts.admin')

@section('title', 'Teller Management')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">👨‍💼 Teller Management</h4>

    <form method="GET" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="🔍 ค้นหาชื่อ / อีเมล / เบอร์โทร">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $u->id) }}" class="text-decoration-none fw-bold">
                                    {{ $u->name }}
                                </a>
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone }}</td>
                            <td>
                                <span class="badge
                                    @if($u->status == 'approved') bg-success
                                    @elseif($u->status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($u->status) }}
                                </span>
                            </td>
                            <td>{{ $u->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($u->status !== 'approved')
                                    <form action="{{ route('admin.users.updateStatus', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-success">✅ Approve</button>
                                    </form>
                                @endif

                                @if($u->status !== 'rejected')
                                    <form action="{{ route('admin.users.updateStatus', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger">❌ Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $users->links() }}</div>
        </div>
    </div>
</div>
@endsection
