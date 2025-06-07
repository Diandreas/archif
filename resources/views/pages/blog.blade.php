@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Bienvenue sur le Blog</h1>

    <!-- Filtres -->
    <div class="mb-4">
        <form method="GET" action="{{ route('blog.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <select name="category" class="form-control">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="author" class="form-control">
                        <option value="">Tous les auteurs</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="tag" class="form-control">
                        <option value="">Tous les tags</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </form>
    </div>

    <!-- Menu latéral -->
    <div class="row">
        <div class="col-md-8">
            <!-- Liste des articles (contenu principal) -->
            <div class="row">
                @forelse($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" class="card-img-top" alt="{{ $article->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ Str::limit($article->excerpt, 100) }}</p>
                                <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-primary">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Aucun article trouvé.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>
        <div class="col-md-4">
            <!-- Articles les plus consultés -->
            <div class="mb-4">
                <h5>Articles les plus consultés</h5>
                <ul class="list-group">
                    @foreach($mostViewedArticles as $article)
                        <li class="list-group-item">
                            <a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a>
                            <span class="badge bg-primary float-end">{{ $article->views_count }} vues</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Nouveaux articles -->
            <div>
                <h5>5 Nouveaux Articles</h5>
                <ul class="list-group">
                    @foreach($latestArticles as $article)
                        <li class="list-group-item">
                            <a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a>
                            <span class="text-muted float-end">{{ $article->created_at->format('d/m/Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
