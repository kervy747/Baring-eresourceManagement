<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

// book tab
Route::get('/books', [BookController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/books/create', [BookController::class, 'create']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book}/review', [BookController::class, 'review']);
    Route::get('/books/pending', [BookController::class, 'pending']);
    Route::patch('/books/{book}/approve', [BookController::class, 'approve']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::get('/books/{book}/edit', [BookController::class, 'edit']);
    Route::patch('/books/{book}', [BookController::class, 'update']);
    Route::get('/books/{book}/download', [BookController::class, 'download']);
    Route::get('/books/{book}/payment', [PaymentController::class, 'show']);
    Route::post('/books/{book}/payment', [PaymentController::class, 'process']);
});


// user tab
Route::resource('/users', UserController::class)->middleware('auth');

// category tab
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth')->group(function () {
  Route::get('/categories/create', [CategoryController::class, 'create']);
  Route::post('/categories', [CategoryController::class, 'store']);
  Route::get('categories/{category}/edit', [CategoryController::class, 'edit']);
  Route::post('/categories/{category}', [CategoryController::class, 'update']);
  Route::get('/categories/pending', [CategoryController::class, 'pending']);
});

// activity tab
Route::get('/activity', [ActivityLogController::class, 'index']);
Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');
Route::get('/activity/export-pdf', [ActivityLogController::class, 'exportPdf'])->name('activity.exportPdf');
 

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::get('/profile/requests', [ProfileController::class, 'requests']);
});

// reg
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

// log
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

