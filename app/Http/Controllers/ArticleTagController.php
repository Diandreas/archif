<?php

namespace App\Http\Controllers;

use App\Models\ArticleTag;
use Illuminate\Http\Request;

class ArticleTagController extends Controller
{
    /**
     * Affiche une liste des relations article-tag.
     */
    public function index()
    {
        $articleTags = ArticleTag::all();
        return response()->json($articleTags);
    }

    /**
     * Affiche une relation spécifique article-tag.
     */
    public function show($id)
    {
        $articleTag = ArticleTag::findOrFail($id);
        return response()->json($articleTag);
    }

    /**
     * Crée une nouvelle relation article-tag.
     */
    public function store(Request $request)
    {
        $articleTag = ArticleTag::create($request->all());
        return response()->json($articleTag, 201);
    }

    /**
     * Met à jour une relation existante article-tag.
     */
    public function update(Request $request, $id)
    {
        $articleTag = ArticleTag::findOrFail($id);
        $articleTag->update($request->all());
        return response()->json($articleTag);
    }

    /**
     * Supprime une relation article-tag.
     */
    public function destroy($id)
    {
        ArticleTag::destroy($id);
        return response()->json(null, 204);
    }
}
