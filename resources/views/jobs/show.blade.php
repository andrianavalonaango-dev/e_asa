@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() == route('jobs.show', $job->id) ? route('jobs.index') : url()->previous() }}" class="btn btn-link text-decoration-none text-muted mb-4 p-0">
    <i class="fas fa-arrow-left me-1"></i>Retour aux résultats
</a>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8 mb-4">
        <!-- Job Header -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="bg-primary text-white p-5 position-relative" style="background: linear-gradient(135deg, #1b2bd1 0%, #3a5cc4 100%);">
                <div class="d-flex justify-content-between align-items-md-start">
                    <div>
                        <div class="badge bg-white text-primary rounded-pill mb-3 fw-bold px-3 py-2 shadow-sm">{{ $job->category->name ?? 'Non classé' }}</div>
                        <h2 class="fw-bold mb-2">{{ $job->title }}</h2>
                        <h5 class="opacity-75 mb-0"><i class="fas fa-building me-2"></i>{{ $job->company->name }}</h5>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-5">
                <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="fas fa-align-left text-primary me-2"></i>L'Essentiel du poste</h5>
                
                <div class="row mb-5 text-muted">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-calendar-alt text-primary fs-5"></i>
                            </div>
                            <div>
                                <small class="d-block text-uppercase fw-bold">Publié le</small>
                                <span>{{ $job->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-euro-sign text-success fs-5"></i>
                            </div>
                            <div>
                                <small class="d-block text-uppercase fw-bold">Rémunération</small>
                                <span class="fw-bold text-success">{{ $job->salary ? number_format($job->salary, 0, ',', ' ') . ' Ar / mois' : 'À négocier' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-3 mt-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-hourglass-end text-warning fs-5"></i>
                            </div>
                            <div>
                                <small class="d-block text-uppercase fw-bold">Date Limite</small>
                                <span class="fw-bold {{ $job->deadline && $job->deadline->isPast() ? 'text-danger' : '' }}">
                                    {{ $job->deadline ? $job->deadline->format('d M Y') : 'Non spécifiée' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="fas fa-file-alt text-primary me-2"></i>Description détaillée</h5>
                <div class="text-body" style="line-height: 1.8; font-size: 1.05rem;">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>
        </div>
        
        <!-- Company Info -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">À propos de {{ $job->company->name }}</h5>
                @if($job->company->description)
                    <p class="text-muted mb-0" style="line-height: 1.7;">{{ $job->company->description }}</p>
                @else
                    <p class="text-muted mb-0 fst-italic">L'entreprise n'a pas encore renseigné sa description.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Sticky -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 85px;">
            <div class="card-body p-4 text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($job->company->name) }}&background=1b2bd1&color=fff&size=100" class="rounded-circle border mb-3 shadow-sm" alt="Logo">
                <h5 class="fw-bold mb-1">{{ $job->company->name }}</h5>
                <p class="text-muted small mb-4">Recruteur vérifié <i class="fas fa-check-circle text-success ms-1"></i></p>

                <hr class="mb-4">

                @auth
                    @if(auth()->user()->role === 'candidate')
                        @if($job->applications()->where('user_id', auth()->id())->exists())
                            <div class="alert alert-success rounded-3 mb-0">
                                <i class="fas fa-check-circle me-2"></i>Candidature envoyée
                            </div>
                            <p class="text-muted small mt-2">Le recruteur a bien reçu votre profil.</p>
                        @elseif($job->deadline && $job->deadline->isPast())
                            <div class="alert alert-danger rounded-3 mb-0">
                                <i class="fas fa-times-circle me-2"></i>Candidatures closes
                            </div>
                            <p class="text-muted small mt-2">La date limite pour postuler est dépassée.</p>
                        @else
                            <form action="{{ route('applications.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 text-start">
                                    <label for="cv" class="form-label small fw-bold">CV (PDF, DOC/X) <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="lm" class="form-label small fw-bold">Lettre de motivation (Optionnel)</label>
                                    <input class="form-control form-control-sm" type="file" id="lm" name="lm" accept=".pdf,.doc,.docx">
                                </div>
                                <button type="submit" class="btn btn-primary-custom w-100 fs-5 py-2 shadow-sm mt-2">
                                    <i class="fas fa-paper-plane me-2"></i>Postuler
                                </button>
                            </form>
                        @endif
                    @elseif(auth()->user()->role === 'recruiter' && $job->company->user_id === auth()->id())
                        <div class="alert alert-info rounded-3 mb-3 text-start">
                            <i class="fas fa-info-circle me-2"></i>C'est votre annonce
                        </div>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('La suppression est définitive. Continuer ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Retirer l'offre
                            </button>
                        </form>
                    @else
                        <button class="btn btn-outline-secondary w-100 py-2" disabled>Compte Recruteur</button>
                        <p class="text-muted small mt-2">Passez sur un compte candidat pour postuler.</p>
                    @endif
                @else
                    @if($job->deadline && $job->deadline->isPast())
                        <div class="alert alert-danger rounded-3 mb-0">
                            <i class="fas fa-times-circle me-2"></i>Candidatures closes
                        </div>
                        <p class="text-muted small mt-2">La date limite pour postuler est dépassée.</p>
                    @else
                        <div class="bg-light rounded-3 p-4 mb-0 border">
                            <i class="fas fa-lock text-muted fs-3 mb-3"></i>
                            <h6 class="fw-bold">Intéressé(e) ?</h6>
                            <p class="small text-muted mb-3">Créez un profil pour postuler instantanément.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary-custom w-100 mb-2">Se connecter</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-custom w-100">S'inscrire</a>
                        </div>
                    @endif
                @endauth
            </div>
            
            <div class="card-footer bg-transparent border-top text-center p-3">
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="text-muted text-decoration-none hover-primary"><i class="fab fa-linkedin fs-5"></i></a>
                    <a href="#" class="text-muted text-decoration-none hover-primary"><i class="fab fa-twitter fs-5"></i></a>
                    <a href="#" class="text-muted text-decoration-none hover-primary"><i class="fas fa-envelope fs-5"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
