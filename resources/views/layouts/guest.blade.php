<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Teller Portal Login')</title>

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
            background: linear-gradient(120deg, #e9ecef, #f8f9fa);
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            background: #fff;
        }

        .login-title {
            font-size: 1.6rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
            color: #222;
        }

        .btn-dark {
            border-radius: 6px;
            padding: 10px 16px;
        }

        .form-text {
            font-size: 0.9rem;
            color: #777;
        }

        .small-link {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
