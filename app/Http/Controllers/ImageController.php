<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Affiche une liste des images.
     */
    public function index()
    {
        $images = Image::all();
        return response()->json($images);
    }

    /**
     * Affiche une image spécifique.
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);
        return response()->json($image);
    }

    /**
     * Crée une nouvelle image.
     */
    public function store(Request $request)
    {
        $image = Image::create($request->all());
        return response()->json($image, 201);
    }

    /**
     * Met à jour une image existante.
     */
    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->update($request->all());
        return response()->json($image);
    }

    /**
     * Supprime une image.
     */
    public function destroy($id)
    {
        Image::destroy($id);
        return response()->json(null, 204);
    }
}