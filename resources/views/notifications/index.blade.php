@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-bell me-2"></i>Mes Notifications</h4>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">Tout marquer comme lu</button>
                </form>
            @endif
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-body">
            <div class="card-body p-0">
                @forelse($notifications as $notification)
                    <div class="p-4 border-bottom {{ $notification->unread() ? 'bg-primary bg-opacity-10' : '' }}">
                        <div class="d-flex align-items-start">
                            <div class="text-white rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm mt-1 {{ isset($notification->data['status']) && $notification->data['status'] === 'accepted' ? 'bg-success' : 'bg-danger' }}" style="width: 45px; height: 45px; flex-shrink: 0;">
                                @if(isset($notification->data['status']) && $notification->data['status'] === 'accepted')
                                    <i class="fas fa-check"></i>
                                @elseif(isset($notification->data['status']) && $notification->data['status'] === 'rejected')
                                    <i class="fas fa-times"></i>
                                @else
                                    <i class="fas fa-info"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">
                                    Mise à jour de votre candidature chez {{ $notification->data['company_name'] ?? 'une entreprise' }}
                                </h6>
                                <p class="mb-2 text-body">
                                    Votre candidature pour le poste de <strong>{{ $notification->data['job_title'] ?? 'Non spécifié' }}</strong> a été 
                                    @if(isset($notification->data['status']) && $notification->data['status'] === 'accepted')
                                        <span class="badge bg-success">Acceptée ! 🎉</span> Le recruteur vous contactera bientôt.
                                    @elseif(isset($notification->data['status']) && $notification->data['status'] === 'rejected')
                                        <span class="badge bg-danger">Refusée</span>. Ne vous découragez pas et continuez vos recherches !
                                    @else
                                        mise à jour.
                                    @endif
                                </p>
                                <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-bell-slash fs-1 mb-3 opacity-50"></i>
                        <h5>Aucune notification</h5>
                        <p>Vous n'avez reçu aucune notification pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
