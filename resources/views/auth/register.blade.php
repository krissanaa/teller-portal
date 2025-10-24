@extends('layouts.guest')

@section('title', 'Register - Teller Portal')

@section('content')
<div class="login-card" style="max-width: 450px; width:100%;">
    <h3 class="login-title">🧾 Create Account</h3>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone number</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-2">Register</button>
        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100">Back to Login</a>
    </form>
</div>
@endsection
