@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Espace Recruteur</h2>
    <a href="{{ route('company.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Ajouter une entreprise</a>
</div>
<hr>

@if($companies->isEmpty())
    <div class="alert alert-warning">
        Vous devez créer le profil de votre première entreprise avant de publier des offres.
        <a href="{{ route('company.create') }}" class="alert-link">Créer une entreprise</a>
    </div>
@else
    <h4 class="mb-3">Mes Entreprises</h4>
    <div class="row mb-4">
        @foreach($companies as $company)
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex mx-auto justify-content-center align-items-center mb-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-building fs-4"></i>
                        </div>
                        <h5 class="card-title fw-bold">{{ $company->name }}</h5>
                        <p class="card-text text-muted small mb-3 text-truncate">{{ $company->description ?: 'Aucune description' }}</p>
                        <div class="d-flex justify-content-center gap-2 mt-auto">
                            <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">Modifier le profil</a>
                            <a href="{{ route('dashboard', ['company_id' => $company->id]) }}#jobs-section" class="btn btn-sm btn-primary px-3 rounded-pill">Voir candidatures</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mb-4" id="jobs-section">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent pt-4 pb-2 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        Mes Offres d'emploi ({{ $jobs->count() }})
                        @if(request('company_id'))
                            <a href="{{ route('dashboard') }}#jobs-section" class="badge bg-secondary ms-2 text-decoration-none fw-normal"><i class="fas fa-times me-1"></i>Réinitialiser le filtre</a>
                        @endif
                    </h5>
                    <a href="{{ route('jobs.create') }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm"><i class="fas fa-plus me-1"></i>Nouvelle offre</a>
                </div>
                <div class="card-body p-4">
                    @forelse($jobs as $job)
                        <div class="border mb-4 p-4 rounded-4 shadow-sm bg-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1"><a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none text-body">{{ $job->title }}</a></h5>
                                    <h6 class="text-primary mb-3"><i class="fas fa-building me-1"></i>{{ $job->company->name }}</h6>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Modifier l'offre"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Supprimer cette offre ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Supprimer l'offre"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            
                            <h6 class="mt-2 fw-bold text-muted small text-uppercase">Candidatures ({{ $job->applications->count() }})</h6>
                            @if($job->applications->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mt-2">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="small text-muted text-uppercase fw-bold">Candidat</th>
                                                <th class="small text-muted text-uppercase fw-bold">Email</th>
                                                <th class="small text-muted text-uppercase fw-bold">Date</th>
                                                <th class="small text-muted text-uppercase fw-bold">Statut</th>
                                                <th class="small text-muted text-uppercase fw-bold text-center">Fichiers</th>
                                                <th class="small text-muted text-uppercase fw-bold">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($job->applications as $app)
                                                <tr>
                                                    <td class="fw-bold">{{ $app->user->name }}</td>
                                                    <td><a href="mailto:{{ $app->user->email }}" class="text-decoration-none">{{ $app->user->email }}</a></td>
                                                    <td>{{ $app->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if($app->status === 'pending')
                                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>En attente</span>
                                                        @elseif($app->status === 'accepted')
                                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Accepté</span>
                                                        @elseif($app->status === 'rejected')
                                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Refusé</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($app->cv_path)
                                                            <a href="{{ route('applications.viewFile', [$app->id, 'cv']) }}" target="_blank" class="btn btn-sm btn-outline-secondary mb-1 w-100" title="Voir le CV"><i class="fas fa-file-pdf"></i> CV</a>
                                                        @endif
                                                        @if($app->lm_path)
                                                            <a href="{{ route('applications.viewFile', [$app->id, 'lm']) }}" target="_blank" class="btn btn-sm btn-outline-info w-100" title="Voir la LM"><i class="fas fa-file-alt"></i> LM</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{ route('applications.updateStatus', $app->id) }}" class="d-flex align-items-center">
                                                            @csrf
                                                            <select name="status" class="form-select form-select-sm me-2 shadow-sm" style="min-width: 120px;">
                                                                <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                                                <option value="accepted" {{ $app->status == 'accepted' ? 'selected' : '' }}>Accepter</option>
                                                                <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Refuser</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">Maj</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted small mt-2">Aucune candidature correspondante pour le moment.</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center p-5">
                            <i class="fas fa-briefcase fs-1 text-muted mb-3 opacity-25"></i>
                            <p class="mb-0 text-muted">Vous n'avez publié aucune offre.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
