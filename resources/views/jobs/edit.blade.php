@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none text-muted mb-3 p-0">
            <i class="fas fa-arrow-left me-1"></i>Retour au tableau de bord
        </a>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-edit me-2"></i>Modifier l'offre d'emploi</h4>
                <p class="text-muted small mt-1 mb-0">Renseignez les détails pour mettre à jour cette offre.</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('jobs.update', $job->id) }}">
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

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Titre du poste</label>
                        <input type="text" name="title" class="form-control" placeholder="Ex: Développeur Full-Stack PHP" value="{{ old('title', $job->title) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Entreprise Recruteuse</label>
                        <select name="company_id" class="form-select" required>
                            <option value="" disabled>Choisir une entreprise...</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Domaine / Secteur</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled>Choisir un domaine...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Salaires</label>
                            <div class="input-group">
                                <input type="number" step="50000" name="salary" class="form-control" placeholder="ex: 1500000" value="{{ old('salary', $job->salary) }}">
                                <span class="input-group-text">Ar / mois</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Date limite (Optionnel)</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}" min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Description complète du poste</label>
                        <textarea name="description" class="form-control" rows="8" placeholder="Détaillez les missions, le profil recherché, les avantages..." required>{{ old('description', $job->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">Annuler</a>
                        <button type="submit" class="btn btn-primary-custom px-4">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
