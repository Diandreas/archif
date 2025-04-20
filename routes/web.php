<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\TutorielsController;
use App\Http\Controllers\DeveloppementController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\DemoRequestController;
use App\Http\Controllers\DemoAdminController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Définition des routes pour l'application ARCHIF
|
*/

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
Route::prefix('admin')->group(function () {
    Route::get('/demo-requests', [DemoAdminController::class, 'index'])->name('demo-admin.index');
    Route::get('/demo-requests/export', [DemoAdminController::class, 'export'])->name('demo-admin.export');
    Route::post('/demo-requests/{id}/mark-sent', [DemoAdminController::class, 'markAsSent'])->name('demo-admin.mark-sent');
    Route::delete('/demo-requests/{id}', [DemoAdminController::class, 'destroy'])->name('demo-admin.destroy');
});

Route::get('/welcome', function () {
    return view('welcome');
});