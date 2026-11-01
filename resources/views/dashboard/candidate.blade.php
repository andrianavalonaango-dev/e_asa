@extends('layouts.app')

@section('content')
<h2>Mon Espace Candidat</h2>
<hr>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Mes Candidatures</div>
            <div class="card-body">
                @if($applications->isEmpty())
                    <p>Vous n'avez postulé à aucune offre pour le moment.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Offre</th>
                                <th>Entreprise</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    <td><a href="{{ route('jobs.show', $application->job->id) }}">{{ $application->job->title }}</a></td>
                                    <td>{{ $application->job->company->name ?? 'N/A' }}</td>
                                    <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($application->status === 'pending')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($application->status === 'accepted')
                                            <span class="badge bg-success">Accepté</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="badge bg-danger">Refusé</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
