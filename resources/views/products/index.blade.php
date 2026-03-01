@extends('layouts.public')

@section('title', 'Nos Produits - LEBOSS TECH MARKET')
@section('description', 'Découvrez tous nos produits électroniques : smartphones, ordinateurs, accessoires et plus encore. Filtrez par catégorie et prix.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Enhanced -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm bg-white px-4 py-2 rounded-lg shadow-sm">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="fas fa-home mr-1"></i>Accueil</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium">Produits</li>
            </ol>
        </nav>

        <!-- Page Header Enhanced -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Nos Produits</h1>
                    <p class="text-xl text-gray-600">Découvrez notre large gamme d'appareils électroniques de qualité</p>
                    <div class="mt-4 flex items-center space-x-6 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-box mr-2 text-blue-500"></i>
                            {{ $products->total() }} produits disponibles
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-tags mr-2 text-green-500"></i>
                            {{ $categories->count() }} catégories
                        </span>
                    </div>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="flex items-center space-x-3">
                        <!-- Quick Actions -->
                        <button onclick="toggleCompareMode()" id="compareToggle" class="hidden lg:flex items-center px-4 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 transition-colors">
                            <i class="fas fa-balance-scale mr-2"></i>
                            <span>Comparer</span>
                            <span id="compareCount" class="ml-2 bg-orange-500 text-white rounded-full px-2 py-0.5 text-xs hidden">0</span>
                        </button>
                        <button onclick="toggleFavoritesMode()" class="hidden lg:flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                            <i class="fas fa-heart mr-2"></i>
                            Favoris
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Enhanced Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8 lg:mb-0 sticky top-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="fas fa-filter mr-2 text-orange-500"></i>
                            Filtres
                        </h3>
                        <button onclick="clearAllFilters()" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                            Tout effacer
                        </button>
                    </div>
                    
                    <form method="GET" action="{{ route('products.index') }}" id="filtersForm" class="space-y-6">
                        <!-- Advanced Search -->
                        <div class="space-y-3">
                            <label for="search" class="block text-sm font-semibold text-gray-700">🔍 Recherche avancée</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                       placeholder="Rechercher un produit..." 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <div class="absolute left-3 top-3.5">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Categories with Icons -->
                        @if($categories->count() > 0)
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">📱 Catégories</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" name="category" value="" id="cat_all" 
                                           {{ !request('category') ? 'checked' : '' }}
                                           class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <label for="cat_all" class="ml-2 text-sm text-gray-700 cursor-pointer">
                                        Toutes les catégories
                                    </label>
                                </div>
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->slug }}" id="cat_{{ $category->id }}"
                                               {{ request('category') === $category->slug ? 'checked' : '' }}
                                               class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                        <label for="cat_{{ $category->id }}" class="ml-2 text-sm text-gray-700 cursor-pointer flex-1">
                                            {{ $category->name }}
                                        </label>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                            {{ $category->products_count ?? 0 }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Enhanced Price Range -->
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">💰 Fourchette de prix</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="relative">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                           placeholder="Min" 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                                    <div class="absolute left-2 top-2.5 text-xs text-gray-400">FCFA</div>
                                </div>
                                <div class="relative">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                           placeholder="Max" 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                                    <div class="absolute left-2 top-2.5 text-xs text-gray-400">FCFA</div>
                                </div>
                            </div>
                            <!-- Quick Price Buttons -->
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="setPrice(0, 50000)" class="text-xs bg-gray-100 hover:bg-orange-100 text-gray-700 px-2 py-1 rounded">
                                    < 50k
                                </button>
                                <button type="button" onclick="setPrice(50000, 100000)" class="text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 px-2 py-1 rounded">
                                    50k-100k
                                </button>
                                <button type="button" onclick="setPrice(100000, 500000)" class="text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 px-2 py-1 rounded">
                                    100k-500k
                                </button>
                                <button type="button" onclick="setPrice(500000, null)" class="text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 px-2 py-1 rounded">
                                    > 500k
                                </button>
                            </div>
                        </div>

                        <!-- Stock & Features Filters -->
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">📦 Disponibilité</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} 
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="ml-2 text-sm text-gray-700">En stock uniquement</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} 
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Produits vedettes</span>
                                </label>
                            </div>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex space-x-2 pt-4 border-t">
                            <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Filtrer
                            </button>
                            <button type="button" onclick="clearAllFilters()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-4 rounded-lg font-medium transition-colors">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Products Grid -->
            <div class="lg:col-span-3">
                <!-- Toolbar -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <!-- Results Info -->
                        <div class="flex items-center space-x-4">
                            <p class="text-gray-600 font-medium">
                                {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }}
                                @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'in_stock', 'featured']))
                                    <span class="text-orange-600 bg-orange-100 px-2 py-1 rounded text-sm ml-2">
                                        filtré{{ $products->total() > 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <!-- View & Sort Options -->
                        <div class="flex items-center space-x-4">
                            <!-- Sort -->
                            <div class="flex items-center space-x-2">
                                <label class="text-sm text-gray-600 font-medium">Trier par:</label>
                                <select name="sort" onchange="this.form.submit()" form="filtersForm"
                                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Plus récents</option>
                                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nom A-Z</option>
                                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Populaires</option>
                                </select>
                            </div>

                            <!-- View Toggle -->
                            <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                <button onclick="setView('grid')" id="gridViewBtn" 
                                        class="view-btn active p-2 rounded text-gray-600 hover:text-orange-600">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button onclick="setView('list')" id="listViewBtn" 
                                        class="view-btn p-2 rounded text-gray-600 hover:text-orange-600">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($products->count() > 0)
                    <!-- Products Container -->
                    <div id="productsContainer" class="grid-view">
                        @foreach($products as $product)
                            <div class="product-card bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100"
                                 data-product-id="{{ $product->id }}">
                                <div class="relative group">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        @if($product->getFirstMediaUrl('images'))
                                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                                            </div>
                                        @endif
                                    </a>
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col space-y-2">
                                        @if($product->stock <= 0)
                                            <span class="bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow">
                                                Rupture de stock
                                            </span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="bg-orange-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow">
                                                ⭐ Vedette
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="toggleFavorite({{ $product->id }})" 
                                                class="favorite-btn w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-white shadow-sm">
                                            <i class="fas fa-heart text-sm"></i>
                                        </button>
                                        <button onclick="toggleCompare({{ $product->id }})" 
                                                class="compare-btn w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:text-purple-500 hover:bg-white shadow-sm">
                                            <i class="fas fa-balance-scale text-sm"></i>
                                        </button>
                                        <button onclick="quickView({{ $product->id }})" 
                                                class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:text-blue-500 hover:bg-white shadow-sm">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="p-5">
                                    <div class="mb-2">
                                        <a href="{{ route('products.category', $product->category->slug) }}" 
                                           class="text-xs text-blue-600 hover:text-blue-800 font-semibold bg-blue-50 px-2 py-1 rounded">
                                            {{ $product->category->name }}
                                        </a>
                                    </div>
                                    
                                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 text-lg">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="hover:text-blue-600 transition-colors">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->short_description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-2xl font-bold text-blue-600">
                                            {{ number_format($product->price, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                                        </span>
                                        @if($product->stock > 0)
                                            <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded">
                                                <i class="fas fa-check-circle mr-1"></i>Stock: {{ $product->stock }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-2.5 rounded-lg transition-colors text-sm font-medium">
                                            Voir détails
                                        </a>
                                        <button onclick="quickOrder({{ $product->id }})" 
                                                class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2.5 rounded-lg transition-colors text-sm font-medium">
                                            <i class="fab fa-whatsapp mr-1"></i> Commander
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    <div class="mt-8 flex justify-center">
                        <div class="bg-white rounded-xl shadow-sm p-4">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <!-- Enhanced No Products State -->
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun produit trouvé</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Essayez de modifier vos critères de recherche ou parcourez toutes nos catégories.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('products.index') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                Voir tous les produits
                            </a>
                            <button onclick="clearAllFilters()" 
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                                Effacer les filtres
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-bold text-gray-900">Aperçu rapide</h3>
            <button onclick="closeQuickView()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="quickViewContent" class="p-6">
            <!-- Content loaded dynamically -->
        </div>
    </div>
</div>

<!-- Compare Sidebar -->
<div id="compareSidebar" class="fixed right-0 top-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 z-40">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Comparaison</h3>
            <button onclick="toggleCompareMode()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div id="compareList" class="p-6">
        <!-- Content will be populated by JavaScript -->
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products-enhanced.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/products-enhanced.js') }}"></script>
@endpush 