<?php

namespace App\Http\Controllers;

use App\Models\ArticleView;
use Illuminate\Http\Request;

class ArticleViewController extends Controller
{
    /**
     * Affiche une liste des vues d'articles.
     */
    public function index()
    {
        $views = ArticleView::all();
        return response()->json($views);
    }

    /**
     * Affiche une vue spécifique.
     */
    public function show($id)
    {
        $view = ArticleView::findOrFail($id);
        return response()->json($view);
    }

    /**
     * Crée une nouvelle vue d'article.
     */
    public function store(Request $request)
    {
        $view = ArticleView::create($request->all());
        return response()->json($view, 201);
    }

    /**
     * Met à jour une vue existante.
     */
    public function update(Request $request, $id)
    {
        $view = ArticleView::findOrFail($id);
        $view->update($request->all());
        return response()->json($view);
    }

    /**
     * Supprime une vue d'article.
     */
    public function destroy($id)
    {
        ArticleView::destroy($id);
        return response()->json(null, 204);
    }
}
