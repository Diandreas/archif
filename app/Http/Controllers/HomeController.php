<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Enregistre la page d'atterrissage en session pour le suivi
        if (!$request->session()->has('landing_page')) {
            $request->session()->put('landing_page', url()->current());
        }
        
        return view('pages.home');
    }
} 