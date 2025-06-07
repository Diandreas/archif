<?php

namespace App\Http\Controllers;

use App\Models\ArticleImage;
use Illuminate\Http\Request;

class ArticleImageController extends Controller
{
    /**
     * Affiche une liste des images d'articles.
     */
    public function index()
    {
        $images = ArticleImage::all();
        return response()->json($images);
    }

    /**
     * Affiche une image spécifique.
     */
    public function show($id)
    {
        $image = ArticleImage::findOrFail($id);
        return response()->json($image);
    }

    /**
     * Crée une nouvelle image d'article.
     */
    public function store(Request $request)
    {
        $image = ArticleImage::create($request->all());
        return response()->json($image, 201);
    }

    /**
     * Met à jour une image existante.
     */
    public function update(Request $request, $id)
    {
        $image = ArticleImage::findOrFail($id);
        $image->update($request->all());
        return response()->json($image);
    }

    /**
     * Supprime une image d'article.
     */
    public function destroy($id)
    {
        ArticleImage::destroy($id);
        return response()->json(null, 204);
    }
}
