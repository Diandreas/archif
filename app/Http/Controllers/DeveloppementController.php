<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DeveloppementController extends Controller
{
    /**
     * Affiche la page de développement
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Charger les données de développement depuis un fichier JSON
        $jsonPath = resource_path('data/developpement.json');
        $developpement = [];
        
        if (File::exists($jsonPath)) {
            $developpement = json_decode(File::get($jsonPath), true);
        }
        
        return view('pages.developpement', compact('developpement'));
    }
} 