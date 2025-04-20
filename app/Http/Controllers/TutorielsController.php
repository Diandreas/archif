<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TutorielsController extends Controller
{
    /**
     * Affiche la page des tutoriels
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Charger les tutoriels depuis un fichier JSON
        $jsonPath = resource_path('data/tutoriels.json');
        $tutoriels = [];
        
        if (File::exists($jsonPath)) {
            $tutoriels = json_decode(File::get($jsonPath), true);
        } else {
            // Tutoriels par défaut si le fichier JSON n'existe pas
            $tutoriels = [
                [
                    'title' => 'Débuter avec ARCHIF',
                    'level' => 'Débutant',
                    'duration' => '15 min',
                    'description' => 'Un guide pour les nouveaux utilisateurs d\'ARCHIF',
                    'available' => false
                ],
                [
                    'title' => 'Configuration du plan de classement',
                    'level' => 'Intermédiaire',
                    'duration' => '30 min',
                    'description' => 'Apprenez à structurer efficacement vos archives',
                    'available' => false
                ],
                [
                    'title' => 'Gestion avancée du courrier',
                    'level' => 'Avancé',
                    'duration' => '45 min',
                    'description' => 'Optimisez votre flux de travail de correspondance',
                    'available' => false
                ],
                [
                    'title' => 'Administration système',
                    'level' => 'Expert',
                    'duration' => '60 min',
                    'description' => 'Guide complet pour les administrateurs système',
                    'available' => false
                ]
            ];
        }
        
        return view('pages.tutoriels', compact('tutoriels'));
    }
} 