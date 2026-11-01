@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Sidebar avec fenetre deroulante / Domaines -->
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 85px;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0">
               
            </div>
            <div class="card-body">
                <form action="{{ route('jobs.index') }}" method="GET">
                    @if(request('domain'))
                        <input type="hidden" name="domain" value="{{ request('domain') }}">
                    @endif
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Recherche</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Titre, mots-clés..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-3 mb-2">Rechercher</button>
                    @if(request()->hasAny(['search', 'domain']))
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary w-100 rounded-3 btn-sm">Réinitialiser</a>
                    @endif
                </form>

                <hr class="my-4">

                <h6 class="fw-bold mb-3 text-muted small text-uppercase">Domaines / Secteurs</h6>
                <div class="list-group list-group-flush rounded-3">

                    @foreach($categories as $category)
                        <a href="{{ route('jobs.index', ['domain' => $category->id, 'search' => request('search')]) }}" 
                           class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center {{ request('domain') == $category->id ? 'fw-bold text-primary active text-white rounded' : '' }}">
                            {{ $category->name }}
                            <span class="badge {{ request('domain') == $category->id ? 'bg-light text-primary' : 'bg-secondary' }} rounded-pill">{{ $category->jobs_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Trouvez l'opportunité idéale</h3>
                <p class="text-muted mb-0">Affichage de {{ $jobs->total() }} offre(s) pertinente(s)</p>
            </div>
            @auth
                @if(auth()->user()->role === 'recruiter')
                    <a href="{{ route('jobs.create') }}" class="btn btn-success rounded-3 px-4 shadow-sm">
                        <i class="fas fa-plus me-2"></i>Publier une offre
                    </a>
                @endif
            @endauth
        </div>

        <div class="row">
            @forelse($jobs as $job)
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 job-card transition-all dropdown-item-action" style="transition: transform 0.2s;">
                        <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-4" style="width: 60px; height: 60px;">
                                    <i class="fas fa-building fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold mb-1">
                                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none text-body">{{ $job->title }}</a>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-primary fw-semibold">{{ $job->company->name ?? 'Entreprise Anonyme' }}</h6>
                                    <div class="d-flex gap-3 text-muted small mt-2">
                                        @if($job->category)
                                            <span><i class="fas fa-tag me-1 text-secondary"></i> {{ $job->category->name }}</span>
                                        @endif
                                        <span><i class="fas fa-clock me-1 text-secondary"></i> Il y a {{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-md-end d-flex flex-column align-items-md-end">
                                <span class="badge bg-success bg-opacity-10 text-success fs-6 fw-bold px-3 py-2 rounded-pill mb-3">
                                    {{ $job->salary ? number_format($job->salary, 0, ',', ' ') . ' Ar / mois' : 'Salaire négociable' }}
                                </span>
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">Postuler maintenant</a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-white shadow-sm border-0 text-center p-5 rounded-4">
                        @if(!request('domain'))
                           
                            <h4 class="text-primary">Sélectionnez un domaine</h4>
                            <p class="mb-0 text-muted">Veuillez choisir un domaine dans le menu de gauche pour afficher les offres correspondantes.</p>
                        @else
                            <i class="fas fa-search fs-1 text-muted mb-3 opacity-50"></i>
                            <h4 class="text-muted">Aucune offre trouvée</h4>
                            <p class="mb-0 text-muted">Essayez de modifier vos filtres ou effectuez une recherche différente.</p>
                            @if(request()->hasAny(['search', 'domain']))
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-3 rounded-pill px-4">Réinitialiser la recherche</a>
                            @endif
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $jobs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
