@extends('layouts.admin')

@section('title', 'Teller Details')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">👁️ Teller Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-3">{{ $user->name }}</h5>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Status:</strong>
                <span class="badge
                    @if($user->status == 'approved') bg-success
                    @elseif($user->status == 'pending') bg-warning text-dark
                    @else bg-danger @endif">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
            <p><strong>Created:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info">✏️ Edit</a>
        <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning" onclick="return confirm('Reset password for this user?')">🔑 Reset Password</button>
        </form>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this teller?')">🗑️ Delete</button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">⬅️ Back</a>
    </div>
</div>
@endsection
