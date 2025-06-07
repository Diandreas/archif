<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Affiche la page d'accueil du blog avec les articles filtrés.
     */
    public function index(Request $request)
    {
        $articles = Article::query()
            ->when($request->category, fn($query) => $query->where('category_id', $request->category))
            ->when($request->author, fn($query) => $query->where('author_id', $request->author))
            ->when($request->tag, fn($query) => $query->whereHas('tags', fn($q) => $q->where('id', $request->tag)))
            ->latest()
            ->paginate(10);

        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();
        $mostViewedArticles = Article::orderBy('views_count', 'desc')->take(5)->get();
        $latestArticles = Article::latest()->take(5)->get();

        return view('pages.blog', compact('articles', 'categories', 'authors', 'tags', 'mostViewedArticles', 'latestArticles'));
    }

    /**
     * Affiche la page de détail d'un article.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('pages.article', compact('article'));
    }
}
