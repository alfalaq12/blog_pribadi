<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController;

// PUBLIC ROUTES (Tidak perlu login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
Route::get('/category/{category}', [PostController::class, 'category'])->name('category.show');
Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');

// AUTH ROUTES (Login/Register)
require __DIR__.'/auth.php';

// ADMIN ROUTES (Harus login sebagai admin)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class);
    Route::resource('categories', CategoryController::class);
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
});