<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});

Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::post('articles', [ArticleController::class, 'store'])->name('articles.store')->middleware(['auth:sanctum', 'role:editor']);
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('article.update')->middleware(['auth:sanctum', 'role:editor']);
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.delete')->middleware(['auth:sanctum', 'role:editor']);

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

Route::post('multimedia', [MultimediaController::class, 'store'])->name('multimedia.store');

