<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TeamRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'homepage'])->name('homepage');

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('articles', ArticleController::class)
    ->middlewareFor(['create', 'store', 'edit', 'update', 'destroy'], 'auth');

Route::resource('categories', CategoryController::class)->except('show')->middleware(['auth', 'role:Admin']);
Route::resource('tags', TagController::class)->except('show')->middleware(['auth', 'role:Admin']);

Route::middleware('auth')->group(function () {
    Route::get('/team/join', [TeamRequestController::class, 'create'])->name('team.create');
    Route::post('/team/join', [TeamRequestController::class, 'store'])->name('team.store');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/team/requests', [TeamRequestController::class, 'index'])->name('team.index');
    Route::patch('/team/requests/{teamRequest}/{decision}', [TeamRequestController::class, 'resolve'])
        ->whereIn('decision', ['approve', 'reject'])
        ->name('team.resolve');
});

Route::middleware(['auth', 'role:Admin,Revisor'])->group(function () {
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::patch('/review/{article}/{decision}', [ReviewController::class, 'resolve'])
        ->whereIn('decision', ['approve', 'reject'])
        ->name('review.resolve');
});