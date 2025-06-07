<?php

namespace App\Http\Controllers;

use App\Models\RelatedArticle;
use Illuminate\Http\Request;

class RelatedArticleController extends Controller
{
    /**
     * Affiche une liste des articles reliés.
     */
    public function index()
    {
        $relatedArticles = RelatedArticle::all();
        return response()->json($relatedArticles);
    }

    /**
     * Affiche un article relié spécifique.
     */
    public function show($id)
    {
        $relatedArticle = RelatedArticle::findOrFail($id);
        return response()->json($relatedArticle);
    }

    /**
     * Crée une nouvelle relation d'article.
     */
    public function store(Request $request)
    {
        $relatedArticle = RelatedArticle::create($request->all());
        return response()->json($relatedArticle, 201);
    }

    /**
     * Met à jour une relation existante.
     */
    public function update(Request $request, $id)
    {
        $relatedArticle = RelatedArticle::findOrFail($id);
        $relatedArticle->update($request->all());
        return response()->json($relatedArticle);
    }

    /**
     * Supprime une relation d'article.
     */
    public function destroy($id)
    {
        RelatedArticle::destroy($id);
        return response()->json(null, 204);
    }
}
