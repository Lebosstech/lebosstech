<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{slug}', [ProductController::class, 'category'])->name('products.category');
Route::post('/whatsapp-click/{product}', [ProductController::class, 'whatsappClick'])->name('products.whatsapp-click');

// Nouvelles routes pour les fonctionnalités avancées
Route::get('/api/products/{product}/quick-view', [ProductController::class, 'quickView'])->name('products.quick-view');
Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/api/products/compare', [ProductController::class, 'compare'])->name('products.compare');
Route::get('/api/products/{product}/similar', [ProductController::class, 'similar'])->name('products.similar');
Route::get('/api/products/stats', [ProductController::class, 'stats'])->name('products.stats');


// Routes de recherche
Route::get('/recherche', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/a-propos', [AboutController::class, 'index'])->name('about.index');
Route::get('/conditions-vente', [TermsController::class, 'index'])->name('terms.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes d'administration
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Routes produits avec fonctionnalités avancées
        Route::resource('products', AdminProductController::class);
        Route::get('/products/{product}/edit-enhanced', [AdminProductController::class, 'editEnhanced'])->name('products.edit-enhanced');
        Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
        Route::post('/products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
        Route::delete('/products/{product}/images/{media}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
        Route::post('/products/{product}/reorder-images', [AdminProductController::class, 'reorderImages'])->name('products.reorder-images');
        
        Route::resource('categories', AdminCategoryController::class);
        
        // Routes sliders avec fonctionnalités avancées
        Route::resource('sliders', AdminSliderController::class);
        Route::patch('sliders/{slider}/toggle-status', [AdminSliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
        Route::get('sliders/{slider}/preview', [AdminSliderController::class, 'preview'])->name('sliders.preview');
        Route::patch('sliders/{slider}/update-order', [AdminSliderController::class, 'updateOrder'])->name('sliders.update-order');
        Route::post('sliders/reorder', [AdminSliderController::class, 'reorder'])->name('sliders.reorder');
        Route::post('sliders/bulk-action', [AdminSliderController::class, 'bulkAction'])->name('sliders.bulk-action');
        
        // Analytics avancés
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('dashboard');
            Route::get('/realtime', [AnalyticsController::class, 'realTime'])->name('realtime');
            Route::get('/chart-data', [AnalyticsController::class, 'chartData'])->name('chart-data');
            Route::get('/geographic', [AnalyticsController::class, 'geographic'])->name('geographic');
            Route::get('/devices', [AnalyticsController::class, 'devices'])->name('devices');
            Route::get('/seo', [AnalyticsController::class, 'seo'])->name('seo');
            Route::get('/export', [AnalyticsController::class, 'export'])->name('export');
            
            // Gestion des alertes
            Route::get('/alerts', [AnalyticsController::class, 'alerts'])->name('alerts');
            Route::post('/alerts', [AnalyticsController::class, 'createAlert'])->name('alerts.create');
            Route::post('/schedule-report', [AnalyticsController::class, 'scheduleReport'])->name('schedule-report');
        });
        
        // Analytics de recherche
        Route::prefix('search-analytics')->name('search-analytics.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'index'])->name('index');
            Route::get('/details', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'searchDetails'])->name('details');
            Route::get('/export', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'export'])->name('export');
            Route::get('/popular', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'popularSearches'])->name('popular');
            Route::delete('/popular/{popularSearch}', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'deletePopularSearch'])->name('popular.delete');
            Route::get('/api/stats', [App\Http\Controllers\Admin\SearchAnalyticsController::class, 'apiStats'])->name('api.stats');
        });
    });
});

require __DIR__.'/auth.php';
