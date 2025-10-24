@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


@extends('layouts.guest')

@section('title', 'Login - Teller Portal')

@section('content')
<div class="login-card" style="max-width: 420px; width:100%;">
    <h3 class="login-title">🔐 Teller Portal</h3>

    {{-- ✅ แสดง error --}}
    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ ฟอร์ม Login --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>

        </div>

        <button type="submit" class="btn btn-dark w-100 mb-2">Sign in</button>

        {{-- ✅ ปุ่ม Register ในฟอร์มเดียวกัน --}}
        <a href="{{ route('register') }}" class="btn btn-outline-dark w-100">Create new account</a>

        <p class="text-center mt-3 form-text">© {{ date('Y') }} Teller Portal System</p>
    </form>
</div>
@endsection
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const msg = "{{ session('success') }}";
    const modalHTML = `
    <div class="modal fade" id="registerSuccessModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">✅ Registration Success</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>${msg}</p>
            <p class="text-muted small mb-0">Please wait for admin approval before login.</p>
          </div>
        </div>
      </div>
    </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    new bootstrap.Modal(document.getElementById('registerSuccessModal')).show();
});
</script>
@endif
