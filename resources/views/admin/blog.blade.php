@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête avec actions principales -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Gestion du Blog</h1>
            <p class="mb-0 text-muted">Gérez vos articles et catégories</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-success me-2" id="create-article" data-bs-toggle="modal" data-bs-target="#article-modal">
                <i class="fas fa-plus me-1"></i> Nouvel Article
            </button>
            <button class="btn btn-outline-success" id="create-category" data-bs-toggle="modal" data-bs-target="#category-modal">
                <i class="fas fa-folder-plus me-1"></i> Nouvelle Catégorie
            </button>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <ul class="nav nav-tabs mb-4" id="managementTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles-pane" type="button" role="tab">
                <i class="fas fa-newspaper me-1"></i> Articles <span class="badge bg-primary ms-1">{{ count($articles) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-pane" type="button" role="tab">
                <i class="fas fa-tags me-1"></i> Catégories <span class="badge bg-secondary ms-1">{{ count($categories) }}</span>
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="managementTabsContent">
        <!-- Onglet Articles -->
        <div class="tab-pane fade show active" id="articles-pane" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">Liste des Articles</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-articles" placeholder="Rechercher un article...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Titre</th>
                                    <th>Catégorie</th>
                                    <th>Auteur</th>
                                    <th>Date de création</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="articles-list">
                                @forelse($articles as $article)
                                <tr data-id="{{ $article->id }}" class="article-row">
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-primary">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $article->title }}</h6>
                                                @if($article->excerpt)
                                                <small class="text-muted">{{ Str::limit($article->excerpt, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($article->category)
                                        <span class="badge bg-info">{{ $article->category->name }}</span>
                                        @else
                                        <span class="text-muted">Non défini</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-circle bg-primary text-white">
                                                    {{ substr($article->author->name ?? 'N', 0, 1) }}
                                                </div>
                                            </div>
                                            {{ $article->author->name ?? 'Non défini' }}
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $article->created_at->format('d/m/Y') ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $article->published ? 'bg-success' : 'bg-warning' }}">
                                            {{ $article->published ? 'Publié' : 'Brouillon' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary edit-article" data-id="{{ $article->id }}" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info view-article" data-id="{{ $article->id }}" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger delete-article" data-id="{{ $article->id }}" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block text-muted opacity-50"></i>
                                        Aucun article trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Catégories -->
        <div class="tab-pane fade" id="categories-pane" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Gestion des Catégories</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Nom</th>
                                    <th>Description</th>
                                    <th>Nombre d'articles</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categories-list">
                                @forelse($categories as $category)
                                <tr data-id="{{ $category->id }}" class="category-row">
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tag text-info me-2"></i>
                                            <strong>{{ $category->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $category->description ?? 'Aucune description' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $category->articles_count ?? 0 }} articles</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary edit-category" data-id="{{ $category->id }}" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger delete-category" data-id="{{ $category->id }}" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-tags fa-3x mb-3 d-block text-muted opacity-50"></i>
                                        Aucune catégorie trouvée
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour articles -->
<div class="modal fade" id="article-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="article-modal-title">Créer un Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="article-form" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" id="article-id">

                    <div class="mb-3">
                        <label for="article-title" class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="article-title" required>
                        <div class="invalid-feedback">Veuillez saisir un titre.</div>
                    </div>

                    <div class="mb-3">
                        <label for="article-excerpt" class="form-label fw-semibold">Extrait</label>
                        <textarea class="form-control" id="article-excerpt" rows="3" placeholder="Bref résumé de l'article..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="article-category" class="form-label fw-semibold">Catégorie</label>
                            <select class="form-select" id="article-category">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="article-author" class="form-label fw-semibold">Auteur</label>
                            <select class="form-select" id="article-author">
                                <option value="">Sélectionner un auteur</option>
                                @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="article-featured-image" class="form-label fw-semibold">Image mise en avant</label>
                        <input type="file" class="form-control" id="article-featured-image">
                    </div>

                    <div class="mb-3">
                        <label for="article-meta-title" class="form-label fw-semibold">Meta Titre</label>
                        <input type="text" class="form-control" id="article-meta-title">
                    </div>

                    <div class="mb-3">
                        <label for="article-meta-description" class="form-label fw-semibold">Meta Description</label>
                        <textarea class="form-control" id="article-meta-description" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="article-meta-keywords" class="form-label fw-semibold">Meta Mots-clés</label>
                        <input type="text" class="form-control" id="article-meta-keywords">
                    </div>

                    <div class="mb-3">
                        <label for="article-slug" class="form-label fw-semibold">Slug</label>
                        <input type="text" class="form-control" id="article-slug">
                    </div>

                    <div class="mb-3">
                        <label for="article-content" class="form-label fw-semibold">Contenu</label>
                        <textarea class="form-control" id="article-content" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="article-gallery" class="form-label fw-semibold">Galerie</label>
                        <input type="file" class="form-control" id="article-gallery" multiple>
                    </div>

                    <div class="mb-3">
                        <label for="article-status" class="form-label fw-semibold">Statut</label>
                        <select class="form-select" id="article-status">
                            <option value="draft">Brouillon</option>
                            <option value="published">Publié</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="article-is-featured">
                            <label class="form-check-label fw-semibold" for="article-is-featured">Article en vedette</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="article-is-breaking">
                            <label class="form-check-label fw-semibold" for="article-is-breaking">Article de dernière minute</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="article-published-at" class="form-label fw-semibold">Date de publication</label>
                        <input type="datetime-local" class="form-control" id="article-published-at">
                    </div>

                    <div class="mb-3">
                        <label for="article-scheduled-at" class="form-label fw-semibold">Date de planification</label>
                        <input type="datetime-local" class="form-control" id="article-scheduled-at">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="article-published">
                            <label class="form-check-label fw-semibold" for="article-published">Publier immédiatement</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="article-form" class="btn btn-primary" id="save-article-btn">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour catégories -->
<div class="modal fade" id="category-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="category-modal-title">Créer une Catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="category-form" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" id="category-id">

                    <div class="mb-3">
                        <label for="category-name" class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category-name" required>
                        <div class="invalid-feedback">Veuillez saisir un nom.</div>
                    </div>

                    <div class="mb-3">
                        <label for="category-description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="category-description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category-color" class="form-label fw-semibold">Couleur</label>
                        <input type="color" class="form-control" id="category-color">
                    </div>

                    <div class="mb-3">
                        <label for="category-icon" class="form-label fw-semibold">Icône</label>
                        <input type="text" class="form-control" id="category-icon">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="category-is-active">
                            <label class="form-check-label fw-semibold" for="category-is-active">Activer la catégorie</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="category-form" class="btn btn-primary" id="save-category-btn">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast de notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="notification-toast" class="toast" role="alert">
        <div class="toast-header">
            <i class="fas fa-info-circle text-primary me-2"></i>
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toast-message"></div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .offcanvas-lg {
        --bs-offcanvas-width: 500px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configuration CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    // Éléments du DOM
    const articleForm = document.getElementById('article-form');
    const categoryForm = document.getElementById('category-form');
    const articleModal = document.getElementById('article-modal');
    const categoryModal = document.getElementById('category-modal');
    const searchInput = document.getElementById('search-articles');

    // Initialisation
    initializeEventListeners();
    initializeSearch();

    function initializeEventListeners() {
        // Boutons de création
        document.getElementById('create-article')?.addEventListener('click', () => openArticleForm());
        document.getElementById('create-category')?.addEventListener('click', () => openCategoryForm());

        // Formulaires
        articleForm?.addEventListener('submit', handleArticleSubmit);
        categoryForm?.addEventListener('submit', handleCategorySubmit);

        // Boutons d'action dans les tableaux
        document.addEventListener('click', handleTableActions);
    }

    function initializeSearch() {
        searchInput?.addEventListener('input', debounce(filterArticles, 300));
    }

    function openArticleForm(articleData = null) {
        const title = document.getElementById('article-modal-title');
        const form = document.getElementById('article-form');

        form.reset();
        form.classList.remove('was-validated');

        if (articleData) {
            title.textContent = 'Modifier l\'Article';
            populateArticleForm(articleData);
        } else {
            title.textContent = 'Créer un Article';
            document.getElementById('article-id').value = '';
        }
    }

    function openCategoryForm(categoryData = null) {
        const title = document.getElementById('category-modal-title');
        const form = document.getElementById('category-form');

        form.reset();
        form.classList.remove('was-validated');

        if (categoryData) {
            title.textContent = 'Modifier la Catégorie';
            populateCategoryForm(categoryData);
        } else {
            title.textContent = 'Créer une Catégorie';
            document.getElementById('category-id').value = '';
        }
    }

    function populateArticleForm(data) {
        document.getElementById('article-id').value = data.id || '';
        document.getElementById('article-title').value = data.title || '';
        document.getElementById('article-excerpt').value = data.excerpt || '';
        document.getElementById('article-category').value = data.category_id || '';
        document.getElementById('article-author').value = data.author_id || '';
        document.getElementById('article-published').checked = data.published || false;
        document.getElementById('article-meta-title').value = data.meta_title || '';
        document.getElementById('article-meta-description').value = data.meta_description || '';
        document.getElementById('article-meta-keywords').value = data.meta_keywords || '';
        document.getElementById('article-slug').value = data.slug || '';
        document.getElementById('article-content').value = data.content || '';
        document.getElementById('article-status').value = data.status || 'draft';
        document.getElementById('article-is-featured').checked = data.is_featured || false;
        document.getElementById('article-is-breaking').checked = data.is_breaking || false;
        if (data.published_at) {
            document.getElementById('article-published-at').value = new Date(data.published_at).toISOString().slice(0, 16);
        } else {
            document.getElementById('article-published-at').value = '';
        }
        if (data.scheduled_at) {
            document.getElementById('article-scheduled-at').value = new Date(data.scheduled_at).toISOString().slice(0, 16);
        } else {
            document.getElementById('article-scheduled-at').value = '';
        }
    }

    function populateCategoryForm(data) {
        document.getElementById('category-id').value = data.id || '';
        document.getElementById('category-name').value = data.name || '';
        document.getElementById('category-description').value = data.description || '';
        document.getElementById('category-color').value = data.color || '#000000';
        document.getElementById('category-icon').value = data.icon || '';
        document.getElementById('category-is-active').checked = data.is_active || false;
    }

    async function handleArticleSubmit(e) {
        e.preventDefault();

        if (!articleForm.checkValidity()) {
            articleForm.classList.add('was-validated');
            return;
        }

        const id = document.getElementById('article-id').value;
        const url = id ? `/articles/${id}` : '/articles';
        const method = id ? 'PUT' : 'POST';

        const formData = {
            title: document.getElementById('article-title').value,
            excerpt: document.getElementById('article-excerpt').value,
            category_id: document.getElementById('article-category').value || null,
            author_id: document.getElementById('article-author').value || null,
            published: document.getElementById('article-published').checked,
            meta_title: document.getElementById('article-meta-title').value,
            meta_description: document.getElementById('article-meta-description').value,
            meta_keywords: document.getElementById('article-meta-keywords').value,
            slug: document.getElementById('article-slug').value,
            content: document.getElementById('article-content').value,
            status: document.getElementById('article-status').value,
            is_featured: document.getElementById('article-is-featured').checked,
            is_breaking: document.getElementById('article-is-breaking').checked,
            published_at: document.getElementById('article-published-at').value ? new Date(document.getElementById('article-published-at').value).toISOString() : null,
            scheduled_at: document.getElementById('article-scheduled-at').value ? new Date(document.getElementById('article-scheduled-at').value).toISOString() : null
        };

        // Gestion de l'image mise en avant
        const featuredImageInput = document.getElementById('article-featured-image');
        if (featuredImageInput.files.length > 0) {
            const formDataWithFile = new FormData();
            Object.keys(formData).forEach(key => formDataWithFile.append(key, formData[key]));
            formDataWithFile.append('featured_image', featuredImageInput.files[0]);

            try {
                showLoading('save-article-btn', true);
                const response = await makeRequest(url, method, formDataWithFile, true);

                if (response.success) {
                    showNotification('Article enregistré avec succès!', 'success');
                    bootstrap.Modal.getInstance(articleModal).hide();
                    refreshArticlesList();
                } else {
                    throw new Error(response.message || 'Erreur lors de l\'enregistrement');
                }
            } catch (error) {
                showNotification('Erreur: ' + error.message, 'error');
            } finally {
                showLoading('save-article-btn', false);
            }
        } else {
            try {
                showLoading('save-article-btn', true);
                const response = await makeRequest(url, method, formData);

                if (response.success) {
                    showNotification('Article enregistré avec succès!', 'success');
                    bootstrap.Modal.getInstance(articleModal).hide();
                    refreshArticlesList();
                } else {
                    throw new Error(response.message || 'Erreur lors de l\'enregistrement');
                }
            } catch (error) {
                showNotification('Erreur: ' + error.message, 'error');
            } finally {
                showLoading('save-article-btn', false);
            }
        }
    }

    async function handleCategorySubmit(e) {
        e.preventDefault();

        if (!categoryForm.checkValidity()) {
            categoryForm.classList.add('was-validated');
            return;
        }

        const id = document.getElementById('category-id').value;
        const url = id ? `/categories/${id}` : '/categories';
        const method = id ? 'PUT' : 'POST';

        const formData = {
            name: document.getElementById('category-name').value,
            description: document.getElementById('category-description').value,
            color: document.getElementById('category-color').value,
            icon: document.getElementById('category-icon').value,
            is_active: document.getElementById('category-is-active').checked
        };

        try {
            showLoading('save-category-btn', true);
            const response = await makeRequest(url, method, formData);

            if (response.success) {
                showNotification('Catégorie enregistrée avec succès!', 'success');
                bootstrap.Modal.getInstance(categoryModal).hide();
                refreshCategoriesList();
                refreshCategorySelect();
            } else {
                throw new Error(response.message || 'Erreur lors de l\'enregistrement');
            }
        } catch (error) {
            showNotification('Erreur: ' + error.message, 'error');
        } finally {
            showLoading('save-category-btn', false);
        }
    }

    function handleTableActions(e) {
        const button = e.target.closest('button');
        if (!button) return;

        const id = button.dataset.id || button.closest('tr')?.dataset.id;

        if (button.classList.contains('edit-article')) {
            editArticle(id);
        } else if (button.classList.contains('delete-article')) {
            deleteArticle(id);
        } else if (button.classList.contains('view-article')) {
            viewArticle(id);
        } else if (button.classList.contains('edit-category')) {
            editCategory(id);
        } else if (button.classList.contains('delete-category')) {
            deleteCategory(id);
        }
    }

    async function editArticle(id) {
        try {
            const response = await makeRequest(`/articles/${id}`, 'GET');
            if (response.success) {
                openArticleForm(response.data);
                new bootstrap.Modal(articleModal).show();
            }
        } catch (error) {
            showNotification('Erreur lors du chargement de l\'article', 'error');
        }
    }

    async function editCategory(id) {
        try {
            const response = await makeRequest(`/categories/${id}`, 'GET');
            if (response.success) {
                openCategoryForm(response.data);
                new bootstrap.Modal(categoryModal).show();
            }
        } catch (error) {
            showNotification('Erreur lors du chargement de la catégorie', 'error');
        }
    }

    async function deleteArticle(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) return;

        try {
            const response = await makeRequest(`/articles/${id}`, 'DELETE');
            if (response.success) {
                showNotification('Article supprimé avec succès!', 'success');
                refreshArticlesList();
            }
        } catch (error) {
            showNotification('Erreur lors de la suppression', 'error');
        }
    }

    async function deleteCategory(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) return;

        try {
            const response = await makeRequest(`/categories/${id}`, 'DELETE');
            if (response.success) {
                showNotification('Catégorie supprimée avec succès!', 'success');
                refreshCategoriesList();
                refreshCategorySelect();
            }
        } catch (error) {
            showNotification('Erreur lors de la suppression', 'error');
        }
    }

    function viewArticle(id) {
        window.open(`/articles/${id}`, '_blank');
    }

    function filterArticles() {
        const query = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.article-row');

        rows.forEach(row => {
            const title = row.querySelector('h6')?.textContent.toLowerCase() || '';
            const category = row.querySelector('.badge')?.textContent.toLowerCase() || '';
            const author = row.cells[2]?.textContent.toLowerCase() || '';

            const matches = title.includes(query) || category.includes(query) || author.includes(query);
            row.style.display = matches ? '' : 'none';
        });
    }

    async function makeRequest(url, method, data = null, isFormData = false) {
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        };

        if (data) {
            if (isFormData) {
                options.body = data;
            } else {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(data);
            }
        }

        const response = await fetch(url, options);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    function showNotification(message, type = 'info') {
        const toast = document.getElementById('notification-toast');
        const toastMessage = document.getElementById('toast-message');
        const toastHeader = toast.querySelector('.toast-header i');

        toastMessage.textContent = message;

        // Changement d'icône selon le type
        toastHeader.className = `fas me-2 ${type === 'success' ? 'fa-check-circle text-success' :
                                          type === 'error' ? 'fa-exclamation-circle text-danger' :
                                          'fa-info-circle text-primary'}`;

        new bootstrap.Toast(toast).show();
    }

    function showLoading(buttonId, loading) {
        const button = document.getElementById(buttonId);
        if (!button) return;

        if (loading) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Enregistrement...';
        } else {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-save me-1"></i> Enregistrer';
        }
    }

    function refreshArticlesList() {
        // Recharger uniquement la liste des articles
        location.reload(); // Vous pouvez implémenter un rechargement AJAX ici
    }

    function refreshCategoriesList() {
        // Recharger uniquement la liste des catégories
        location.reload(); // Vous pouvez implémenter un rechargement AJAX ici
    }

    function refreshCategorySelect() {
        // Recharger les options du select des catégories
        // Implementation AJAX recommandée
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});
</script>
@endsection
