<?php

namespace App\Http\Controllers;

use App\Models\PromotionalBox;
use Illuminate\Http\Request;

class PromotionalBoxController extends Controller
{
    /**
     * Affiche une liste des boîtes promotionnelles.
     */
    public function index()
    {
        $promotionalBoxes = PromotionalBox::all();
        return response()->json($promotionalBoxes);
    }

    /**
     * Affiche une boîte promotionnelle spécifique.
     */
    public function show($id)
    {
        $promotionalBox = PromotionalBox::findOrFail($id);
        return response()->json($promotionalBox);
    }

    /**
     * Crée une nouvelle boîte promotionnelle.
     */
    public function store(Request $request)
    {
        $promotionalBox = PromotionalBox::create($request->all());
        return response()->json($promotionalBox, 201);
    }

    /**
     * Met à jour une boîte promotionnelle existante.
     */
    public function update(Request $request, $id)
    {
        $promotionalBox = PromotionalBox::findOrFail($id);
        $promotionalBox->update($request->all());
        return response()->json($promotionalBox);
    }

    /**
     * Supprime une boîte promotionnelle.
     */
    public function destroy($id)
    {
        PromotionalBox::destroy($id);
        return response()->json(null, 204);
    }
}
