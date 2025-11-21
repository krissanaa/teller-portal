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

    .unit-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(20, 184, 166, 0.12);
        color: #0f766e;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        margin: 2px;
    }

    .unit-chip i {
        font-size: 0.9rem;
    }

    .unit-empty {
        color: #94a3b8;
        font-size: 0.85rem;
        font-style: italic;
    }

    .unit-row td {
        background: #f8fafc;
    }

    .unit-card {
        border: 1px solid rgba(15, 118, 110, 0.15);
        border-radius: 12px;
        padding: 10px 14px;
        background: white;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        height: 100%;
    }

    .unit-code {
        font-weight: 700;
        color: #0f766e;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.95rem;
    }

    .unit-name {
        font-size: 0.85rem;
        margin-top: 4px;
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
                    <th>Branch Code</th>
                    <th>Branch Name</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td class="fw-semibold">{{ $b->code }}</td>
                    <td>{{ $b->name }}</td>
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
                <tr class="unit-row">
                    <td colspan="4">
                        @if($b->units->isNotEmpty())
                            <div class="row g-2">
                                @foreach($b->units as $unit)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="unit-card">
                                            <div class="unit-code">
                                                <i class="bi bi-diagram-3"></i>
                                                {{ $unit->unit_code }}
                                            </div>
                                            <div class="unit-name text-muted">
                                                {{ $unit->unit_name }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="unit-empty">No units registered for this branch.</span>
                        @endif
                        <form method="POST" action="{{ route('admin.branches.units.store', $b->id) }}" class="row g-2 align-items-end mt-3">
                            @csrf
                            <div class="col-md-3">
                                <label class="form-label small text-muted mb-1">Unit Code</label>
                                <input type="text" name="unit_code" class="form-control form-control-sm" placeholder="400201" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Unit Name</label>
                                <input type="text" name="unit_name" class="form-control form-control-sm" placeholder="Unit Description" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-success w-100">
                                    <i class="bi bi-plus-circle"></i> Add Unit
                                </button>
                            </div>
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
