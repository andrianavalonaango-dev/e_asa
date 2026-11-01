<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ auth()->check() ? auth()->user()->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-ASA')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* Vibrant gradient background as requested */
            background: linear-gradient(135deg, #1b2bd1 0%, #3a5cc4 30%, #a4b2da 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .auth-card {
            background: var(--bs-body-bg, #fff);
            color: var(--bs-body-color, #212529);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            border: none;
        }
        .auth-header {
            background: linear-gradient(135deg, #2b3fd6 0%, #879afc 100%);
            color: white;
            text-align: center;
            padding: 35px 20px 30px;
        }
        .auth-header h2 {
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .auth-header p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .auth-body {
            padding: 35px 35px 30px;
        }
        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            background-color: var(--bs-tertiary-bg, #f1f4f9);
            border: 1px solid var(--bs-border-color, #d4dae6);
            color: var(--bs-body-color);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(43, 63, 214, 0.25);
            border-color: #2b3fd6;
            background-color: var(--bs-body-bg, #fff);
            color: var(--bs-body-color);
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #495057;
            font-size: 0.9rem;
            padding-left: 0;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }
        .btn-auth {
            background: linear-gradient(90deg, #2b3fd6 0%, #879afc 100%);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-auth:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }
        .auth-footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .auth-footer-text a {
            color: #1b2bd1;
            text-decoration: none;
            font-weight: 700;
        }
        .auth-footer-text a:hover {
            text-decoration: underline;
        }
        .page-footer {
            margin-top: 25px;
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    @yield('content')

    <div class="page-footer">
        &copy; {{ date('Y') }} E-ASA
    </div>

</body>
</html>
