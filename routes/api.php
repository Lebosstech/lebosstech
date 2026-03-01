<?php

use App\Http\Controllers\Api\SearchApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes API de recherche
Route::prefix('search')->group(function () {
    Route::get('/', [SearchApiController::class, 'search'])->name('api.search');
    Route::get('/autocomplete', [SearchApiController::class, 'autocomplete'])->name('api.search.autocomplete');
    Route::get('/filters', [SearchApiController::class, 'getFilters'])->name('api.search.filters');
    Route::get('/popular', [SearchApiController::class, 'getPopularSearches'])->name('api.search.popular');
}); 