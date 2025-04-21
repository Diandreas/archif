@extends('layouts.app')

@section('title', 'Détails des données utilisateur | ARCHIF')
@section('description', 'Visualisation détaillée des données utilisateur collectées par ARCHIF')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 fw-bold">Détails visiteur #{{ $userData->id }}</h1>
                <a href="{{ route('user-data-admin.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Informations générales</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID utilisateur:</strong> {{ $userData->user_id }}</p>
                            <p><strong>Date de visite:</strong> {{ $userData->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Dernière visite:</strong> {{ $userData->last_visit ? $userData->last_visit->format('d/m/Y H:i:s') : 'Non disponible' }}</p>
                            <p><strong>Nombre de visites:</strong> {{ $userData->visit_count }}</p>
                            <p><strong>Temps passé:</strong> {{ $userData->time_spent ? gmdate('H:i:s', $userData->time_spent) : 'Non disponible' }}</p>
                            <p><strong>Adresse IP:</strong> {{ $userData->ip_address }}</p>
                            <p><strong>URL visitée:</strong> {{ $userData->url }}</p>
                            <p><strong>Référent:</strong> {{ $userData->referrer ?: 'Direct' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Navigateur:</strong> {{ $userData->browser }}</p>
                            <p><strong>Système:</strong> {{ $userData->os }}</p>
                            <p><strong>Plateforme:</strong> {{ $userData->platform }}</p>
                            <p><strong>Type d'appareil:</strong> {{ $userData->is_mobile ? 'Mobile' : 'Desktop' }}</p>
                            <p><strong>Langue:</strong> {{ $userData->language }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h4 class="mb-0">Données techniques</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Résolution d'écran:</strong> {{ $userData->screen_resolution }}</p>
                            <p><strong>Taille de fenêtre:</strong> {{ $userData->window_size }}</p>
                            <p><strong>Fuseau horaire:</strong> {{ $userData->timezone }}</p>
                            <p><strong>Cookies activés:</strong> {{ $userData->cookies_enabled ? 'Oui' : 'Non' }}</p>
                            <p><strong>Do Not Track:</strong> {{ $userData->do_not_track ?: 'Non défini' }}</p>
                            <p><strong>Type de connexion:</strong> {{ $userData->connection_type }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h4 class="mb-0">Géolocalisation</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Pays:</strong> {{ $userData->country ?: 'Non disponible' }}</p>
                            <p><strong>Ville:</strong> {{ $userData->city ?: 'Non disponible' }}</p>
                            <p><strong>Région:</strong> {{ $userData->region ?: 'Non disponible' }}</p>
                            @if($userData->latitude && $userData->longitude)
                                <p><strong>Coordonnées:</strong> {{ $userData->latitude }}, {{ $userData->longitude }}</p>
                                <div class="mt-3">
                                    <a href="https://www.google.com/maps?q={{ $userData->latitude }},{{ $userData->longitude }}" 
                                       target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-map"></i> Voir sur Google Maps
                                    </a>
                                </div>
                            @else
                                <p><strong>Coordonnées:</strong> Non disponibles</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($userData->search_history)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Historique de recherche</h4>
                </div>
                <div class="card-body">
                    @if(count($userData->search_history) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Recherche</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userData->search_history as $search)
                                        <tr>
                                            <td>{{ $search['query'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($search['timestamp'])->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucun historique de recherche disponible</p>
                    @endif
                </div>
            </div>
            @endif

            @if($userData->page_views)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Pages visitées</h4>
                </div>
                <div class="card-body">
                    @if(count($userData->page_views) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>Titre</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userData->page_views as $page)
                                        <tr>
                                            <td><a href="{{ $page['url'] }}" target="_blank">{{ \Illuminate\Support\Str::limit($page['url'], 50) }}</a></td>
                                            <td>{{ $page['title'] ?? 'Non disponible' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($page['timestamp'])->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucune page visitée disponible</p>
                    @endif
                </div>
            </div>
            @endif

            <div class="text-end">
                <form action="{{ route('user-data-admin.destroy', $userData->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement?')">
                        <i class="bi bi-trash me-2"></i>Supprimer cet enregistrement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 