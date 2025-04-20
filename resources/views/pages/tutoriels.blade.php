@extends('layouts.app')

@section('title', 'Tutoriels')
@section('description', 'Découvrez les tutoriels pratiques pour maîtriser ARCHIF, la solution d\'archivage électronique open source africaine. Guides pas à pas pour débutants et utilisateurs avancés.')
@section('keywords', 'tutoriels archif, guides, formation, apprendre, archivage électronique, open source, Cameroun, utilisation archif')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left fs-4 me-2"></i>
                Retour à l'accueil
            </a>
        </div>
        <h1 class="display-4 fw-bold">Tutoriels ARCHIF</h1>
        <p class="lead">Apprenez à utiliser efficacement ARCHIF avec nos tutoriels guidés</p>
    </div>
</div>

<div class="container py-5">
    <div class="alert alert-info mb-5">
        <i class="bi bi-info-circle me-2"></i>
        Nos tutoriels sont en cours de développement et seront disponibles prochainement avec le lancement
        officiel d'ARCHIF.
    </div>

    <div class="row g-4">
        @foreach($tutoriels as $tutorial)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="card-title h5 mb-0">{{ $tutorial['title'] }}</h4>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="badge bg-primary">{{ $tutorial['level'] }}</span>
                        <span class="badge bg-secondary"><i class="bi bi-clock me-1"></i> {{ $tutorial['duration'] }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{ $tutorial['description'] }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        @if(isset($tutorial['coming_soon']) && $tutorial['coming_soon'])
                            <span class="badge bg-light text-primary">Bientôt disponible</span>
                            <button class="btn btn-sm btn-outline-primary" disabled>Voir le tutoriel</button>
                        @elseif(isset($tutorial['available']) && $tutorial['available'])
                            <span class="badge bg-success">Disponible</span>
                            <a href="{{ url('tutoriels/' . Str::slug($tutorial['title'])) }}" class="btn btn-sm btn-primary">Voir le tutoriel</a>
                        @else
                            <span class="badge bg-light text-primary">Bientôt disponible</span>
                            <button class="btn btn-sm btn-outline-primary" disabled>Voir le tutoriel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <p>Vous avez des idées de tutoriels que vous aimeriez voir?</p>
        <a href="mailto:omgbwayasse@gmail.com" class="btn btn-primary">
            <i class="bi bi-envelope me-2"></i>
            Proposer un sujet de tutoriel
        </a>
    </div>
</div>
@endsection 