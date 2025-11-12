@extends('layouts.admin')
@section('title', 'Branch Management')
@section('content')
<style>
    .branch-shell {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem 3rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .branch-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .branch-header h4 {
        margin: 0;
        font-weight: 800;
        color: #1c724b;
    }

    .branch-card {
        border-radius: 24px;
        border: 1px solid rgba(28, 114, 75, 0.12);
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        padding: 1.5rem;
    }

    .branch-table thead {
        background: #1c724b;
        color: #fff;
    }

    .branch-table tbody tr:hover {
        background: rgba(28, 114, 75, 0.05);
    }

    .branch-table th, .branch-table td {
        vertical-align: middle;
    }

    .btn-branch {
        border-radius: 999px;
        padding: 0.55rem 1.4rem;
        font-weight: 600;
    }
</style>

<div class="branch-shell">
    <div class="branch-header">

        <a href="{{ route('admin.branches.create') }}" class="btn btn-success btn-branch">
            <i class="bi bi-plus-circle"></i> Add Branch
        </a>
    </div>

    <div class="branch-card">
        <table class="table branch-table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td class="fw-semibold">{{ $b->name }}</td>
                    <td>{{ $b->contact ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $b->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.branches.edit', $b->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.branches.destroy', $b->id) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this branch?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{ $branches->links() }}</div>
    </div>
</div>
@endsection
