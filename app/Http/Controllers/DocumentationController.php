<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentationController extends Controller
{
    /**
     * Affiche la page de documentation
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Charger les données de documentation depuis un fichier JSON
        $jsonPath = resource_path('data/documentation.json');
        $documentation = [];
        
        if (File::exists($jsonPath)) {
            $documentation = json_decode(File::get($jsonPath), true);
        }
        
        return view('pages.documentation', compact('documentation'));
    }
} 