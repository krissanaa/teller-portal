@extends('layouts.admin')
@section('title', '')
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
        color: #1e293b;
        margin-bottom: 1.5rem;
    }

    .branch-card label {
        font-weight: 600;
        color: #0f172a;
    }

    .branch-card .form-control,
    .branch-card textarea {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.15);
        padding: 0.75rem 1rem;
    }
</style>

<div class="branch-shell">
    <div class="branch-card">
        <h4>Add New Branch</h4>
        <form method="POST" action="{{ route('admin.branches.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Branch Code *</label>
                <input type="text" name="branch_code" class="form-control" value="{{ old('branch_code') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Branch Name *</label>
                <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name') }}" required>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save
                </button>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection