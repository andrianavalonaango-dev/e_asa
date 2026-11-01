@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-cog me-2"></i>{{ __('Paramètres du compte') }}</h4>
                <p class="text-muted small mt-1 mb-0">{{ __('Modifiez vos informations personnelles et vos paramètres de sécurité.') }}</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3" style="font-size: 0.9rem;">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h5 class="fw-bold fs-6 text-uppercase text-muted border-bottom pb-2 mb-3">{{ __('Informations générales') }}</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Nom Complet') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Adresse Email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <h5 class="fw-bold fs-6 text-uppercase text-muted border-bottom pb-2 mb-3 mt-5">{{ __('Préférences d\'Affichage') }}</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Thème') }}</label>
                            <select name="theme" class="form-select">
                                <option value="light" {{ old('theme', $user->theme) === 'light' ? 'selected' : '' }}>{{ __('Clair') }}</option>
                                <option value="dark" {{ old('theme', $user->theme) === 'dark' ? 'selected' : '' }}>{{ __('Sombre') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Langue') }}</label>
                            <select name="locale" class="form-select">
                                <option value="fr" {{ old('locale', $user->locale) === 'fr' ? 'selected' : '' }}>{{ __('Français') }}</option>
                                <option value="en" {{ old('locale', $user->locale) === 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="fw-bold fs-6 text-uppercase text-muted border-bottom pb-2 mb-3 mt-5">{{ __('Sécurité') }}</h5>
                    <p class="text-muted small mb-4">{{ __('Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.') }}</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Mot de passe actuel') }}</label>
                        <input type="password" name="current_password" class="form-control" placeholder="">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Nouveau mot de passe') }}</label>
                            <input type="password" name="new_password" class="form-control" placeholder="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">{{ __('Confirmer le mot de passe') }}</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">{{ __('Annuler') }}</a>
                        <button type="submit" class="btn btn-primary-custom px-4">{{ __('Enregistrer les modifications') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
