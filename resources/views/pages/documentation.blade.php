@extends('layouts.app')

@section('title', 'Documentation')
@section('description', 'Documentation complète pour ARCHIF, la solution d\'archivage électronique open source africaine. Guides d\'utilisation, API et manuels techniques.')
@section('keywords', 'documentation archif, guide utilisateur, API, manuel technique, archivage électronique, open source, Cameroun')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left fs-4 me-2"></i>
                Retour à l'accueil
            </a>
        </div>
        <h1 class="display-4 fw-bold">Documentation ARCHIF</h1>
        <p class="lead">Guide complet d'utilisation du système d'archivage électronique ARCHIF</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="sticky-top pt-3 doc-sidebar">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Documentation</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @if(isset($documentation))
                            @foreach($documentation as $section)
                                <a href="#{{ $section['id'] }}" class="list-group-item list-group-item-action">{{ $section['title'] }}</a>
                            @endforeach
                        @else
                            <a href="#introduction" class="list-group-item list-group-item-action">Introduction</a>
                            <a href="#installation" class="list-group-item list-group-item-action">Installation</a>
                            <a href="#configuration" class="list-group-item list-group-item-action">Configuration</a>
                            <a href="#utilisation" class="list-group-item list-group-item-action">Guide d'utilisation</a>
                            <a href="#api" class="list-group-item list-group-item-action">API</a>
                            <a href="#migration" class="list-group-item list-group-item-action">Migration des données</a>
                            <a href="#securite" class="list-group-item list-group-item-action">Sécurité</a>
                            <a href="#mise-a-jour" class="list-group-item list-group-item-action">Mises à jour</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body doc-content">
                    @if(isset($documentation))
                        @foreach($documentation as $section)
                            <section id="{{ $section['id'] }}" class="mb-5">
                                <h2 class="border-bottom pb-2 mb-4">{{ $section['title'] }}</h2>
                                <p>{!! nl2br(e($section['content'])) !!}</p>
                                
                                @if(isset($section['note']))
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Note:</strong> {{ $section['note'] }}
                                    </div>
                                @endif
                                
                                @if(isset($section['subsections']))
                                    @foreach($section['subsections'] as $subsection)
                                        <h4 class="mt-4 mb-3">{{ $subsection['title'] }}</h4>
                                        
                                        @if(is_array($subsection['content']))
                                            <ul>
                                                @foreach($subsection['content'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>{!! nl2br(e($subsection['content'])) !!}</p>
                                        @endif
                                        
                                        @if(isset($subsection['tip']))
                                            <div class="alert alert-info mt-3">
                                                <i class="bi bi-lightbulb me-2"></i>
                                                <strong>Conseil :</strong> {{ $subsection['tip'] }}
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </section>
                        @endforeach
                    @else
                        <section id="introduction" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Introduction</h2>
                            <p>
                                Bienvenue dans la documentation officielle d'ARCHIF, la première solution d'archivage électronique
                                open source conçue pour répondre aux besoins spécifiques des organisations africaines.
                            </p>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> Cette documentation est régulièrement mise à jour pour refléter les dernières
                                fonctionnalités disponibles dans ARCHIF.
                            </div>
                        </section>

                        <section id="installation" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Installation</h2>
                            <p>
                                ARCHIF peut être installé de plusieurs façons selon vos besoins spécifiques. Vous pouvez utiliser
                                notre script d'installation automatisé ou installer manuellement les composants.
                            </p>

                            <h4 class="mt-4 mb-3">Prérequis</h4>
                            <ul>
                                <li>Serveur PHP 7.4 ou supérieur</li>
                                <li>Base de données MySQL 5.7 ou MariaDB 10.2+</li>
                                <li>Serveur Web (Apache, Nginx)</li>
                                <li>Extensions PHP : mbstring, xml, curl, gd, zip</li>
                            </ul>

                            <h4 class="mt-4 mb-3">Installation rapide</h4>
                            <p>
                                Clonez le dépôt GitHub et exécutez le script d'installation :
                            </p>
                            <pre class="bg-light p-3 rounded"><code>git clone https://github.com/omgbwa-yasse/shelves.git
cd shelves
php install.php</code></pre>
                        </section>

                        <section id="configuration" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Configuration</h2>
                            <p>
                                Après l'installation, vous devrez configurer ARCHIF selon les besoins de votre organisation. Les
                                paramètres principaux sont définis dans le fichier <code>config.php</code>.
                            </p>

                            <h4 class="mt-4 mb-3">Base de données</h4>
                            <p>
                                Configurez les paramètres de connexion à votre base de données :
                            </p>
                            <pre class="bg-light p-3 rounded"><code>'database' => [
    'host' => 'localhost',
    'name' => 'archif_db',
    'user' => 'root',
    'password' => 'votre_mot_de_passe',
    'charset' => 'utf8mb4',
],</code></pre>
                        </section>

                        <section id="utilisation" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Guide d'utilisation</h2>
                            <p>
                                Cette section vous guide à travers les fonctionnalités principales d'ARCHIF et comment les utiliser
                                efficacement.
                            </p>

                            <h4 class="mt-4 mb-3">Tableau de bord</h4>
                            <p>
                                Le tableau de bord vous donne une vue d'ensemble de votre système d'archivage, avec des statistiques
                                clés et des accès rapides aux fonctionnalités essentielles.
                            </p>

                            <h4 class="mt-4 mb-3">Gestion des documents</h4>
                            <p>
                                ARCHIF vous permet de gérer l'ensemble du cycle de vie de vos documents, de la réception à
                                l'archivage définitif.
                            </p>

                            <div class="alert alert-info mt-3">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>Conseil :</strong> Utilisez les modèles prédéfinis pour accélérer la classification de vos
                                documents.
                            </div>
                        </section>

                        <section id="api" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">API</h2>
                            <p>
                                ARCHIF fournit une API RESTful complète permettant d'intégrer vos applications existantes avec le
                                système d'archivage.
                            </p>

                            <h4 class="mt-4 mb-3">Authentification</h4>
                            <p>
                                Toutes les requêtes API nécessitent une authentification via un token JWT :
                            </p>
                            <pre class="bg-light p-3 rounded"><code>curl -X GET \
  https://votre-serveur.com/api/documents \
  -H 'Authorization: Bearer votre_token_jwt'</code></pre>
                        </section>

                        <section id="migration" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Migration des données</h2>
                            <p>
                                Si vous migrez depuis un autre système d'archivage, ARCHIF fournit des outils pour faciliter ce
                                processus.
                            </p>
                        </section>

                        <section id="securite" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Sécurité</h2>
                            <p>
                                La sécurité est une priorité dans ARCHIF. Le système implémente plusieurs niveaux de protection pour
                                garantir l'intégrité et la confidentialité de vos archives.
                            </p>
                        </section>

                        <section id="mise-a-jour" class="mb-5">
                            <h2 class="border-bottom pb-2 mb-4">Mises à jour</h2>
                            <p>
                                Pour mettre à jour ARCHIF vers la dernière version, utilisez la commande suivante :
                            </p>
                            <pre class="bg-light p-3 rounded"><code>php artisan archif:update</code></pre>

                            <p>
                                Consultez toujours les notes de version avant de procéder à une mise à jour importante.
                            </p>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 