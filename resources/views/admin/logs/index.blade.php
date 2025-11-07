@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🕓 Activity Logs</h2>

    <form method="GET" action="{{ route('admin.logs.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search logs..." class="form-control w-50 d-inline">
        <button class="btn btn-primary ms-2">Search</button>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Description</th>
                <th>User</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->admin->name ?? '-' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->targetUser->name ?? '-' }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No logs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $logs->links() }}
</div>
@endsection
