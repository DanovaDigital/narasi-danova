<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$adminHost = config('app.admin_host');
$isLocal = app()->environment(['local', 'testing']);

$registerAdminRoutes = static function (): void {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.post');

        Route::get('/pin', [AdminAuthController::class, 'showPin'])->name('pin');
        Route::post('/pin', [AdminAuthController::class, 'verifyPin'])->middleware('throttle:10,1')->name('pin.post');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('articles', AdminArticleController::class);

        Route::resource('authors', AdminAuthorController::class)->except(['show']);

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('tags', AdminTagController::class)->except(['show']);

        Route::get('subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
        Route::resource('subscribers', AdminSubscriberController::class)->only(['index', 'destroy']);

        Route::resource('submissions', AdminSubmissionController::class)->only(['index', 'show', 'update']);

        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        Route::resource('newsletters', AdminNewsletterController::class)->only(['index', 'create', 'store', 'show']);
    });
};

if (!$isLocal) {
    $adminDomain = !empty($adminHost) ? $adminHost : 'admin.{domain}';

    Route::domain($adminDomain)->name('admin.')->group(function () use ($registerAdminRoutes) {
        Route::get('/', function () {
            if (auth('admin')->check()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('admin.login');
        })->name('root');

        // Backward-compat: old URLs on admin subdomain used to be /admin/*.
        Route::prefix('admin')->get('{any?}', function (Request $request) {
            $uri = $request->getRequestUri();
            $uri = preg_replace('#^/admin#', '', $uri, 1);
            if ($uri === '') {
                $uri = '/';
            }

            return redirect()->to($uri);
        })->where('any', '.*');

        $registerAdminRoutes();
    });
}

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('cache.headers:300');
Route::get('/robots.txt', function () {
    $sitemapUrl = (string) route('sitemap');
    $sitemapUrl = (string) preg_replace('#^http://#i', 'https://', $sitemapUrl);

    $content = "User-agent: *\n" .
        "Allow: /\n\n" .
        "# Disallow admin/login pages\n" .
        "Disallow: /admin/\n" .
        "Disallow: /login/\n" .
        "Disallow: /dashboard/\n\n" .
        "# Sitemap\n" .
        "Sitemap: {$sitemapUrl}\n";

    return response($content, 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots')->middleware('cache.headers:3600');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap')->middleware('cache.headers:3600');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index')->middleware('cache.headers:300');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show')->middleware('cache.headers:600');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show')->middleware('cache.headers:300');
Route::get('/author/{slug}', [AuthorController::class, 'show'])->name('author.show')->middleware('cache.headers:300');
Route::get('/search', SearchController::class)->name('search');

Route::post('/subscribe', [SubscriberController::class, 'store'])->middleware('throttle:5,1')->name('subscribe');
Route::get('/subscribe/verify/{token}', [SubscriberController::class, 'verify'])->name('subscribe.verify');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');

// Local/testing: admin panel accessible under /admin/* regardless of ADMIN_HOST.
if ($isLocal) {
    Route::prefix('admin')->name('admin.')->middleware('admin.host')->group($registerAdminRoutes);
} else {
    // Non-local: admin is served on the admin subdomain; keep /admin/* on main domain blocked/redirected.
    Route::prefix('admin')->middleware('admin.host')->group(function () {
        Route::any('{any?}', function () {
            abort(404);
        })->where('any', '.*');
    });
}
