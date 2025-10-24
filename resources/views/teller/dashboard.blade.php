@extends('layouts.teller')

@section('title', 'Teller Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📋 My POS Onboarding Requests</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Store Name</th>
                        <th>POS Serial</th>
                        <th>Business Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td>{{ $req->id }}</td>
                            <td>{{ $req->store_name }}</td>
                            <td>{{ $req->pos_serial }}</td>
                            <td>{{ $req->business_type }}</td>
                            <td>
                                <span class="badge
                                    @if($req->approval_status == 'approved') bg-success
                                    @elseif($req->approval_status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($req->approval_status ?? 'pending') }}
                                </span>
                            </td>
                            <td>{{ $req->created_at->format('Y-m-d') }}</td>
                         <td>
    <a href="{{ route('teller.requests.show', $req->id) }}" class="btn btn-sm btn-primary">
        🔍 View
    </a>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No requests yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ปุ่มสร้างฟอร์มใหม่ -->
    <div class="text-end">
        <a href="{{ route('teller.requests.create') }}" class="btn btn-success btn-lg">
            ➕ Create New Onboarding Form
        </a>
    </div>
</div>
@endsection
