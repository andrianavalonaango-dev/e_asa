@extends('layouts.auth')
@section('title', 'Inscription - E-ASA')

@section('content')
<div class="auth-card" style="max-width: 500px;">
    <div class="auth-header">
        <h2>E-ASA</h2>
        <p>{{ __('Créez votre compte') }}</p>
    </div>
    <div class="auth-body" style="padding: 30px;">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            @if($errors->any())
                <div class="alert alert-danger" style="font-size: 0.85rem;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <div class="input-group-text"><i class="fas fa-user border-0"></i> {{ __('Nom complet') }}</div>
                <input type="text" name="name" class="form-control" placeholder="Jean Dupont" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <div class="input-group-text"><i class="fas fa-envelope"></i> {{ __('Email') }}</div>
                <input type="email" name="email" class="form-control" placeholder="email@exemple.com" value="{{ old('email') }}" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group-text"><i class="fas fa-lock"></i> {{ __('Mot de passe') }}</div>
                    <input type="password" name="password" class="form-control" placeholder="........" required>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group-text"><i class="fas fa-lock"></i> {{ __('Confirmation') }}</div>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="........" required>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group-text"><i class="fas fa-user-tag"></i> {{ __('Rôle') }}</div>
                <select name="role" class="form-select form-control" required style="cursor: pointer;">
                    <option value="" disabled selected>{{ __('Choisissez votre rôle') }}</option>
                    <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>{{ __('Candidat (recherche d\'emploi)') }}</option>
                    <option value="recruiter" {{ old('role') == 'recruiter' ? 'selected' : '' }}>{{ __('Recruteur (publier offres)') }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-auth w-100">{{ __('S\'inscrire') }}</button>

            <div class="auth-footer-text">
                {{ __('Déjà un compte ?') }} <a href="{{ route('login') }}">{{ __('Se connecter') }}</a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted" style="font-size: 0.8rem; text-decoration: none;"><i class="fas fa-arrow-left"></i> {{ __('Retour à l\'accueil') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
