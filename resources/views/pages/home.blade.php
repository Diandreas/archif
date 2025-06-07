@extends('layouts.app')

@section('title', 'Solution d\'Archivage Électronique Open Source Africaine')
@section('description', 'Simplifiez votre gestion documentaire avec ARCHIF, la première solution d\'archivage électronique open source africaine. Téléchargez gratuitement ou essayez la démo !')
@section('keywords', 'archivage électronique, archif, gestion documentaire, open source, système archivage, SAE, archives numériques, archivage afrique, solution archivage cameroun')

@section('content')
<!-- Hero Section -->




<!-- Bandeau À la Une -->
<section class="bandeau-une py-3 mb-5">
    <div class="container">
        <div class="row align-items-center gy-4">
            <!-- Image et titre À la Une -->
            <div class="col-lg-4 text-center text-lg-start">
                <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}" alt="À la Une ARCHIF" class="img-fluid rounded shadow-sm mb-3" width="350" height="200" loading="lazy">
                <h2 class="fw-bold text-dark ">À la Une : ARCHIF simplifie l’archivage électronique</h2>
                <p class="text-muted mb-0">
                    {{ \Illuminate\Support\Str::words("Découvrez comment ARCHIF révolutionne la gestion documentaire en Afrique avec une solution open source, sécurisée et accessible à tous.", 12, '...') }}
                </p>
            </div>
            <!-- Boxes en grille 2x2 -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-6 col-md-6">
                        <div class="card h-100 border-0">
                            <div class="d-flex align-items-center h-100">
                                <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}" class="ms-3 rounded" alt="Box 1" style="width:80px; height:80px; object-fit:cover;">
                                <div class="flex-grow-1 p-3">
                                    <h5 class="card-title mb-1">Developpement des industries d'aménagement des archives</h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::words("Découvrez comment ARCHIF révolutionne la gestion documentaire en Afrique avec une solution open source, sécurisée et accessible à tous.", 12, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="card h-100 border-0">
                            <div class="d-flex align-items-center h-100">
                                <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}" class="ms-3 rounded" alt="Box 2" style="width:80px; height:80px; object-fit:cover;">
                                <div class="flex-grow-1 p-3">
                                    <h5 class="card-title mb-1">Système d'archivage intelligent </h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::words("Découvrez comment ARCHIF révolutionne la gestion documentaire en Afrique avec une solution open source, sécurisée et accessible à tous.", 12, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="card h-100 border-0">
                            <div class="d-flex align-items-center h-100">
                                <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}" class="ms-3 rounded" alt="Box 4" style="width:80px; height:80px; object-fit:cover;">
                                <div class="flex-grow-1 p-3">
                                    <h5 class="card-title mb-1">Amélioration des politique d'archivage</h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::words("Découvrez comment ARCHIF révolutionne la gestion documentaire en Afrique avec une solution open source, sécurisée et accessible à tous.", 12, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="card h-100 border-0">
                            <div class="d-flex align-items-center h-100">
                                <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}" class="ms-3 rounded" alt="Box 6" style="width:80px; height:80px; object-fit:cover;">
                                <div class="flex-grow-1 p-3">
                                    <h5 class="card-title mb-1">Développer des système d'archivage</h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::words("Découvrez comment ARCHIF révolutionne la gestion documentaire en Afrique avec une solution open source, sécurisée et accessible à tous.", 12, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-2 bg-grey text-white">
    <div class="container">
        <div class="row g-1 border-0">
            @php
                $boxes = [
                    [
                        'text' => 'Conservez vos documents numériques en toute sécurité grâce à un système conforme aux normes.',
                        'category' => 'Sécurité'
                    ],
                    [
                        'text' => 'Trouvez instantanément vos fichiers grâce à une recherche multicritères performante.',
                        'category' => 'Productivité'
                    ],
                    [
                        'text' => 'Travaillez en équipe sur vos archives et partagez l’information facilement.',
                        'category' => 'Collaboration'
                    ],
                    [
                        'text' => 'Profitez d’une interface intuitive et agréable, pensée pour tous les utilisateurs.',
                        'category' => 'Design'
                    ],
                    [
                        'text' => 'Bénéficiez d’une solution libre, évolutive et adaptée à vos besoins spécifiques.',
                        'category' => 'Liberté'
                    ],
                    [
                        'text' => 'Un accompagnement et une expertise adaptés au contexte africain.',
                        'category' => 'Afrique'
                    ],
                ];
            @endphp
            @foreach($boxes as $box)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card h-100 border-0">
                        <div class="card-body p-3">
                            <p class="card-text text-muted mb-2" style="font-size: 0.95rem;">
                                {{ \Illuminate\Support\Str::limit($box['text'], 50) }}
                            </p>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $box['category'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


@push('styles')
<style>
    .bandeau-une.py-6 {
        padding-top: 6rem !important;
        padding-bottom: 6rem !important;
    }
    @media (max-width: 991.98px) {
        .bandeau-une .row.g-4 > [class^="col-"] {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endpush


<section class="hero-section">
    <div class="hero-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <!-- SEO: Microdata pour la localisation -->
                <div class="d-flex align-items-center mb-3">
                    <div class="cameroon-flag" aria-label="Drapeau du Cameroun">
                        <span class="cameroon-green"></span>
                        <span class="cameroon-red"></span>
                        <span class="cameroon-yellow"></span>
                    </div>
                    <span class="text-muted">Développé au Cameroun</span>
                    <span class="badge bg-primary ms-2">Nouveau</span>
                </div>

                <!-- SEO: H1 principal avec mot-clé ciblé -->
                <h1 class="display-4 fw-bold mb-3">Transformez votre gestion d'archives numériques</h1>

                <!-- SEO: Paragraphe descriptif avec mots-clés secondaires naturellement intégrés -->
                <p class="lead mb-4">ARCHIF est la première solution d'archivage électronique open source conçue
                    pour les besoins africains. Gérez, conservez et retrouvez vos documents en toute sécurité,
                    conformément aux exigences légales et avec une interface adaptée à vos besoins spécifiques.</p>

                <!-- SEO: Call-to-action clairs avec verbes d'action -->
                <div class="d-flex flex-wrap gap-2">
                    <a href="https://github.com/omgbwa-yasse/shelves" class="btn btn-primary btn-lg px-4 py-2"
                        aria-label="Télécharger ARCHIF gratuitement">
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Télécharger gratuitement
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg px-4 py-2" data-bs-toggle="modal" data-bs-target="#demoModal"
                        aria-label="Voir la démonstration d'ARCHIF">
                        <i class="bi bi-play-circle me-2" aria-hidden="true"></i>Voir la démo
                    </a>
                </div>

                <!-- SEO: Liste de caractéristiques clés avec icônes -->
                <div class="mt-4">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-primary me-2 fs-4" aria-hidden="true"></i>
                                <div>
                                    <strong>Open Source</strong>
                                    <div class="text-muted small">Liberté totale</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check text-primary me-2 fs-4" aria-hidden="true"></i>
                                <div>
                                    <strong>Sécurisé</strong>
                                    <div class="text-muted small">Données protégées</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-gear text-primary me-2 fs-4" aria-hidden="true"></i>
                                <div>
                                    <strong>Personnalisable</strong>
                                    <div class="text-muted small">À votre image</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-globe text-primary me-2 fs-4" aria-hidden="true"></i>
                                <div>
                                    <strong>Made in Africa</strong>
                                    <div class="text-muted small">Pour nos besoins</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO: Image optimisée avec attributs alt descriptifs, largeur et hauteur définies -->
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="position-relative">
                    <img src="{{ asset('image/medium-shot-woman-working-as-lawyer_23-2151202455.jpg') }}"
                        alt="Interface d'ARCHIF - Gestion documentaire avec une professionnelle utilisant le système d'archivage électronique"
                        class="img-fluid rounded-3 shadow-lg" width="650" height="433" loading="eager" />
                    <div
                        class="position-absolute top-0 end-0 bg-primary text-white px-3 py-2 rounded-pill mt-3 me-3">
                        Version 1.0
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="fonctionnalites">
    <div class="container py-4">
        <!-- SEO: Structure de page claire avec H2 pour les sections principales -->
        <div class="text-center mb-5">
            <span class="badge bg-primary mb-2">Tout ce dont vous avez besoin</span>
            <h2 class="display-5 fw-bold">Une solution complète pour vos archives</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">ARCHIF combine les outils essentiels pour
                la gestion de vos documents, du processus de réception jusqu'à l'archivage définitif, en passant par
                le traitement et la recherche avancée.</p>
        </div>

        <!-- SEO: Structure de contenu avec H3 pour les sous-sections -->
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-envelope fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Gestion de Courrier</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Essentiel</span>
                    </div>
                    <p class="text-muted mb-0">Gérez efficacement les flux de correspondance, de leur réception à
                        leur archivage final, avec un système de suivi complet.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-folder2-open fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Répertoire Intelligent</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Innovant</span>
                    </div>
                    <p class="text-muted mb-0">Indexation et classification des documents selon un plan de
                        classement précis et personnalisable selon vos besoins.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-search fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Recherche Avancée</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Puissant</span>
                    </div>
                    <p class="text-muted mb-0">Retrouvez instantanément vos documents grâce à un moteur de recherche
                        puissant et des filtres personnalisés.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-arrow-left-right fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Transfert Sécurisé</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Sécurisé</span>
                    </div>
                    <p class="text-muted mb-0">Versement de documents dans le SAE avec traçabilité complète et
                        garantie d'intégrité des données.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-megaphone fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Barbillard</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Collaboratif</span>
                    </div>
                    <p class="text-muted mb-0">Tableau d'affichage numérique pour partager les informations
                        importantes et les notifications concernant les archives.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card card p-4 h-100">
                    <div class="card-icon">
                        <i class="bi bi-archive fs-4 text-primary" aria-hidden="true"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold mb-0">Dépôt Sécurisé</h3>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Conforme</span>
                    </div>
                    <p class="text-muted mb-0">Conservation à long terme des documents, garantissant authenticité et
                        intégrité avec des contrôles d'accès stricts.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Screenshots Section -->
<section class="py-5 bg-light" id="screenshots">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Découvrez l'interface</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Une interface moderne, intuitive et
                efficace pour gérer vos archives numériques.</p>
        </div>

        <!-- SEO: Images optimisées avec attributs alt descriptifs et chargement différé -->
        <div class="row g-4">
            <div class="col-md-6 mb-4">
                <div class="screenshot-wrapper">
                    <img src="{{ asset('capture/Capture web_7-4-2025_22040_127.0.0.1.jpeg') }}"
                        alt="Module d'outils de gestion d'ARCHIF - Interface administrateur pour la configuration du système d'archivage électronique"
                        class="img-fluid" width="600" height="350" loading="lazy" />
                </div>
                <h4 class="mt-3 text-center">Module de gestion des outils</h4>
            </div>

            <div class="col-md-6 mb-4">
                <div class="screenshot-wrapper">
                    <img src="{{ asset('capture/Capture web_7-4-2025_22518_127.0.0.1.jpeg') }}"
                        alt="Module de gestion des archives ARCHIF - Interface principale pour le classement et l'organisation des documents numériques"
                        class="img-fluid" width="600" height="350" loading="lazy" />
                </div>
                <h4 class="mt-3 text-center">Module de gestion des archives</h4>
            </div>

            <div class="col-md-6 mb-4">
                <div class="screenshot-wrapper">
                    <img src="{{ asset('capture/Capture web_7-4-2025_22632_127.0.0.1.jpeg') }}"
                        alt="Recherche avancée d'ARCHIF - Interface de recherche multicritères pour retrouver rapidement des documents"
                        class="img-fluid" width="600" height="350" loading="lazy" />
                </div>
                <h4 class="mt-3 text-center">Recherche avancée de documents</h4>
            </div>

            <div class="col-md-6 mb-4">
                <div class="screenshot-wrapper">
                    <img src="{{ asset('capture/Capture web_7-4-2025_21651_127.0.0.1.jpeg') }}"
                        alt="Module de gestion du courrier ARCHIF - Interface pour la gestion des correspondances entrantes et sortantes"
                        class="img-fluid" width="600" height="350" loading="lazy" />
                </div>
                <h4 class="mt-3 text-center">Module de gestion du courrier</h4>
            </div>
        </div>
    </div>
</section>

<!-- SEO: Conclusion CTA -->
<section class="py-5 bg-primary text-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-3">Prêt à démarrer avec ARCHIF ?</h2>
                <p class="lead mb-4">Rejoignez les organisations qui ont choisi ARCHIF pour transformer leur gestion
                    documentaire. Téléchargez gratuitement la solution ou contactez notre équipe pour en savoir
                    plus.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="https://github.com/omgbwa-yasse/shelves"
                        class="btn btn-light btn-lg px-4 py-2 fw-bold text-primary">
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Télécharger ARCHIF
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg px-4 py-2" data-bs-toggle="modal" data-bs-target="#demoModal">
                        <i class="bi bi-play-circle me-2" aria-hidden="true"></i>Essayer la démo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Variables CSS pour cohérence et facilité de maintenance */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --secondary: #475569;
        --light: #f8fafc;
        --dark: #1e293b;
        --success: #10b981;
        --success-light: rgba(16, 185, 129, 0.1);
        --warning: #f59e0b;
        --danger: #ef4444;
        --border-radius: 0.75rem;
        --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Section Hero */
    .hero-section {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232563eb' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
        z-index: 0;
    }

    /* Drapeau camerounais */
    .cameroon-flag {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }

    .cameroon-flag span {
        display: inline-block;
        width: 8px;
        height: 20px;
    }

    .cameroon-green {
        background-color: #007a5e;
    }

    .cameroon-red {
        background-color: #ce1126;
    }

    .cameroon-yellow {
        background-color: #fcd116;
    }

    .open-source-badge {
        display: inline-block;
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        margin-left: 1rem;
    }

    /* Cartes de fonctionnalités */
    .feature-card {
        border: none;
        border-radius: var(--border-radius);
        transition: var(--transition);
        height: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow);
    }

    .card-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(37, 99, 235, 0.1);
        border-radius: 12px;
        margin-bottom: 1.25rem;
    }

    .screenshot-wrapper {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
    }

    .screenshot-wrapper:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
