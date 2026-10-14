<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TeamRequestController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'homepage'])->name('homepage');
Route::resource('articles', ArticleController::class)
    ->middlewareFor(['create', 'store', 'edit', 'update', 'destroy'], 'auth');

// Autenticazione
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->middleware('throttle:5,1');
    });
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// Utenti loggati
Route::middleware('auth')->group(function () {
    Route::get('/team/join', [TeamRequestController::class, 'create'])->name('team.create');
    Route::post('/team/join', [TeamRequestController::class, 'store'])->name('team.store');
    Route::get('/dashboard/writer', [ArticleController::class, 'mine'])
        ->middleware('role:Writer')->name('writer.dashboard');
});

// Revisor e Admin: revisione degli articoli
Route::middleware(['auth', 'role:Revisor,Admin'])->prefix('review')->name('review.')->group(function () {
    Route::get('/', [ReviewController::class, 'index'])->name('index');
    Route::patch('{article}/{decision}', [ReviewController::class, 'resolve'])
        ->whereIn('decision', ['approve', 'reject'])->name('resolve');
});

// Solo Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/feedback', [FeedbackController::class, 'index'])
        ->name('feedback.index');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'setRole'])->name('admin.users.role');
    Route::patch('/team/requests/{teamRequest}/{decision}', [TeamRequestController::class, 'resolve'])
        ->whereIn('decision', ['approve', 'reject'])->name('team.resolve');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('tags', TagController::class)->except('show');
});

Route::get('/feedback', [FeedbackController::class, 'create'])
    ->name('feedback.create');

Route::post('/feedback', [FeedbackController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('feedback.store');
