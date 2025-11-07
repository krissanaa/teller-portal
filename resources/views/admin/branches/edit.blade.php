@extends('layouts.admin')
@section('title', 'Add Branch')
@section('content')
<div class="container-fluid">
    <h4 class="mb-3">➕ Add New Branch</h4>
    <form method="POST" action="{{ route('admin.branches.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Branch Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">💾 Save</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">⬅ Back</a>
    </form>
</div>
@endsection
