<?php

use App\Http\Controllers\ObjetController;
use App\Http\Controllers\TrocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [AnnonceController::class, 'index'])->name('home');

Route::get('/objets', [ObjetController::class, 'index']);
Route::get('/objets/{objet}', [ObjetController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');
    Route::get('/annonces/{annonce}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/trocs', [TrocController::class, 'store']);
    Route::post('/trocs/{troc}/accepter', [TrocController::class, 'accepter']);

    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    // Routes pour les messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/contact/{annonce}', [MessageController::class, 'contactFromAnnonce'])->name('messages.contact');
    Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount'])->name('messages.unread.count');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
