@extends('layouts.guest')

@section('title', 'Forgot Password - Teller Portal')

@section('content')
<div class="login-card" style="max-width: 420px; width:100%;">
    <h3 class="login-title">🔑 Reset Password</h3>

    @if (session('status'))
        <div class="alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Enter your email address</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-2">
            Send Password Reset Link
        </button>

        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100">
            Back to Login
        </a>

        <p class="text-center mt-3 form-text">We’ll send a secure link to your email.</p>
    </form>
</div>
@endsection
