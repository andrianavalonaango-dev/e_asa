<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ auth()->user()?->theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-ASA - Emploi & Carrières</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: var(--bs-tertiary-bg, #f1f4f9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--bs-body-color, #2b3035);
        }
        .navbar-custom {
            background-color: var(--bs-body-bg, #fff);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .navbar-brand {
            font-weight: 800;
            color: #1b2bd1 !important;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .nav-link {
            font-weight: 500;
            color: #495057 !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #1b2bd1 !important;
        }
        .btn-primary-custom {
            background-color: #1b2bd1;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #1522a6;
            transform: translateY(-1px);
        }
        .btn-outline-custom {
            border: 1px solid #1b2bd1;
            color: #1b2bd1;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            background: transparent;
        }
        .btn-outline-custom:hover {
            background-color: #1b2bd1;
            color: white;
        }
        .page-header {
            background: linear-gradient(135deg, #1b2bd1 0%, #3a5cc4 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
        }
        .container-main {
            min-height: calc(100vh - 200px);
        }
        /* Style for active sidebar links */
        .list-group-item.active {
            background-color: #1b2bd1;
            border-color: #1b2bd1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-briefcase me-2"></i>E-ASA
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('jobs.index') }}">{{ __('Toutes les offres') }}</a>
                </li>
                @auth
                <li class="nav-item me-2 position-relative pt-1 pe-2">
                    <a class="nav-link" href="{{ route('notifications.index') }}" title="{{ __('Notifications') }}">
                        <i class="fas fa-bell fs-5"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="margin-left: -15px; margin-top: 10px; font-size: 0.65rem;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('profile.settings') }}"><i class="fas fa-cog me-1"></i>{{ __('Paramètres') }}</a>
                </li>
                @endauth
                @guest
                    <li class="nav-item me-2 d-flex align-items-center">
                        <a class="btn btn-outline-custom" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="btn btn-primary-custom text-white" style="color: white !important;" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                    </li>
                @else
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bold text-primary" href="{{ route('dashboard') }}">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fas fa-sign-out-alt"></i> {{ __('Déconnexion') }}</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container-main">
    <div class="container mt-4 mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-auto">
    <div class="container">
        <p class="mb-0">&copy; {{ date('Y') }} E-ASA - Construisons votre carrière professionnelle.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
