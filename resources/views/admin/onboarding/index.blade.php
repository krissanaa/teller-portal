@extends('layouts.admin')

@section('title', 'Onboarding Requests')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>🏪 Onboarding Requests</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Store Name</th>
                    <th>Teller ID</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->store_name }}</td>
                    <td>{{ $req->teller_id }}</td>
                    <td>
                        <span class="badge
                            @if($req->approval_status == 'approved') bg-success
                            @elseif($req->approval_status == 'pending') bg-warning
                            @else bg-danger @endif">
                            {{ ucfirst($req->approval_status) }}
                        </span>
                    </td>
                    <td>{{ $req->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.onboarding.show', $req->id) }}" class="btn btn-sm btn-info">ดู</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $requests->links() }}
    </div>
</div>
@endsection
