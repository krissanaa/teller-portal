@extends('layouts.admin')
@section('title', 'Edit Branch')
@section('content')
<style>
    .branch-shell {
        max-width: 900px;
        margin: 0 auto;
        padding: 2.5rem 1rem 3rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .branch-card {
        border-radius: 24px;
        border: 1px solid rgba(28, 114, 75, 0.12);
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        padding: 2rem;
    }

    .branch-card h4 {
        font-weight: 800;
        color: #1c724b;
        margin-bottom: 1.5rem;
    }

    .branch-card label {
        font-weight: 600;
        color: #0f172a;
    }

    .branch-card .form-control,
    .branch-card textarea,
    .branch-card select {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        padding: 0.75rem 1rem;
    }
    .unit-table thead {
        background: #0f766e;
        color: #fff;
    }

    .unit-table tbody tr:hover {
        background: rgba(20, 184, 166, 0.08);
    }

    .unit-form input {
        border-radius: 10px;
    }
</style>

<div class="branch-shell">
    <div class="branch-card">
        <h4>Edit Branch</h4>
        <form method="POST" action="{{ route('admin.branches.update', $branch->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Branch Code *</label>
                <input type="text" name="branch_code" class="form-control" value="{{ old('branch_code', $branch->code) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Branch Name *</label>
                <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', $branch->name) }}" required>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>

    <div class="branch-card mt-4">
        <h4>Manage Units</h4>

        <table class="table unit-table align-middle mb-4">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th width="80"></th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($branch->units as $unit)
                <tr>
                    <td colspan="4">
                        <form method="POST" action="{{ route('admin.branches.units.update', [$branch->id, $unit->id]) }}" class="row g-2 unit-form">
                            @csrf
                            @method('PUT')
                            <div class="col-md-4">
                                <input type="text" name="unit_code" value="{{ old('unit_code', $unit->unit_code) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="unit_name" value="{{ old('unit_name', $unit->unit_name) }}" class="form-control" required>
                            </div>
                            <div class="col-md-1 d-grid">
                                <button class="btn btn-sm btn-primary"><i class="bi bi-save"></i></button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('admin.branches.units.destroy', [$branch->id, $unit->id]) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger mt-2" onclick="return confirm('Delete this unit?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted fst-italic">No units for this branch yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <form method="POST" action="{{ route('admin.branches.units.store', $branch->id) }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">New Unit Code</label>
                <input type="text" name="unit_code" class="form-control" required placeholder="400201">
            </div>
            <div class="col-md-6">
                <label class="form-label">New Unit Name</label>
                <input type="text" name="unit_name" class="form-control" required placeholder="Unit Description">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-plus-circle"></i> Add Unit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
