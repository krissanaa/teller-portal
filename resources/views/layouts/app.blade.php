<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Teller Portal')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&family=Noto+Sans+Lao:wght@300;400;500;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&family=Noto+Sans+Lao:wght@300;400;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700&family=Noto+Sans+Lao:wght@300;400;500;700&display=swap" rel="stylesheet">
    </noscript>

    {{-- Bootstrap 5 --}}
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Thai', 'Noto Sans Lao', sans-serif;
            background-color: #f7f9fb;
            color: #222;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-link {
            color: #f8f9fa !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .card {
            border-radius: 10px;
        }

        footer {
            padding: 20px 0;
            color: #777;
            font-size: 0.9rem;
            background: #f1f3f4;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Teller Portal</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav ms-auto">
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
                            <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link">Users</a></li>
                            <li class="nav-item"><a href="{{ route('admin.reports.index') ?? '#' }}" class="nav-link">Reports</a></li>
                        @elseif(Auth::user()->role === 'teller')
                            <li class="nav-item"><a href="{{ route('teller.dashboard') }}" class="nav-link">Dashboard</a></li>
                            <li class="nav-item"><a href="{{ route('teller.requests.create') }}" class="nav-link">Onboarding</a></li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                               {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endauth

                @guest
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    </ul>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Main content --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} Teller Portal System — All Rights Reserved.</p>
            <p class="small text-muted">Designed for Teller and Admin operations management.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
