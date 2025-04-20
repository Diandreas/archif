@extends('layouts.app')

@section('title', 'Développement')
@section('description', 'Contribuez au développement d\'ARCHIF, la première solution d\'archivage électronique open source africaine. Rejoignez notre communauté et participez à ce projet camerounais innovant.')
@section('keywords', 'développement archif, open source, contribution, GitHub, communauté, Cameroun, développement logiciel, archivage électronique')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left fs-4 me-2"></i>
                Retour à l'accueil
            </a>
        </div>
        <h1 class="display-4 fw-bold">Développement ARCHIF</h1>
        <p class="lead">Contribuez au développement d'ARCHIF et rejoignez notre communauté open source</p>
    </div>
</div>

<div class="container py-5">
    @if(isset($developpement))
    <!-- Introduction -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="mb-4">{{ $developpement[0]['title'] }}</h2>
            <p>{{ $developpement[0]['content'] }}</p>
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ $developpement[0]['github_url'] }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-github me-2"></i>
                        Accéder au dépôt GitHub
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-2">Licence:</span>
                    <span class="badge bg-primary">{{ $developpement[0]['license'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Comment contribuer -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h3>{{ $developpement[1]['title'] }}</h3>
            <p>{{ $developpement[1]['content'] }}</p>

            <div class="border-start border-primary border-3 ps-4 mt-4">
                @foreach($developpement[1]['steps'] as $step)
                <div class="mb-4">
                    <h5>{{ $step['step'] }}. {{ $step['title'] }}</h5>
                    <p class="mb-0">{{ $step['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Environnement de développement -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h3>{{ $developpement[2]['title'] }}</h3>
            <p>{{ $developpement[2]['content'] }}</p>

            <div class="mt-4">
                <h5>Prérequis techniques:</h5>
                <ul>
                    @foreach($developpement[2]['requirements'] as $requirement)
                    <li>{{ $requirement }}</li>
                    @endforeach
                </ul>

                <div class="alert alert-primary mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ $developpement[2]['note'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- Feuille de route -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h3>
                {{ $developpement[3]['title'] }}
                @if(isset($developpement[3]['coming_soon']) && $developpement[3]['coming_soon'])
                <span class="badge bg-light text-primary ms-2">Bientôt disponible</span>
                @endif
            </h3>
            <p>{{ $developpement[3]['content'] }}</p>

            <div class="alert alert-secondary mt-3">
                <i class="bi bi-clock me-2"></i>
                {{ $developpement[3]['note'] }}
            </div>
        </div>
    </div>

    <!-- Guide de style de code -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h3>
                {{ $developpement[4]['title'] }}
                @if(isset($developpement[4]['coming_soon']) && $developpement[4]['coming_soon'])
                <span class="badge bg-light text-primary ms-2">Bientôt disponible</span>
                @endif
            </h3>
            <p>{{ $developpement[4]['content'] }}</p>

            <div class="alert alert-secondary mt-3">
                <i class="bi bi-clock me-2"></i>
                {{ $developpement[4]['note'] }}
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="text-center mt-5">
        <p>{{ $developpement[5]['content'] }}</p>
        <a href="mailto:{{ $developpement[5]['email'] }}" class="btn btn-primary">
            <i class="bi bi-envelope me-2"></i>
            Contacter l'équipe de développement
        </a>
    </div>
    @else
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Les informations sur le développement sont en cours de chargement. Veuillez réessayer ultérieurement.
    </div>
    @endif
</div>
@endsection 