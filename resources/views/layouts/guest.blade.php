<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO: Titre optimisé pour les mots-clés et la longueur -->
    <title>@yield('title', 'Solution d\'Archivage Électronique Open Source Africaine') | ARCHIF</title>

    <!-- SEO: Meta description optimisée et incluant un call-to-action -->
    <meta name="description" content="@yield('description', 'Simplifiez votre gestion documentaire avec ARCHIF, la première solution d\'archivage électronique open source africaine. Téléchargez gratuitement ou essayez la démo !')">

    <!-- SEO: Mots-clés ciblés et pertinents -->
    <meta name="keywords" content="@yield('keywords', 'archivage électronique, archif, gestion documentaire, open source, système archivage, SAE, archives numériques, archivage afrique, solution archivage cameroun')">

    <!-- SEO: Autres méta-données importantes -->
    <meta name="author" content="ARCHIF">
    <meta name="robots" content="index, follow">
    <meta name="language" content="French">
    <meta name="revisit-after" content="7 days">

    <!-- SEO: URL canonique -->
    <link rel="canonical" href="{{ url()->current() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">

    <!-- SEO: Open Graph pour le partage social (Facebook, WhatsApp) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'ARCHIF | La solution africaine de gestion documentaire')">
    <meta property="og:description" content="@yield('description', 'Solution 100% gratuite pour gérer vos archives numériques. Développée au Cameroun pour répondre aux besoins spécifiques africains.')">
    <meta property="og:image" content="https://archivefacile.com/assets/img/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="ARCHIF">

    <!-- SEO: Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'ARCHIF | Solution d\'Archivage Électronique African')">
    <meta name="twitter:description" content="@yield('description', 'Gérez facilement vos documents numériques avec notre solution 100% gratuite et open source, conçue au Cameroun.')">
    <meta name="twitter:image" content="https://archivefacile.com/assets/img/og-image.png">

    <!-- Schema.org pour les sitelinks Google -->
    @include('partials.schema-markup')

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Script de collecte de données utilisateur -->
    <script src="{{ asset('assets/js/user-data-collector.js') }}"></script>

    <style>
        /* Amélioration des couleurs du footer */
        .footer {
            background-color: #1e293b;
        }
        .footer h5 {
            color: #ffffff;
            font-weight: 600;
        }
        .fo#000000ext-white-50 {
            color: #cbd5e1 !important;
        }
        .footer a.text-white-50 {
            color: #cbd5e1 !important;
            transition: color 0.2s ease;
        }
        .footer a.text-white-50:hover {
            color: #ffffff !important;
            text-decoration: underline !important;
        }
        .footer .btn-outline-light {
            border-color: #cbd5e1;
            color: #cbd5e1;
        }
        .footer .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
    </style>

    @stack('styles')
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-archive fs-3 text-primary me-2" aria-hidden="true"></i>
            <span class="fw-bold">ARCHIF</span>
            <span class="open-source-badge">
                    <i class="bi bi-code" aria-hidden="true"></i> Open Source
                </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- {{ asset('http://127.0.0.1:8000/assets/img/og-image.png') }} --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('documentation') ? 'active' : '' }}" href="{{ route('documentation') }}">Documentation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('tutoriels') ? 'active' : '' }}" href="{{ route('tutoriels') }}">Tutoriels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('developpement') ? 'active' : '' }}" href="{{ route('developpement') }}">Développement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
                </li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a class="btn btn-outline-primary px-4 me-2" href="#" data-bs-toggle="modal" data-bs-target="#demoModal">Démo</a>
                </li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a class="btn btn-primary px-4" href="https://github.com/omgbwa-yasse/shelves" target="_blank">Télécharger</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<main>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</main>

<!-- Footer -->
<!-- Modale demande de démo -->
@include('partials.demo-modal')

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@stack('scripts')
</body>

</html>
