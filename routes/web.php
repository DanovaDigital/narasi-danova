<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('cache.headers:300');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index')->middleware('cache.headers:300');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show')->middleware('cache.headers:600');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show')->middleware('cache.headers:300');
Route::get('/author/{slug}', [AuthorController::class, 'show'])->name('author.show')->middleware('cache.headers:300');
Route::get('/search', SearchController::class)->name('search');

Route::post('/subscribe', [SubscriberController::class, 'store'])->middleware('throttle:5,1')->name('subscribe');
Route::get('/subscribe/verify/{token}', [SubscriberController::class, 'verify'])->name('subscribe.verify');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('articles', AdminArticleController::class);

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('tags', AdminTagController::class)->except(['show']);

        Route::get('subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
        Route::resource('subscribers', AdminSubscriberController::class)->only(['index', 'destroy']);

        Route::resource('submissions', AdminSubmissionController::class)->only(['index', 'show', 'update']);

        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        Route::resource('newsletters', AdminNewsletterController::class)->only(['index', 'create', 'store', 'show']);
    });
});
