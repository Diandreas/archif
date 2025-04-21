@extends('layouts.app')

@section('title', 'Administration des données utilisateur | ARCHIF')
@section('description', 'Interface d\'administration pour visualiser les données utilisateur collectées par ARCHIF')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 fw-bold">Données utilisateur collectées</h1>
                <div>
                    <a href="{{ route('user-data-admin.export') }}" class="btn btn-success me-2">
                        <i class="bi bi-file-earmark-excel me-1"></i> Exporter CSV
                    </a>
                    <a href="{{ route('demo-admin.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Retour aux demandes de démo
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total</h5>
                            <p class="display-4 fw-bold text-primary">{{ $stats['total'] }}</p>
                            <p class="text-muted">visiteurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Aujourd'hui</h5>
                            <p class="display-4 fw-bold text-success">{{ $stats['today'] }}</p>
                            <p class="text-muted">nouveaux visiteurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Pays</h5>
                            <p class="display-4 fw-bold text-info">{{ $stats['countries']->count() }}</p>
                            <p class="text-muted">différents pays</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Villes</h5>
                            <p class="display-4 fw-bold text-warning">{{ $stats['cities']->count() }}</p>
                            <p class="text-muted">différentes villes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques par navigateur et système -->
            <div class="row mb-4">
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
                                            <td class="text-end">{{ $stats['total'] > 0 ? round(($browser->count / $stats['total']) * 100, 1) : 0 }}%</td>
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
                            <h5 class="mb-0">Par système d'exploitation</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>OS</th>
                                            <th class="text-end">Nombre</th>
                                            <th class="text-end">Pourcentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['os'] as $os)
                                        <tr>
                                            <td>{{ $os->os }}</td>
                                            <td class="text-end">{{ $os->count }}</td>
                                            <td class="text-end">{{ $stats['total'] > 0 ? round(($os->count / $stats['total']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques géographiques -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Top 10 Pays</h5>
                        </div>
                        <div class="card-body">
                            @if(count($stats['countries']) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Pays</th>
                                                <th class="text-end">Nombre</th>
                                                <th class="text-end">Pourcentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stats['countries'] as $country)
                                            <tr>
                                                <td>{{ $country->country }}</td>
                                                <td class="text-end">{{ $country->count }}</td>
                                                <td class="text-end">{{ $stats['total'] > 0 ? round(($country->count / $stats['total']) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center py-3">Aucune donnée géographique disponible</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Top 10 Villes</h5>
                        </div>
                        <div class="card-body">
                            @if(count($stats['cities']) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ville</th>
                                                <th>Pays</th>
                                                <th class="text-end">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stats['cities'] as $city)
                                            <tr>
                                                <td>{{ $city->city }}</td>
                                                <td>{{ $city->country }}</td>
                                                <td class="text-end">{{ $city->count }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center py-3">Aucune donnée de ville disponible</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Liste des visiteurs ({{ $stats['total'] }})</h4>
                    {{-- <form action="{{ route('user-data-admin.destroy-all') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer TOUTES les données? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i> Tout supprimer
                        </button>
                    </form> --}}
                </div>
                <div class="card-body p-0">
                    @if($userData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Pays</th>
                                        <th>Ville</th>
                                        <th>URL</th>
                                        <th>Référent</th>
                                        <th>IP</th>
                                        <th>Navigateur</th>
                                        <th>OS</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userData as $data)
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $data->country ?: 'N/A' }}</td>
                                            <td>{{ $data->city ?: 'N/A' }}</td>
                                            <td title="{{ $data->url }}">{{ \Illuminate\Support\Str::limit($data->url, 30) }}</td>
                                            <td title="{{ $data->referrer }}">{{ \Illuminate\Support\Str::limit($data->referrer, 20) }}</td>
                                            <td>{{ $data->ip_address }}</td>
                                            <td>{{ $data->browser }}</td>
                                            <td>{{ $data->os }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('user-data-admin.show', $data->id) }}" class="btn btn-sm btn-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    {{-- <form action="{{ route('user-data-admin.destroy', $data->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3">
                            {{ $userData->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-circle fs-1 text-muted"></i>
                            <p class="mt-3">Aucune donnée utilisateur n'a été collectée pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 