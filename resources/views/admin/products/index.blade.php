@extends('layouts.admin')

@section('title', 'Gestion Produits - LEBOSS TECH ADMIN')

@push('styles')
<link href="{{ asset('css/product-index.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="products-container">
    <!-- En-tête moderne avec design premium -->
    <div class="page-header animate-fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="page-title flex items-center">
                    <i class="fas fa-cubes text-orange-500 mr-4"></i>
                    Gestion des Produits
                </h1>
                <p class="text-gray-600 text-lg font-medium">
                    Gérez votre catalogue LEBOSS TECH Market avec style et efficacité
                </p>
                <div class="flex items-center mt-3 text-sm text-gray-500 space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Dernière mise à jour : {{ now()->format('d/m/Y à H:i') }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-database mr-2"></i>
                        {{ $products->total() ?? 0 }} produits au total
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Toggle de vue -->
                <div class="view-toggle">
                    <button type="button" class="toggle-btn active" id="gridViewBtn">
                        <i class="fas fa-th-large mr-2"></i>
                        Grille
                    </button>
                    <button type="button" class="toggle-btn" id="listViewBtn">
                        <i class="fas fa-list mr-2"></i>
                        Liste
                    </button>
                </div>
                
                <!-- Bouton nouveau produit -->
                <a href="{{ route('admin.products.create') }}" 
                   class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 flex items-center transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    <span class="text-lg">Nouveau Produit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques KPI modernisées -->
    <div class="stats-grid animate-fade-in-up" style="animation-delay: 0.1s;">
        <!-- Total Produits -->
        <div class="stat-card blue">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Total Produits</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-sm text-blue-600 mt-1 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +{{ $stats['new_this_month'] ?? 0 }} ce mois
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-cubes text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Produits Actifs -->
        <div class="stat-card green">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Produits Actifs</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['active'] ?? 0 }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        {{ round((($stats['active'] ?? 0) / max($stats['total'] ?? 1, 1)) * 100, 1) }}% du catalogue
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-eye text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Stock Bas -->
        <div class="stat-card yellow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Stock Bas</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['low_stock'] ?? 0 }}</p>
                    <p class="text-sm text-yellow-600 mt-1">
                        Nécessite réapprovisionnement
                    </p>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-yellow-600 animate-pulse"></i>
                </div>
            </div>
        </div>

        <!-- Produits en Vedette -->
        <div class="stat-card orange">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">En Vedette</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['featured'] ?? 0 }}</p>
                    <p class="text-sm text-orange-600 mt-1">
                        Mis en avant sur le site
                    </p>
                </div>
                <div class="bg-orange-100 rounded-full p-4">
                    <i class="fas fa-star text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>

        <!-- Ruptures de Stock -->
        <div class="stat-card red">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Ruptures</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['out_of_stock'] ?? 0 }}</p>
                    <p class="text-sm text-red-600 mt-1">
                        Action requise immédiate
                    </p>
                </div>
                <div class="bg-red-100 rounded-full p-4">
                    <i class="fas fa-times-circle text-2xl text-red-600"></i>
                </div>
            </div>
        </div>

        <!-- Valeur Totale Stock -->
        <div class="stat-card purple">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Valeur Stock</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_value'] ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-sm text-purple-600 mt-1">FCFA</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <i class="fas fa-money-bill-wave text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de recherche et filtres avancés -->
    <div class="search-filter-bar animate-fade-in-up" style="animation-delay: 0.2s;">
        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
            <!-- Recherche principale -->
            <div class="search-input-group">
                <i class="search-icon fas fa-search"></i>
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Rechercher par nom, SKU, marque..." 
                       value="{{ request('search') }}"
                       id="searchInput">
            </div>

            <!-- Filtres avancés -->
            <div class="filter-section">
                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select name="category" class="filter-select" onchange="submitFilters()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="filter-select" onchange="submitFilters()">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>En vedette</option>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                    <select name="stock_status" class="filter-select" onchange="submitFilters()">
                        <option value="">Tous les stocks</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>En stock</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stock bas</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Rupture</option>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix</label>
                    <select name="price_range" class="filter-select" onchange="submitFilters()">
                        <option value="">Toutes les gammes</option>
                        <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>0 - 50 000 FCFA</option>
                        <option value="50000-200000" {{ request('price_range') == '50000-200000' ? 'selected' : '' }}>50 000 - 200 000 FCFA</option>
                        <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200 000 - 500 000 FCFA</option>
                        <option value="500000+" {{ request('price_range') == '500000+' ? 'selected' : '' }}>500 000+ FCFA</option>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tri</label>
                    <select name="sort" class="filter-select" onchange="submitFilters()">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom Z-A</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock croissant</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Plus récents</option>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Actions</label>
                    <div class="flex space-x-2">
                        <button type="button" onclick="clearFilters()" 
                                class="action-btn btn-secondary text-sm">
                            <i class="fas fa-eraser"></i>
                            Effacer
                        </button>
                        <button type="button" onclick="exportProducts()" 
                                class="action-btn btn-primary text-sm">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Vue en grille des produits -->
    <div id="gridView" class="products-grid animate-fade-in-up" style="animation-delay: 0.3s;">
        @forelse($products ?? [] as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <!-- Image et badges -->
                <div class="product-image-container">
                    @if($product->getFirstMediaUrl('images'))
                        <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                             alt="{{ $product->name }}" 
                             class="product-image"
                             loading="lazy">
                    @else
                        <div class="product-image flex items-center justify-center bg-gray-100">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Badges dynamiques -->
                    <div class="product-badges">
                        @if($product->is_featured)
                            <span class="badge badge-featured">
                                <i class="fas fa-star"></i>
                                Vedette
                            </span>
                        @endif
                        @if($product->created_at->diffInDays() < 7)
                            <span class="badge badge-new">
                                <i class="fas fa-sparkles"></i>
                                Nouveau
                            </span>
                        @endif
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <span class="badge badge-sale">
                                <i class="fas fa-percent"></i>
                                -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Informations produit -->
                <div class="product-info">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <span class="product-sku">SKU: {{ $product->sku }}</span>
                    
                    <div class="product-price">
                        {{ number_format($product->price, 0, ',', ' ') }} FCFA
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <span class="text-gray-400 line-through text-lg ml-2">
                                {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                            </span>
                        @endif
                    </div>

                    <div class="product-stats">
                        <div class="stock-indicator 
                            @if($product->stock > 10) stock-good
                            @elseif($product->stock > 0) stock-low
                            @else stock-out
                            @endif">
                            <i class="fas fa-circle text-xs"></i>
                            @if($product->stock > 10)
                                En stock ({{ $product->stock }})
                            @elseif($product->stock > 0)
                                Stock bas ({{ $product->stock }})
                            @else
                                Rupture
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if($product->is_active)
                                <span class="text-green-500 tooltip" data-tooltip="Produit visible">
                                    <i class="fas fa-eye"></i>
                                </span>
                            @else
                                <span class="text-red-500 tooltip" data-tooltip="Produit masqué">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="product-actions">
                        <a href="{{ route('admin.products.show', $product) }}" 
                           class="action-btn btn-primary">
                            <i class="fas fa-eye"></i>
                            Voir
                        </a>
                        <a href="{{ route('admin.products.edit-enhanced', $product) }}" 
                           class="action-btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-state-title">Aucun produit trouvé</h3>
                    <p class="empty-state-description">
                        Aucun produit ne correspond à vos critères de recherche.
                    </p>
                    <a href="{{ route('admin.products.create') }}" 
                       class="action-btn btn-primary inline-flex">
                        <i class="fas fa-plus mr-2"></i>
                        Créer le premier produit
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Vue en liste des produits -->
    <div id="listView" class="products-list hidden animate-fade-in-up" style="animation-delay: 0.3s;">
        <div class="list-header">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-table mr-3"></i>
                Liste détaillée des produits
                @if(isset($products) && $products->count() > 0)
                    <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                        {{ $products->count() }} sur {{ $products->total() }}
                    </span>
                @endif
            </h3>
        </div>

        <table class="products-table">
            <thead class="table-header">
                <tr>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products ?? [] as $product)
                    <tr class="table-row">
                        <td class="table-cell">
                            <div class="flex items-center">
                                <div class="h-16 w-16 flex-shrink-0 mr-4">
                                    @if($product->getFirstMediaUrl('images'))
                                        <img class="h-16 w-16 rounded-lg object-cover border border-gray-200" 
                                             src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                                             alt="{{ $product->name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center border border-gray-200">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    @if($product->brand)
                                        <div class="text-xs text-gray-400">{{ $product->brand }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $product->category->name ?? 'Non catégorisé' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ number_format($product->price, 0, ',', ' ') }} FCFA
                            </div>
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <div class="text-xs text-gray-500 line-through">
                                    {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                                </div>
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($product->stock > 10)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $product->stock }} en stock
                                </span>
                            @elseif($product->stock > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ $product->stock }} restants
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Rupture
                                </span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <div class="flex flex-col space-y-1">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-eye-slash mr-1"></i>
                                        Inactif
                                    </span>
                                @endif
                                
                                @if($product->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Vedette
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    Voir
                                </a>
                                <a href="{{ route('admin.products.edit-enhanced', $product) }}" 
                                   class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Modifier
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center">
                                        <i class="fas fa-trash mr-1"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="table-cell text-center py-12">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3 class="empty-state-title">Aucun produit trouvé</h3>
                                <p class="empty-state-description">
                                    Aucun produit ne correspond à vos critères de recherche.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination moderne -->
    @if(isset($products) && $products->hasPages())
        <div class="pagination-container">
            @if($products->onFirstPage())
                <span class="pagination-btn opacity-50 cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Précédent
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="pagination-btn">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Précédent
                </a>
            @endif

            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if($page == $products->currentPage())
                    <span class="pagination-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endforeach

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="pagination-btn">
                    Suivant
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="pagination-btn opacity-50 cursor-not-allowed">
                    Suivant
                    <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    @endif
</div>

<!-- Actions rapides flottantes -->
<div class="quick-actions">
    <button type="button" class="quick-action-btn btn-filter" onclick="toggleFilters()" title="Filtres avancés">
        <i class="fas fa-filter"></i>
    </button>
    <a href="{{ route('admin.products.create') }}" class="quick-action-btn btn-add" title="Nouveau produit">
        <i class="fas fa-plus"></i>
    </a>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle entre vue grille et vue liste
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');

    gridViewBtn?.addEventListener('click', function() {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        localStorage.setItem('productView', 'grid');
    });

    listViewBtn?.addEventListener('click', function() {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        localStorage.setItem('productView', 'list');
    });

    // Restaurer la vue préférée
    const savedView = localStorage.getItem('productView');
    if (savedView === 'list') {
        listViewBtn?.click();
    }

    // Recherche en temps réel
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
});

// Fonctions utilitaires
function submitFilters() {
    document.getElementById('filterForm').submit();
}

function clearFilters() {
    const form = document.getElementById('filterForm');
    form.querySelectorAll('input, select').forEach(input => {
        if (input.type === 'text' || input.type === 'search') {
            input.value = '';
        } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        }
    });
    form.submit();
}

function exportProducts() {
    // Ici on pourrait ajouter la logique d'export
    alert('Fonctionnalité d\'export en cours de développement');
}

function toggleFilters() {
    const filterBar = document.querySelector('.search-filter-bar');
    filterBar.classList.toggle('hidden');
}

// Animation au scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
        }
    });
});

document.querySelectorAll('.product-card').forEach(card => {
    observer.observe(card);
});
</script>
@endpush
@endsection 