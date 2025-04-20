<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FaqController extends Controller
{
    /**
     * Affiche la page FAQ
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Charger les FAQs depuis un fichier JSON
        $jsonPath = resource_path('data/faq.json');
        $faqs = [];
        
        if (File::exists($jsonPath)) {
            $faqs = json_decode(File::get($jsonPath), true);
        } else {
            // FAQs par défaut si le fichier JSON n'existe pas
            $faqs = [
                [
                    'question' => 'Qu\'est-ce qu\'ARCHIF ?',
                    'answer' => 'ARCHIF est un Système d\'Archivage Électronique (SAE) open source développé au Cameroun. Il permet de gérer, conserver et retrouver des documents d\'archives en toute sécurité, conformément aux exigences légales.'
                ],
                [
                    'question' => 'ARCHIF est-il vraiment gratuit ?',
                    'answer' => 'Oui, ARCHIF est 100% open source et gratuit, disponible sous licence GNU GPL v3. Vous pouvez l\'utiliser, le modifier et le redistribuer sans frais de licence.'
                ],
                [
                    'question' => 'Quels sont les prérequis techniques pour installer ARCHIF ?',
                    'answer' => 'Les prérequis techniques complets seront détaillés dans la documentation d\'installation, actuellement en cours de développement. ARCHIF est basé sur Laravel et nécessitera généralement un serveur web, PHP, et une base de données MySQL ou PostgreSQL.'
                ],
                [
                    'question' => 'Comment puis-je contribuer au projet ARCHIF ?',
                    'answer' => 'Vous pouvez contribuer de plusieurs façons : en signalant des bugs, en proposant des améliorations, en contribuant au code source via GitHub, ou en aidant à traduire l\'application. Consultez notre page de développement pour plus d\'informations.'
                ],
                [
                    'question' => 'ARCHIF est-il adapté à ma petite organisation ?',
                    'answer' => 'Absolument ! ARCHIF est conçu pour être flexible et s\'adapter aux besoins des organisations de toutes tailles, des petites structures aux grandes entreprises et administrations.'
                ],
                [
                    'question' => 'Où puis-je obtenir de l\'aide si j\'ai des problèmes avec ARCHIF ?',
                    'answer' => 'Vous pouvez consulter la documentation et les tutoriels disponibles sur ce site. Pour une assistance plus personnalisée, vous pouvez contacter l\'équipe via les coordonnées fournies dans la section Contact.'
                ]
            ];
        }
        
        return view('pages.faq', compact('faqs'));
    }
} 