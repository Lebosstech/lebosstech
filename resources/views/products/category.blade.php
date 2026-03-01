@extends('layouts.public')

@section('title', $category->name . ' - LEBOSS TECH MARKET')
@section('description', 'Découvrez tous nos produits dans la catégorie ' . $category->name . '. ' . ($category->description ?: 'Qualité et prix attractifs garantis.'))

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Accueil</a></li>
                <li class="text-gray-500">/</li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Produits</a></li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-900">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                @if($category->getFirstMediaUrl('images'))
                    <img src="{{ $category->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $category->name }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                @else
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $products->total() }} produit(s) disponible(s)</p>
                </div>
            </div>
            
            @if($category->description)
                <p class="text-xl text-gray-600 max-w-3xl">{{ $category->description }}</p>
            @endif
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 lg:mb-0">
                    <h3 class="text-lg font-semibold mb-4">Filtres</h3>
                    
                    <form method="GET" action="{{ route('products.category', $category->slug) }}" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   placeholder="Nom du produit..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Other Categories -->
                        @if($categories->count() > 1)
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Autres catégories</label>
                            <select id="category" name="category" onchange="window.location.href = this.value" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="{{ route('products.category', $category->slug) }}">{{ $category->name }}</option>
                                @foreach($categories as $cat)
                                    @if($cat->id !== $category->id)
                                        <option value="{{ route('products.category', $cat->slug) }}">
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (FCFA)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" 
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" 
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Stock Filter -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">En stock uniquement</span>
                            </label>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium transition-colors">
                                Filtrer
                            </button>
                            <a href="{{ route('products.category', $category->slug) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-md font-medium text-center transition-colors">
                                Reset
                            </a>
                        </div>
                    </form>

                    <!-- Quick Links -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-3">Actions rapides</h4>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}" class="block text-sm text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-left mr-2"></i>Tous les produits
                            </a>
                            <a href="https://wa.me/2250566821609?text=Bonjour, je cherche un produit dans la catégorie {{ $category->name }}" 
                               target="_blank" class="block text-sm text-green-600 hover:text-green-800">
                                <i class="fab fa-whatsapp mr-2"></i>Aide via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <!-- Results Info -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">
                        {{ $products->total() }} produit(s) dans {{ $category->name }}
                        @if(request()->hasAny(['search', 'min_price', 'max_price', 'in_stock']))
                            <span class="text-sm text-blue-600">
                                (filtré{{ $products->total() > 1 ? 's' : '' }})
                            </span>
                        @endif
                    </p>
                </div>

                @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                                <div class="relative">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        @if($product->getFirstMediaUrl('images'))
                                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                                            </div>
                                        @endif
                                    </a>
                                    
                                    @if($product->stock <= 0)
                                        <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                            Rupture de stock
                                        </div>
                                    @endif
                                    
                                    @if($product->is_featured)
                                        <div class="absolute top-2 right-2 bg-blue-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                            Vedette
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600 transition-colors">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->short_description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-2xl font-bold text-blue-600">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                        @if($product->stock > 0)
                                            <span class="text-xs text-green-600 font-semibold">En stock ({{ $product->stock }})</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-2 rounded transition-colors text-sm font-medium">
                                            Voir détails
                                        </a>
                                        <a href="{{ $product->whatsapp_url }}" target="_blank" 
                                           onclick="fetch('{{ route('products.whatsapp-click', $product) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})" 
                                           class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded transition-colors text-sm font-medium">
                                            <i class="fab fa-whatsapp mr-1"></i> Commander
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
                        <p class="text-gray-600 mb-6">
                            @if(request()->hasAny(['search', 'min_price', 'max_price', 'in_stock']))
                                Aucun produit ne correspond à vos critères de recherche dans cette catégorie.
                            @else
                                Cette catégorie ne contient pas encore de produits.
                            @endif
                        </p>
                        <div class="space-x-4">
                            @if(request()->hasAny(['search', 'min_price', 'max_price', 'in_stock']))
                                <a href="{{ route('products.category', $category->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Voir tous les produits de cette catégorie
                                </a>
                            @endif
                            <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                Voir tous les produits
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Category CTA -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Vous ne trouvez pas ce que vous cherchez ?</h2>
            <p class="text-xl text-blue-100 mb-6">
                Contactez-nous directement via WhatsApp pour un conseil personnalisé sur les produits {{ $category->name }}
            </p>
            <a href="https://wa.me/2250566821609?text=Bonjour, je cherche un produit spécifique dans la catégorie {{ $category->name }}" 
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors inline-flex items-center">
                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                Demander conseil
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush 