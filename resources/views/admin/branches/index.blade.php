@extends('layouts.admin')
@section('title', 'Branch Management')
@section('content')
<div class="container-fluid">
    <h4 class="mb-3">🏢 Branch Management</h4>
    <a href="{{ route('admin.branches.create') }}" class="btn btn-success mb-3">➕ Add Branch</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branches as $b)
            <tr>
                <td>{{ $b->id }}</td>
                <td>{{ $b->name }}</td>
                <td>{{ $b->contact ?? '-' }}</td>
                <td>
                    <span class="badge {{ $b->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($b->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.branches.edit', $b->id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                    <form method="POST" action="{{ route('admin.branches.destroy', $b->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this branch?')">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">{{ $branches->links() }}</div>
</div>
@endsection
