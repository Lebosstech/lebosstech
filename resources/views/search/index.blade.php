@extends('layouts.public')

@section('title', 'Recherche Avancée - LEBOSS TECH MARKET')

@section('content')
<div class="search-page-modern">
    <!-- Hero Section Moderne -->
    <section class="hero-search bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white bg-opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-400 bg-opacity-10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 container mx-auto px-4 py-16">
            <div class="text-center mb-8">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 animate-fade-in-up">
                    Trouvez l'équipement <span class="text-yellow-400">parfait</span>
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto animate-fade-in-up-delay">
                    Recherchez parmi plus de <span class="font-bold text-yellow-400">{{ $products->total() }}</span> produits reconditionnés de qualité premium
                </p>
            </div>

            <!-- Barre de recherche avancée -->
            <div class="max-w-4xl mx-auto animate-fade-in-up-delay-2">
                <form method="GET" action="{{ route('search.index') }}" id="advancedSearchForm" class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-6">
                        <!-- Recherche principale -->
                        <div class="relative mb-4">
                            <input type="text" 
                                   name="q" 
                                   value="{{ $query }}" 
                                   placeholder="Rechercher un produit, une marque, un modèle..."
                                   class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all duration-300"
                                   id="mainSearchInput"
                                   autocomplete="off">
                            <button type="submit" class="absolute right-2 top-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-search mr-2"></i>Rechercher
                            </button>
                            
                            <!-- Dropdown autocomplétion -->
                            <div id="autocompleteResults" class="absolute top-full left-0 right-0 bg-white rounded-xl shadow-xl z-50 mt-2 hidden max-h-80 overflow-y-auto"></div>
                        </div>

                        <!-- Filtres rapides -->
                        <div class="flex flex-wrap gap-3 mb-4">
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium text-gray-700">Catégorie:</label>
                                <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Toutes</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium text-gray-700">Prix max:</label>
                                <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Prix max" 
                                       class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <button type="button" id="showAdvancedFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fas fa-sliders-h mr-2"></i>Filtres avancés
                            </button>
                        </div>

                        <!-- Filtres avancés (cachés par défaut) -->
                        <div id="advancedFilters" class="hidden border-t pt-4 mt-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Marque</label>
                                    <select name="brand" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Toutes les marques</option>
                                        @foreach($brands as $brandOption)
                                        <option value="{{ $brandOption }}" {{ $brand == $brandOption ? 'selected' : '' }}>
                                            {{ $brandOption }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">État</label>
                                    <select name="condition" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Tous les états</option>
                                        @foreach($conditions as $key => $label)
                                        <option value="{{ $key }}" {{ $condition == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix minimum</label>
                                    <input type="number" name="min_price" value="{{ $minPrice }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tags de recherches populaires -->
                @if(!empty($popularSearches))
                <div class="mt-6 text-center">
                    <p class="text-blue-100 mb-3">Recherches populaires :</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach(array_slice($popularSearches, 0, 8) as $popular)
                        <a href="{{ route('search.index', ['q' => $popular]) }}" 
                           class="px-4 py-2 bg-white bg-opacity-20 text-white rounded-full hover:bg-opacity-30 transition-all duration-300 transform hover:scale-105">
                            {{ $popular }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Section des résultats -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- En-tête des résultats avec statistiques -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            @if($query)
                                Résultats pour "<span class="text-blue-600">{{ $query }}</span>"
                            @else
                                Tous nos produits
                            @endif
                        </h2>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <span><i class="fas fa-box mr-1"></i>{{ $products->total() }} produits trouvés</span>
                            <span><i class="fas fa-clock mr-1"></i>Mis à jour il y a {{ now()->diffForHumans() }}</span>
                            @if($query)
                            <span><i class="fas fa-search mr-1"></i>Recherche en {{ number_format(microtime(true) - LARAVEL_START, 2) }}s</span>
                            @endif
                        </div>
                    </div>

                    <!-- Options d'affichage et tri -->
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Affichage:</span>
                            <button id="gridView" class="p-2 bg-blue-600 text-white rounded-lg">
                                <i class="fas fa-th"></i>
                            </button>
                            <button id="listView" class="p-2 bg-gray-200 text-gray-600 rounded-lg">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>

                        <select id="sortSelect" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="relevance" {{ $sortBy == 'relevance' ? 'selected' : '' }}>Plus pertinent</option>
                            <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Plus récents</option>
                        </select>
                    </div>
                </div>

                <!-- Filtres actifs -->
                @if($query || $categoryId || $brand || $condition || $minPrice || $maxPrice)
                <div class="mt-4 pt-4 border-t">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm text-gray-600 mr-2">Filtres actifs:</span>
                        @if($query)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm flex items-center">
                            Recherche: {{ $query }}
                            <a href="{{ route('search.index', array_filter(request()->except('q'))) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if($categoryId)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm flex items-center">
                            Catégorie: {{ $categories->find($categoryId)->name ?? 'Inconnue' }}
                            <a href="{{ route('search.index', array_filter(request()->except('category'))) }}" class="ml-2 text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if($brand)
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm flex items-center">
                            Marque: {{ $brand }}
                            <a href="{{ route('search.index', array_filter(request()->except('brand'))) }}" class="ml-2 text-purple-600 hover:text-purple-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        
                        <a href="{{ route('search.index') }}" class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm hover:bg-red-200 transition-colors">
                            <i class="fas fa-times mr-1"></i>Tout effacer
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Grille des produits -->
            <div id="productsContainer">
                @if($products->count() > 0)
                <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                    <div class="product-card-modern bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <!-- Image avec overlay -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->getFirstMediaUrl('products', 'main') ?: asset('images/no-image.jpg') }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy">
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if($product->is_featured)
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i>VEDETTE
                                </span>
                                @endif
                                @if($product->condition)
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $conditions[$product->condition] ?? $product->condition }}
                                </span>
                                @endif
                            </div>

                            <!-- Actions rapides -->
                            <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button class="bg-white bg-opacity-90 p-2 rounded-full shadow-lg hover:bg-opacity-100 transition-all duration-300" 
                                        onclick="toggleWishlist({{ $product->id }})">
                                    <i class="fas fa-heart text-red-500"></i>
                                </button>
                                <button class="bg-white bg-opacity-90 p-2 rounded-full shadow-lg hover:bg-opacity-100 transition-all duration-300"
                                        onclick="quickView({{ $product->id }})">
                                    <i class="fas fa-eye text-blue-500"></i>
                                </button>
                            </div>

                            <!-- Overlay avec actions -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-end">
                                <div class="w-full p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    <div class="flex gap-2">
                                        <a href="{{ $product->whatsapp_url }}" 
                                           class="flex-1 bg-green-500 text-white text-center py-2 rounded-lg hover:bg-green-600 transition-colors"
                                           onclick="trackWhatsAppClick({{ $product->id }})">
                                            <i class="fab fa-whatsapp mr-1"></i>Commander
                                        </a>
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="flex-1 bg-blue-500 text-white text-center py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations produit -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                @if($product->brand)
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $product->brand }}</span>
                                @endif
                            </div>

                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->short_description }}</p>

                            <!-- Prix et stock -->
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">
                                        {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">Stock: {{ $product->stock }}</span>
                                    <div class="text-xs text-gray-400">{{ $product->category->name }}</div>
                                </div>
                            </div>

                            <!-- Rating et avis (simulé) -->
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400 mr-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-gray-500">({{ rand(5, 50) }} avis)</span>
                                </div>
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-shipping-fast mr-1"></i>Livraison rapide
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination moderne -->
                @if($products->hasPages())
                <div class="flex justify-center">
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
                @endif

                @else
                <!-- État vide avec suggestions -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="mb-6">
                            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun produit trouvé</h3>
                            <p class="text-gray-600">Nous n'avons trouvé aucun produit correspondant à vos critères.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-2">Suggestions :</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Vérifiez l'orthographe de votre recherche</li>
                                    <li>• Essayez des mots-clés plus généraux</li>
                                    <li>• Supprimez certains filtres</li>
                                </ul>
                            </div>

                            <div class="flex flex-wrap gap-2 justify-center">
                                @foreach(array_slice($popularSearches, 0, 5) as $popular)
                                <a href="{{ route('search.index', ['q' => $popular]) }}" 
                                   class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition-colors">
                                    {{ $popular }}
                                </a>
                                @endforeach
                            </div>

                            <a href="{{ route('search.index') }}" 
                               class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Voir tous les produits
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Section suggestions -->
            @if($suggestions->isNotEmpty())
            <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-heart text-red-500 mr-3"></i>
                    Vous pourriez aussi aimer
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($suggestions->take(4) as $suggestion)
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-lg transition-shadow duration-300">
                        <img src="{{ $suggestion->getFirstMediaUrl('products', 'thumb') ?: asset('images/no-image.jpg') }}" 
                             alt="{{ $suggestion->name }}" 
                             class="w-full h-32 object-cover rounded-lg mb-3">
                        
                        <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $suggestion->name }}</h4>
                        <p class="text-lg font-bold text-blue-600 mb-3">
                            {{ number_format($suggestion->price, 0, ',', ' ') }} FCFA
                        </p>
                        
                        <div class="flex gap-2">
                            <a href="{{ $suggestion->whatsapp_url }}" 
                               class="flex-1 bg-green-500 text-white text-center py-2 rounded text-sm hover:bg-green-600 transition-colors"
                               onclick="trackWhatsAppClick({{ $suggestion->id }})">
                                <i class="fab fa-whatsapp mr-1"></i>Commander
                            </a>
                            <a href="{{ route('products.show', $suggestion->slug) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded text-sm hover:bg-blue-600 transition-colors">
                                Voir
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
</div>

<!-- Modal de vue rapide -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold">Vue rapide</h3>
                <button onclick="closeQuickView()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="quickViewContent">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<style>
/* Animations personnalisées */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-fade-in-up-delay {
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

.animate-fade-in-up-delay-2 {
    animation: fadeInUp 0.6s ease-out 0.4s both;
}

/* Limitation de lignes */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Style pour l'autocomplétion */
.autocomplete-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
}

.autocomplete-item:hover {
    background-color: #f8f9fa;
}

.autocomplete-item:last-child {
    border-bottom: none;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-search {
        padding: 2rem 0;
    }
    
    .hero-search h1 {
        font-size: 2.5rem;
    }
    
    #productsGrid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

/* Mode liste */
.list-view .product-card-modern {
    display: flex;
    flex-direction: row;
    max-width: none;
}

.list-view .product-card-modern img {
    width: 200px;
    height: 150px;
    flex-shrink: 0;
}

.list-view .product-card-modern .p-4 {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Autocomplétion avancée
    const searchInput = document.getElementById('mainSearchInput');
    const autocompleteResults = document.getElementById('autocompleteResults');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            autocompleteResults.classList.add('hidden');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        autocompleteResults.innerHTML = data.map(item => 
                            `<div class="autocomplete-item" onclick="selectSuggestion('${item}')">${item}</div>`
                        ).join('');
                        autocompleteResults.classList.remove('hidden');
                    } else {
                        autocompleteResults.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Erreur autocomplétion:', error);
                    autocompleteResults.classList.add('hidden');
                });
        }, 300);
    });

    // Gestion des filtres avancés
    document.getElementById('showAdvancedFilters').addEventListener('click', function() {
        const advancedFilters = document.getElementById('advancedFilters');
        advancedFilters.classList.toggle('hidden');
        this.innerHTML = advancedFilters.classList.contains('hidden') 
            ? '<i class="fas fa-sliders-h mr-2"></i>Filtres avancés'
            : '<i class="fas fa-times mr-2"></i>Masquer filtres';
    });

    // Changement de vue (grille/liste)
    document.getElementById('listView').addEventListener('click', function() {
        document.getElementById('productsGrid').classList.add('list-view');
        this.classList.add('bg-blue-600', 'text-white');
        this.classList.remove('bg-gray-200', 'text-gray-600');
        document.getElementById('gridView').classList.add('bg-gray-200', 'text-gray-600');
        document.getElementById('gridView').classList.remove('bg-blue-600', 'text-white');
    });

    document.getElementById('gridView').addEventListener('click', function() {
        document.getElementById('productsGrid').classList.remove('list-view');
        this.classList.add('bg-blue-600', 'text-white');
        this.classList.remove('bg-gray-200', 'text-gray-600');
        document.getElementById('listView').classList.add('bg-gray-200', 'text-gray-600');
        document.getElementById('listView').classList.remove('bg-blue-600', 'text-white');
    });

    // Tri dynamique
    document.getElementById('sortSelect').addEventListener('change', function() {
        const params = new URLSearchParams(window.location.search);
        params.set('sort', this.value);
        window.location.href = `{{ route('search.index') }}?${params.toString()}`;
    });

    // Fermer autocomplétion en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
            autocompleteResults.classList.add('hidden');
        }
    });
});

// Fonctions globales
function selectSuggestion(suggestion) {
    document.getElementById('mainSearchInput').value = suggestion;
    document.getElementById('autocompleteResults').classList.add('hidden');
    document.getElementById('advancedSearchForm').submit();
}

function trackWhatsAppClick(productId) {
    fetch(`/whatsapp-click/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).catch(error => console.error('Erreur tracking WhatsApp:', error));
}

function toggleWishlist(productId) {
    // TODO: Implémenter la wishlist
    console.log('Toggle wishlist pour produit:', productId);
}

function quickView(productId) {
    // TODO: Implémenter la vue rapide
    document.getElementById('quickViewModal').classList.remove('hidden');
    document.getElementById('quickViewContent').innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl"></i><br>Chargement...</div>';
}

function closeQuickView() {
    document.getElementById('quickViewModal').classList.add('hidden');
}
</script>
@endsection 