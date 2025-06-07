<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Affiche une liste des auteurs.
     */
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    /**
     * Affiche un auteur spécifique.
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);
        return response()->json($author);
    }

    /**
     * Crée un nouvel auteur.
     */
    public function store(Request $request)
    {
        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    /**
     * Met à jour un auteur existant.
     */
    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());
        return response()->json($author);
    }

    /**
     * Supprime un auteur.
     */
    public function destroy($id)
    {
        Author::destroy($id);
        return response()->json(null, 204);
    }
}
