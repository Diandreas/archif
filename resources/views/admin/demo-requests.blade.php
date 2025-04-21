@extends('layouts.app')

@section('title', 'Administration des demandes de démo')
@section('description', 'Interface d\'administration pour gérer les demandes de démo ARCHIF')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container">
        <h1 class="display-4 fw-bold">Administration des demandes de démo</h1>
        <p class="lead">Gestion des emails recueillis et des informations associées</p>
    </div>
</div>

<div class="container py-5">
    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Total</h5>
                    <p class="display-4 fw-bold text-primary">{{ $stats['total'] }}</p>
                    <p class="text-muted">demandes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Aujourd'hui</h5>
                    <p class="display-4 fw-bold text-success">{{ $stats['today'] }}</p>
                    <p class="text-muted">nouvelles demandes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Cette semaine</h5>
                    <p class="display-4 fw-bold text-info">{{ $stats['week'] }}</p>
                    <p class="text-muted">derniers 7 jours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Pays</h5>
                    <p class="display-4 fw-bold text-warning">{{ $stats['countries'] }}</p>
                    <p class="text-muted">différents pays</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques par appareil et navigateur -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Par navigateur</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Navigateur</th>
                                    <th class="text-end">Nombre</th>
                                    <th class="text-end">Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['browsers'] as $browser)
                                <tr>
                                    <td>{{ $browser->browser }}</td>
                                    <td class="text-end">{{ $browser->count }}</td>
                                    <td class="text-end">{{ round(($browser->count / $stats['total']) * 100, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Par appareil</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Appareil</th>
                                    <th class="text-end">Nombre</th>
                                    <th class="text-end">Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['devices'] as $device)
                                <tr>
                                    <td>{{ $device->device }}</td>
                                    <td class="text-end">{{ $device->count }}</td>
                                    <td class="text-end">{{ round(($device->count / $stats['total']) * 100, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages flash -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <!-- Tableau des demandes -->
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Liste des demandes ({{ $stats['total'] }})</h4>
            <div>
                <a href="{{ route('user-data-admin.index') }}" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-person-badge me-1"></i> Données utilisateur
                </a>
                <a href="{{ route('demo-admin.export') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-download me-1"></i> Exporter CSV
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Pays</th>
                            <th>Ville</th>
                            <th>Navigateur</th>
                            <th>Système</th>
                            <th>Appareil</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demoRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $request->country ?? 'Inconnu' }}</td>
                            <td>{{ $request->city ?? 'Inconnu' }}</td>
                            <td>{{ $request->browser ?? 'Inconnu' }}</td>
                            <td>{{ $request->os ?? 'Inconnu' }}</td>
                            <td>{{ $request->device ?? 'Inconnu' }}</td>
                            <td>
                                @if($request->sent_at)
                                <span class="badge bg-success">Envoyé le {{ $request->sent_at}}</span>
                                @else
                                <span class="badge bg-warning text-dark">En attente</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    @if(!$request->sent_at)
                                    <form action="{{ route('demo-admin.mark-sent', $request->id) }}" method="POST" class="me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Marquer comme envoyé">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $request->id }}" title="Voir les détails">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    {{-- <form action="{{ route('demo-admin.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>

                        <!-- Modal pour les détails -->
                        <div class="modal fade" id="detailsModal{{ $request->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $request->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailsModalLabel{{ $request->id }}">Détails de la demande #{{ $request->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Email:</strong> {{ $request->email }}</p>
                                                <p><strong>Date de demande:</strong> {{ $request->created_at->format('d/m/Y H:i:s') }}</p>
                                                <p><strong>IP:</strong> {{ $request->ip_address }}</p>
                                                <p><strong>Pays:</strong> {{ $request->country ?? 'Inconnu' }}</p>
                                                <p><strong>Ville:</strong> {{ $request->city ?? 'Inconnu' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Navigateur:</strong> {{ $request->browser ?? 'Inconnu' }}</p>
                                                <p><strong>Système:</strong> {{ $request->os ?? 'Inconnu' }}</p>
                                                <p><strong>Appareil:</strong> {{ $request->device ?? 'Inconnu' }}</p>
                                                <p><strong>Référent:</strong> {{ $request->referrer ?? 'Direct' }}</p>
                                                <p><strong>Page d'atterrissage:</strong> {{ $request->landing_page ?? 'Inconnue' }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h6>Autres informations:</h6>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><strong>User-Agent:</strong> <code class="small">{{ $request->user_agent }}</code></p>
                                                <p><strong>UTM Source:</strong> {{ $request->utm_source ?? 'Non disponible' }}</p>
                                                <p><strong>UTM Medium:</strong> {{ $request->utm_medium ?? 'Non disponible' }}</p>
                                                <p><strong>UTM Campaign:</strong> {{ $request->utm_campaign ?? 'Non disponible' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">Aucune demande de démo n'a été enregistrée pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 