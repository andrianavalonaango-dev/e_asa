@extends('layouts.auth')
@section('title', 'Connexion - E-ASA')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h2>E-ASA</h2>
        <p>{{ __('Connectez-vous') }}</p>
    </div>
    <div class="auth-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li style="font-size: 0.85rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <div class="input-group-text"><i class="fas fa-envelope"></i> {{ __('Email') }}</div>
                <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-4">
                <div class="input-group-text"><i class="fas fa-lock"></i> {{ __('Mot de passe') }}</div>
                <input type="password" name="password" class="form-control" placeholder="........" required>
            </div>

            <div class="mb-4 form-check ps-4">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label text-muted ms-1" for="remember" style="font-size: 0.9rem;">{{ __('Se souvenir de moi') }}</label>
            </div>

            <button type="submit" class="btn btn-auth w-100">{{ __('Se connecter') }}</button>

            <div class="auth-footer-text">
                {{ __('Pas encore de compte ?') }} <a href="{{ route('register') }}">{{ __('Créer un compte') }}</a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted" style="font-size: 0.8rem; text-decoration: none;"><i class="fas fa-arrow-left"></i> {{ __('Retour à l\'accueil') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
