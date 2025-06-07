<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\TutorielsController;
use App\Http\Controllers\DeveloppementController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\DemoRequestController;
use App\Http\Controllers\DemoAdminController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\UserDataAdminController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Définition des routes pour l'application ARCHIF
|
*/
Route::get('/dashboard', [UserDataAdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/demo-requests', [DemoAdminController::class, 'index'])->name('demo-admin.index');
        Route::get('/demo-requests/export', [DemoAdminController::class, 'export'])->name('demo-admin.export');
        Route::post('/demo-requests/{id}/mark-sent', [DemoAdminController::class, 'markAsSent'])->name('demo-admin.mark-sent');
        Route::delete('/demo-requests/{id}', [DemoAdminController::class, 'destroy'])->name('demo-admin.destroy');

        // Gestion des données utilisateur collectées
        Route::get('/user-data', [UserDataAdminController::class, 'index'])->name('user-data-admin.index');
        Route::get('/user-data/export', [UserDataAdminController::class, 'export'])->name('user-data-admin.export');
        Route::get('/user-data/{id}', [UserDataAdminController::class, 'show'])->name('user-data-admin.show');
        Route::delete('/user-data/{id}', [UserDataAdminController::class, 'destroy'])->name('user-data-admin.destroy');
        Route::delete('/user-data', [UserDataAdminController::class, 'destroyAll'])->name('user-data-admin.destroy-all');

        // Route pour la gestion du blog
        Route::get('/blog', [BlogController::class, 'adminIndex'])->name('admin.blog.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Documentation
Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');

// Tutoriels
Route::get('/tutoriels', [TutorielsController::class, 'index'])->name('tutoriels');

// Développement
Route::get('/developpement', [DeveloppementController::class, 'index'])->name('developpement');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Demande de démo
Route::post('/demo-request', [DemoRequestController::class, 'store']);

// Administration des demandes de démo

// Route pour la collecte de données utilisateur
Route::post('/collect-user-data', [UserDataController::class, 'collectUserData']);
Route::get('/api/test-collect', function() {
    return response()->json(['success' => true, 'message' => 'Endpoint de test fonctionne correctement']);
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Routes pour le blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

require __DIR__.'/auth.php';
