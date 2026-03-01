@extends('layouts.admin')

@section('title', 'Modifier Produit - LEBOSS TECH ADMIN')

@push('styles')
<link href="{{ asset('css/product-edit-enhanced.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-edit text-orange-500 mr-3"></i>
                        Modifier le produit
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $product->name ?? 'Produit' }}</p>
                    <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            Créé le {{ $product->created_at->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            Modifié le {{ $product->updated_at->format('d/m/Y à H:i') }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            {{ $product->whatsapp_clicks }} vues WhatsApp
                        </span>
                    </div>

                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                
                <!-- Navigation par onglets -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-orange-500 text-orange-600" data-target="general-tab">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informations générales
                        </button>
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="pricing-tab">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Prix & Stock
                        </button>
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="media-tab">
                            <i class="fas fa-images mr-2"></i>
                            Images
                        </button>
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="specifications-tab">
                            <i class="fas fa-cogs mr-2"></i>
                            Spécifications
                        </button>
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="seo-tab">
                            <i class="fas fa-search mr-2"></i>
                            SEO & Marketing
                        </button>
                        <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-target="settings-tab">
                            <i class="fas fa-cog mr-2"></i>
                            Paramètres
                        </button>
                    </nav>
                </div>

                <!-- Contenu des onglets -->
                <div class="p-6">
                    
                    <!-- Onglet Informations générales (visible par défaut) -->
                    <div id="general-tab" class="tab-content" style="display: block;">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Nom du produit -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tag text-orange-500 mr-1"></i>
                                        Nom du produit *
                                    </label>
                                    <input type="text" name="name" id="name" required maxlength="255"
                                           value="{{ old('name', $product->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                                           placeholder="Ex: MacBook Pro 13 pouces">
                                        @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                </div>

                                <!-- SKU -->
                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-barcode text-orange-500 mr-1"></i>
                                        Code produit (SKU) <span class="text-sm text-gray-500">(généré automatiquement si vide)</span>
                                    </label>
                                    <div class="flex">
                                        <input type="text" name="sku" id="sku"
                                               value="{{ old('sku', $product->sku ?? '') }}"
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sku') border-red-500 @enderror"
                                               placeholder="LBT-XXXX">
                                        <button type="button" id="generateSKU"
                                                class="px-4 py-3 bg-orange-500 text-white rounded-r-lg hover:bg-orange-600 transition-colors">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                    </div>
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description courte -->
                            <div>
                                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-align-center text-orange-500 mr-1"></i>
                                    Description courte *
                                </label>
                                <textarea name="short_description" id="short_description" rows="3" maxlength="500" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('short_description') border-red-500 @enderror"
                                          placeholder="Résumé attractif du produit en quelques lignes...">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                                    @error('short_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                            </div>

                            <!-- Description complète -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-align-left text-orange-500 mr-1"></i>
                                    Description détaillée *
                                </label>
                                <textarea name="description" id="description" rows="6" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                                          placeholder="Décrivez votre produit en détail...">{{ old('description', $product->description ?? '') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Catégorie et Marque -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-folder text-orange-500 mr-1"></i>
                                        Catégorie *
                                    </label>
                                    <select name="category_id" id="category_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category_id') border-red-500 @enderror">
                                        <option value="">Choisir une catégorie</option>
                                        @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-certificate text-orange-500 mr-1"></i>
                                        Marque
                                    </label>
                                    <input type="text" name="brand" id="brand" 
                                           value="{{ old('brand', $product->brand ?? '') }}"
                                           list="brands"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                           placeholder="Ex: Apple, Samsung, HP...">
                                    <datalist id="brands">
                                        <option value="Apple">
                                        <option value="Samsung">
                                        <option value="HP">
                                        <option value="Dell">
                                        <option value="Lenovo">
                                        <option value="ASUS">
                                        <option value="Acer">
                                        <option value="Canon">
                                        <option value="Epson">
                                        <option value="Logitech">
                                        <option value="Microsoft">
                                        <option value="Sony">
                                        <option value="LG">
                                        <option value="Huawei">
                                        <option value="Xiaomi">
                                    </datalist>
                                </div>
                            </div>

                            <!-- État du produit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-star text-orange-500 mr-1"></i>
                                    État du produit *
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                                    <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-green-50 hover:border-green-300 transition-all duration-200 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="condition" value="neuf" class="text-green-600 focus:ring-green-500" {{ old('condition', $product->condition ?? 'neuf') == 'neuf' ? 'checked' : '' }}>
                                        <div class="ml-2">
                                            <div class="font-semibold text-gray-900 flex items-center">
                                                <i class="fas fa-gem text-green-500 mr-1"></i>
                                                Neuf
                                            </div>
                                            <div class="text-xs text-gray-600">Avec garantie</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                                                                 <input type="radio" name="condition" value="excellent" class="text-blue-600 focus:ring-blue-500" {{ old('condition', $product->condition) == 'excellent' ? 'checked' : '' }}>
                                        <div class="ml-2">
                                            <div class="font-semibold text-gray-900 flex items-center">
                                                <i class="fas fa-star text-blue-500 mr-1"></i>
                                                Excellent
                                            </div>
                                            <div class="text-xs text-gray-600">Comme neuf</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                                                                 <input type="radio" name="condition" value="tres_bon" class="text-indigo-600 focus:ring-indigo-500" {{ old('condition', $product->condition ?? '') == 'tres_bon' ? 'checked' : '' }}>
                                        <div class="ml-2">
                                            <div class="font-semibold text-gray-900 flex items-center">
                                                <i class="fas fa-thumbs-up text-indigo-500 mr-1"></i>
                                                Très bon
                                            </div>
                                            <div class="text-xs text-gray-600">Légers signes</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-yellow-50 hover:border-yellow-300 transition-all duration-200 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                                        <input type="radio" name="condition" value="bon" class="text-yellow-600 focus:ring-yellow-500" {{ old('condition') == 'bon' ? 'checked' : '' }}>
                                        <div class="ml-2">
                                            <div class="font-semibold text-gray-900 flex items-center">
                                                <i class="fas fa-check text-yellow-500 mr-1"></i>
                                                Bon
                                </div>
                                            <div class="text-xs text-gray-600">Signes visibles</div>
                            </div>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                        <input type="radio" name="condition" value="correct" class="text-orange-600 focus:ring-orange-500" {{ old('condition') == 'correct' ? 'checked' : '' }}>
                                        <div class="ml-2">
                                            <div class="font-semibold text-gray-900 flex items-center">
                                                <i class="fas fa-tools text-orange-500 mr-1"></i>
                                                Correct
                                            </div>
                                            <div class="text-xs text-gray-600">Usure normale</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet Prix & Stock -->
                    <div id="pricing-tab" class="tab-content" style="display: none;">
                        <div class="space-y-8">
                            <!-- Section Prix -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                    Tarification
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tag text-orange-500 mr-1"></i>
                                        Prix de vente (FCFA) *
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="price" id="price" required min="0" step="1"
                                               value="{{ old('price', $product->price) }}"
                                               class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 @enderror"
                                               placeholder="0">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm font-medium">FCFA</span>
                                        </div>
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tags text-orange-500 mr-1"></i>
                                        Prix de comparaison (FCFA)
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="compare_price" id="compare_price" min="0" step="1"
                                               value="{{ old('compare_price', $product->compare_price ?? '0') }}"
                                                   class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm font-medium">FCFA</span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Prix barré pour montrer la réduction</p>
                            </div>

                                <div>
                                    <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-receipt text-orange-500 mr-1"></i>
                                            Prix d'achat (FCFA)
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="cost_price" id="cost_price" min="0" step="1"
                                               value="{{ old('cost_price', $product->cost_price ?? '0') }}"
                                                   class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm font-medium">FCFA</span>
                                        </div>
                                    </div>
                                        <p class="mt-1 text-sm text-gray-500">Pour calculer la marge bénéficiaire</p>
                                    </div>
                                </div>

                                <!-- Calcul de marge automatique -->
                                <div id="marginCalculation" class="mt-4 p-4 bg-white rounded-lg border border-gray-200" style="display: none;">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Marge bénéficiaire :</span>
                                        <span id="marginAmount" class="text-lg font-bold text-green-600">0 FCFA</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-sm text-gray-600">Pourcentage de marge :</span>
                                        <span id="marginPercent" class="text-sm font-semibold text-green-600">0%</span>
                                </div>
                                </div>
                            </div>

                            <!-- Section Stock -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-boxes text-blue-600 mr-2"></i>
                                    Gestion du stock
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                    <div>
                                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-cubes text-orange-500 mr-1"></i>
                                            Quantité en stock *
                                        </label>
                                        <input type="number" name="stock" id="stock" required min="0"
                                               value="{{ old('stock', $product->stock ?? 0) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('stock') border-red-500 @enderror"
                                               placeholder="0">
                                        @error('stock')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-exclamation-triangle text-orange-500 mr-1"></i>
                                            Stock minimum
                                        </label>
                                        <input type="number" name="min_stock" id="min_stock" min="0"
                                               value="{{ old('min_stock', $product->min_stock ?? 5) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="5">
                                        <p class="mt-1 text-sm text-gray-500">Alerte stock bas</p>
                                    </div>

                                    <div>
                                        <label for="max_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-warehouse text-orange-500 mr-1"></i>
                                            Stock maximum
                                        </label>
                                        <input type="number" name="max_stock" id="max_stock" min="0"
                                               value="{{ old('max_stock') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="100">
                                        <p class="mt-1 text-sm text-gray-500">Limite de stockage</p>
                                </div>

                                    <div>
                                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-map-marker-alt text-orange-500 mr-1"></i>
                                            Emplacement
                                        </label>
                                        <input type="text" name="location" id="location"
                                               value="{{ old('location') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="Ex: Étagère A-1">
                                        <p class="mt-1 text-sm text-gray-500">Position en magasin</p>
                                    </div>
                                    </div>

                                <!-- Indicateur de stock -->
                                <div id="stockIndicator" class="mt-4 p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Statut du stock :</span>
                                        <span id="stockStatus" class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">Non défini</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Livraison -->
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-shipping-fast text-purple-600 mr-2"></i>
                                    Livraison et dimensions
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                    <div>
                                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-weight text-orange-500 mr-1"></i>
                                            Poids (kg)
                                        </label>
                                        <input type="number" name="weight" id="weight" min="0" step="0.01"
                                               value="{{ old('weight') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0.00">
                                    </div>

                                    <div>
                                        <label for="length" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-ruler text-orange-500 mr-1"></i>
                                            Longueur (cm)
                                        </label>
                                        <input type="number" name="length" id="length" min="0" step="0.1"
                                               value="{{ old('length') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0.0">
                                    </div>

                                    <div>
                                        <label for="width" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-arrows-alt-h text-orange-500 mr-1"></i>
                                            Largeur (cm)
                                        </label>
                                        <input type="number" name="width" id="width" min="0" step="0.1"
                                               value="{{ old('width') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0.0">
                                    </div>

                                    <div>
                                        <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-arrows-alt-v text-orange-500 mr-1"></i>
                                            Hauteur (cm)
                                        </label>
                                        <input type="number" name="height" id="height" min="0" step="0.1"
                                               value="{{ old('height') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="0.0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet Images -->
                    <div id="media-tab" class="tab-content" style="display: none;">
                        <div class="space-y-6">
                            
                            <!-- Images existantes -->
                            @php 
                                // Utilisation des images passées par le contrôleur
                                $existingImages = $productImages ?? collect();
                                $imageCount = $existingImages->count();
                            @endphp
                            
                            @if($imageCount > 0)
                                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <i class="fas fa-images text-orange-500 mr-2"></i>
                                        Images actuelles ({{ $imageCount }})
                                    </h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach($existingImages as $image)
                                            <div class="relative group">
                                                <img src="{{ $image->getUrl() }}" 
                                                     alt="Image produit" 
                                                     class="w-full h-32 object-cover rounded-lg border border-gray-200"
                                                     loading="lazy">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all rounded-lg flex items-center justify-center">
                                                    <button type="button" 
                                                            onclick="removeExistingImage({{ $image->id }}, this)"
                                                            class="bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600"
                                                            title="Supprimer cette image">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </div>
                                                <div class="absolute bottom-1 left-1 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                                    {{ $loop->iteration }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-sm text-gray-500 mt-4">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Cliquez sur l'icône de suppression pour retirer une image
                                    </p>
                                </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">
                                                Aucune image pour ce produit
                                            </h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <p>Ce produit n'a pas encore d'images. Utilisez la section ci-dessous pour ajouter des images qui seront visibles sur le site.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg p-8 border-2 border-dashed border-orange-300 text-center">
                                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-orange-100 mb-6">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-orange-600"></i>
                                            </div>
                                <h3 class="text-xl font-medium text-gray-900 mb-3">Ajouter des images</h3>
                                <p class="text-gray-600 mb-6">Glissez-déposez vos images ici ou cliquez pour sélectionner</p>
                                
                                <div class="flex justify-center">
                                    <label for="images" class="cursor-pointer inline-flex items-center px-8 py-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                                        <i class="fas fa-plus mr-3"></i>
                                        Choisir des images
                                    </label>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </div>

                                <div class="mt-6 text-sm text-gray-500 space-y-1">
                                    <p>• Formats acceptés: JPG, PNG, GIF, WEBP</p>
                                    <p>• Taille maximum: 5 MB par image</p>
                                    <p>• Jusqu'à 10 images par produit</p>
                                        </div>
                                    </div>
                                    
                            <!-- Aperçu des images -->
                            <div id="imagePreview" style="display: none;">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Images sélectionnées</h4>
                                <div id="imageList" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                                    </div>
                                </div>
                            </div>

                    <!-- Onglet Spécifications -->
                    <div id="specifications-tab" class="tab-content" style="display: none;">
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-cogs text-blue-600 mr-2"></i>
                                    Spécifications techniques
                                </h3>
                                <button type="button" id="addSpecification" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter une spécification
                                </button>
                            </div>
                            
                            <div id="specificationsContainer" class="space-y-4">
                                <!-- Spécifications existantes -->
                                @if($product->specifications && count($product->specifications) > 0)
                                    @foreach($product->specifications as $key => $value)
                                        <div class="spec-row flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="flex-1">
                                                <input type="text" name="spec_keys[]" 
                                                       value="{{ $key }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                       placeholder="Nom de la spécification">
                                            </div>
                                            <div class="flex-1">
                                                <input type="text" name="spec_values[]" 
                                                       value="{{ $value }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                       placeholder="Valeur">
                                            </div>
                                            <button type="button" onclick="removeSpecification(this)" 
                                                    class="text-red-500 hover:text-red-700 p-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- Les nouvelles spécifications seront ajoutées dynamiquement ici -->
                            </div>
                            
                            <!-- Templates rapides -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-3">Templates rapides :</h4>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="addSpecTemplate('laptop')" class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg text-sm hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-laptop mr-1"></i>
                                        Ordinateur portable
                                    </button>
                                    <button type="button" onclick="addSpecTemplate('desktop')" class="bg-green-100 text-green-800 px-3 py-2 rounded-lg text-sm hover:bg-green-200 transition-colors">
                                        <i class="fas fa-desktop mr-1"></i>
                                        Ordinateur de bureau
                                    </button>
                                    <button type="button" onclick="addSpecTemplate('smartphone')" class="bg-purple-100 text-purple-800 px-3 py-2 rounded-lg text-sm hover:bg-purple-200 transition-colors">
                                        <i class="fas fa-mobile-alt mr-1"></i>
                                        Smartphone
                                    </button>
                                    <button type="button" onclick="addSpecTemplate('accessory')" class="bg-yellow-100 text-yellow-800 px-3 py-2 rounded-lg text-sm hover:bg-yellow-200 transition-colors">
                                        <i class="fas fa-plug mr-1"></i>
                                        Accessoire
                                    </button>
                                    <button type="button" onclick="addSpecTemplate('printer')" class="bg-red-100 text-red-800 px-3 py-2 rounded-lg text-sm hover:bg-red-200 transition-colors">
                                        <i class="fas fa-print mr-1"></i>
                                        Imprimante
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet SEO & Marketing -->
                    <div id="seo-tab" class="tab-content" style="display: none;">
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-6 border border-indigo-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-search text-indigo-600 mr-2"></i>
                                    Optimisation SEO
                            </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-heading text-orange-500 mr-1"></i>
                                            Titre SEO
                                        </label>
                                        <input type="text" name="meta_title" id="meta_title" maxlength="60"
                                               value="{{ old('meta_title', $product->meta_title ?? '') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="Titre optimisé pour les moteurs de recherche">
                                        <div class="flex justify-between mt-1">
                                            <p class="text-sm text-gray-500">Recommandé: 50-60 caractères</p>
                                            <span class="text-sm text-gray-400" id="metaTitleCounter">0/60</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-paragraph text-orange-500 mr-1"></i>
                                            Description SEO
                                        </label>
                                        <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                  placeholder="Description qui apparaîtra dans les résultats de recherche">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                                        <div class="flex justify-between mt-1">
                                            <p class="text-sm text-gray-500">Recommandé: 150-160 caractères</p>
                                            <span class="text-sm text-gray-400" id="metaDescCounter">0/160</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tags text-orange-500 mr-1"></i>
                                            Mots-clés (Tags)
                                        </label>
                                        <input type="text" name="tags" id="tags"
                                               value="{{ old('tags', $product->tags ?? '') }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="ordinateur, laptop, apple, macbook (séparés par des virgules)">
                                        <p class="mt-1 text-sm text-gray-500">Mots-clés séparés par des virgules</p>
                                    </div>
                                    </div>
                                </div>

                            <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg p-6 border border-pink-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-bullhorn text-pink-600 mr-2"></i>
                                    Marketing
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div>
                                        <label for="warranty" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-shield-alt text-orange-500 mr-1"></i>
                                            Garantie
                                        </label>
                                        <select name="warranty" id="warranty" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Sélectionner</option>
                                            <option value="3_months" {{ old('warranty') == '3_months' ? 'selected' : '' }}>3 mois</option>
                                            <option value="6_months" {{ old('warranty') == '6_months' ? 'selected' : '' }}>6 mois</option>
                                            <option value="1_year" {{ old('warranty') == '1_year' ? 'selected' : '' }}>1 an</option>
                                            <option value="2_years" {{ old('warranty') == '2_years' ? 'selected' : '' }}>2 ans</option>
                                            <option value="3_years" {{ old('warranty') == '3_years' ? 'selected' : '' }}>3 ans</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="return_policy" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-undo text-orange-500 mr-1"></i>
                                            Politique de retour
                                        </label>
                                        <select name="return_policy" id="return_policy" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Sélectionner</option>
                                            <option value="7_days" {{ old('return_policy') == '7_days' ? 'selected' : '' }}>7 jours</option>
                                            <option value="14_days" {{ old('return_policy') == '14_days' ? 'selected' : '' }}>14 jours</option>
                                            <option value="30_days" {{ old('return_policy') == '30_days' ? 'selected' : '' }}>30 jours</option>
                                            <option value="no_return" {{ old('return_policy') == 'no_return' ? 'selected' : '' }}>Pas de retour</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglet Paramètres -->
                    <div id="settings-tab" class="tab-content" style="display: none;">
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-cog text-gray-600 mr-2"></i>
                                    Paramètres du produit
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Statut et visibilité -->
                                    <div class="space-y-4">
                                        <h4 class="font-medium text-gray-900 mb-3">Statut et visibilité</h4>
                                        
                                        <div class="space-y-3">
                                            <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Produit actif</div>
                                                    <div class="text-sm text-gray-600">Visible sur le site</div>
                                            </div>
                                        </label>
                                        
                                            <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Produit mis en avant</div>
                                                    <div class="text-sm text-gray-600">Affiché en première page</div>
                                            </div>
                                        </label>

                                            <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                                <input type="checkbox" name="track_stock" value="1" {{ old('track_stock', true) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Suivi du stock</div>
                                                    <div class="text-sm text-gray-600">Gérer automatiquement le stock</div>
                                            </div>
                                        </label>

                                            <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                                <input type="checkbox" name="allow_backorder" value="1" {{ old('allow_backorder') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Autoriser les précommandes</div>
                                                    <div class="text-sm text-gray-600">Vendre même en rupture de stock</div>
                                            </div>
                                        </label>
                        </div>
                    </div>

                                    <!-- Dates et programmation -->
                                    <div class="space-y-4">
                                        <h4 class="font-medium text-gray-900 mb-3">Dates et programmation</h4>
                                        
                                        <div>
                                            <label for="available_from" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-calendar-plus text-orange-500 mr-1"></i>
                                                Disponible à partir du
                                            </label>
                                            <input type="datetime-local" name="available_from" id="available_from"
                                                   value="{{ old('available_from') }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        </div>
                                        
                                        <div>
                                            <label for="available_until" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-calendar-minus text-orange-500 mr-1"></i>
                                                Disponible jusqu'au
                                            </label>
                                            <input type="datetime-local" name="available_until" id="available_until"
                                                   value="{{ old('available_until') }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    
                                        <div>
                                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-sort text-orange-500 mr-1"></i>
                                                Ordre de tri
                                            </label>
                                            <input type="number" name="sort_order" id="sort_order" min="0"
                                                   value="{{ old('sort_order', 0) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                   placeholder="0">
                                            <p class="mt-1 text-sm text-gray-500">Plus le nombre est élevé, plus le produit apparaît en premier</p>
                                        </div>
                                    </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <div class="flex space-x-3">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors"
                                onclick="return confirmUpdate()">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour le produit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 LEBOSS TECH - Page création produit chargée');

    // Gestion des onglets
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            
            // Réinitialiser tous les onglets
            tabButtons.forEach(btn => {
                btn.classList.remove('border-orange-500', 'text-orange-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabContents.forEach(content => {
                content.style.display = 'none';
            });
            
            // Activer l'onglet sélectionné
            button.classList.remove('border-transparent', 'text-gray-500');
            button.classList.add('border-orange-500', 'text-orange-600');
            
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
            }
        });
    });

    // Génération du SKU
    const generateSKUBtn = document.getElementById('generateSKU');
    const skuInput = document.getElementById('sku');
    
    if (generateSKUBtn && skuInput) {
        generateSKUBtn.addEventListener('click', function() {
            const timestamp = Date.now().toString().slice(-6);
            const randomNum = Math.floor(Math.random() * 99) + 1;
            const sku = `LBT-${timestamp}${randomNum.toString().padStart(2, '0')}`;
            skuInput.value = sku;
        });
    }

    // Gestion des images
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    const imageList = document.getElementById('imageList');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            files.forEach(file => {
                if (file.type.startsWith('image/') && file.size <= 5 * 1024 * 1024) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'relative group';
                        imageDiv.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                ${file.name}
                            </div>
                        `;
                        imageList.appendChild(imageDiv);
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            if (files.length > 0) {
                imagePreview.style.display = 'block';
            }
        });
    }

    // Validation du formulaire
    const form = document.getElementById('productForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Vérifier et afficher tous les onglets pour éviter les erreurs de focusabilité
            tabContents.forEach(content => {
                content.style.display = 'block';
            });
            
            const name = document.getElementById('name').value.trim();
            const sku = document.getElementById('sku').value.trim();
            const price = document.getElementById('price').value;
            const stock = document.getElementById('stock').value;
            const categoryId = document.getElementById('category_id').value;
            const shortDesc = document.getElementById('short_description').value.trim();
            const description = document.getElementById('description').value.trim();
            
            // Générer automatiquement un SKU si vide
            if (!sku) {
                const timestamp = Date.now().toString().slice(-6);
                const randomNum = Math.floor(Math.random() * 99) + 1;
                const generatedSku = `LBT-${timestamp}${randomNum.toString().padStart(2, '0')}`;
                document.getElementById('sku').value = generatedSku;
                console.log('SKU généré automatiquement:', generatedSku);
            }
            
            if (!name || !price || !stock || !categoryId || !shortDesc || !description) {
                alert('Veuillez remplir tous les champs obligatoires (marqués avec *)');
                
                // Retourner au premier onglet pour montrer les erreurs
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-orange-500', 'text-orange-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });
                tabButtons[0].classList.remove('border-transparent', 'text-gray-500');
                tabButtons[0].classList.add('border-orange-500', 'text-orange-600');
                document.getElementById('general-tab').style.display = 'block';
                
        e.preventDefault();
                return false;
            }
            
            if (price <= 0) {
                alert('Le prix doit être supérieur à 0');
                
                // Aller à l'onglet prix
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-orange-500', 'text-orange-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });
                tabButtons[1].classList.remove('border-transparent', 'text-gray-500');
                tabButtons[1].classList.add('border-orange-500', 'text-orange-600');
                document.getElementById('pricing-tab').style.display = 'block';
                
                e.preventDefault();
                return false;
            }
            
            console.log('✅ Formulaire valide, envoi en cours...');
            return true;
        });
    }

    // Calcul automatique de la marge
    const priceInput = document.getElementById('price');
    const costPriceInput = document.getElementById('cost_price');
    const marginCalculation = document.getElementById('marginCalculation');
    const marginAmount = document.getElementById('marginAmount');
    const marginPercent = document.getElementById('marginPercent');

    function calculateMargin() {
        const price = parseFloat(priceInput.value) || 0;
        const costPrice = parseFloat(costPriceInput.value) || 0;
        
        if (price > 0 && costPrice > 0) {
            const margin = price - costPrice;
            const marginPercentage = ((margin / price) * 100).toFixed(1);
            
            marginAmount.textContent = margin.toLocaleString() + ' FCFA';
            marginPercent.textContent = marginPercentage + '%';
            marginCalculation.style.display = 'block';
        } else {
            marginCalculation.style.display = 'none';
        }
    }

    if (priceInput && costPriceInput) {
        priceInput.addEventListener('input', calculateMargin);
        costPriceInput.addEventListener('input', calculateMargin);
    }

    // Indicateur de stock
    const stockInput = document.getElementById('stock');
    const minStockInput = document.getElementById('min_stock');
    const stockStatus = document.getElementById('stockStatus');

    function updateStockStatus() {
        const stock = parseInt(stockInput.value) || 0;
        const minStock = parseInt(minStockInput.value) || 0;
        
        if (stock === 0) {
            stockStatus.textContent = 'Rupture de stock';
            stockStatus.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
        } else if (stock <= minStock) {
            stockStatus.textContent = 'Stock bas';
            stockStatus.className = 'px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800';
        } else {
            stockStatus.textContent = 'Stock disponible';
            stockStatus.className = 'px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
        }
    }

    if (stockInput && minStockInput) {
        stockInput.addEventListener('input', updateStockStatus);
        minStockInput.addEventListener('input', updateStockStatus);
        updateStockStatus(); // Initial call
    }

    // Gestion des spécifications
    const addSpecBtn = document.getElementById('addSpecification');
    const specsContainer = document.getElementById('specificationsContainer');

    if (addSpecBtn) {
        addSpecBtn.addEventListener('click', function() {
            addSpecification('', '');
        });
    }

    function addSpecification(key = '', value = '') {
        const specDiv = document.createElement('div');
        specDiv.className = 'flex space-x-4 items-center bg-white p-4 rounded-lg border border-gray-200';
        specDiv.innerHTML = `
            <div class="flex-1">
                <input type="text" name="spec_keys[]" value="${key}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                       placeholder="Ex: Processeur">
            </div>
            <div class="flex-1">
                <input type="text" name="spec_values[]" value="${value}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                       placeholder="Ex: Intel Core i5">
            </div>
            <button type="button" onclick="removeSpecification(this)" class="bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition-colors">
                <i class="fas fa-trash"></i>
            </button>
        `;
        specsContainer.appendChild(specDiv);
    }

    window.removeSpecification = function(button) {
        button.closest('.flex').remove();
    };

    // Templates de spécifications
    window.addSpecTemplate = function(template) {
        const templates = {
            laptop: [
                ['Processeur', 'Intel Core i5'],
                ['Mémoire RAM', '8 GB DDR4'],
                ['Stockage', '256 GB SSD'],
                ['Écran', '15.6" Full HD'],
                ['Carte graphique', 'Intel UHD Graphics'],
                ['Système d\'exploitation', 'Windows 11'],
                ['Connectivité', 'Wi-Fi 6, Bluetooth 5.0'],
                ['Ports', 'USB-C, USB 3.0, HDMI'],
                ['Batterie', '50 Wh'],
                ['Poids', '1.8 kg']
            ],
            desktop: [
                ['Processeur', 'Intel Core i7'],
                ['Mémoire RAM', '16 GB DDR4'],
                ['Stockage', '512 GB SSD + 1 TB HDD'],
                ['Carte graphique', 'NVIDIA GTX 1660'],
                ['Carte mère', 'ATX'],
                ['Alimentation', '650W'],
                ['Boîtier', 'Tour moyenne'],
                ['Système d\'exploitation', 'Windows 11'],
                ['Connectivité', 'Ethernet, Wi-Fi'],
                ['Garantie', '2 ans']
            ],
            smartphone: [
                ['Écran', '6.1" Super Retina XDR'],
                ['Processeur', 'A15 Bionic'],
                ['Stockage', '128 GB'],
                ['Appareil photo', '12 MP principal'],
                ['Batterie', '3095 mAh'],
                ['Système', 'iOS 15'],
                ['Connectivité', '5G, Wi-Fi 6'],
                ['Résistance', 'IP68'],
                ['Couleurs', 'Plusieurs coloris'],
                ['Garantie', '1 an']
            ],
            accessory: [
                ['Connectivité', 'USB-C'],
                ['Compatibilité', 'Universal'],
                ['Dimensions', '10 x 5 x 2 cm'],
                ['Poids', '150g'],
                ['Couleur', 'Noir'],
                ['Matériau', 'Plastique ABS'],
                ['Certification', 'CE, FCC'],
                ['Garantie', '1 an'],
                ['Contenu', 'Câble inclus'],
                ['Manuel', 'Français, Anglais']
            ],
            printer: [
                ['Type', 'Jet d\'encre'],
                ['Résolution', '4800 x 1200 dpi'],
                ['Vitesse', '15 ppm noir, 10 ppm couleur'],
                ['Connectivité', 'USB, Wi-Fi'],
                ['Formats', 'A4, A5, Photo'],
                ['Recto-verso', 'Automatique'],
                ['Écran', 'LCD 2.4"'],
                ['Cartouches', 'Séparées'],
                ['Garantie', '2 ans'],
                ['Logiciel', 'Compatible Windows/Mac']
            ]
        };

        if (templates[template]) {
            templates[template].forEach(([key, value]) => {
                addSpecification(key, value);
            });
        }
    };

    // Compteurs de caractères pour SEO
    const metaTitleInput = document.getElementById('meta_title');
    const metaDescInput = document.getElementById('meta_description');
    const metaTitleCounter = document.getElementById('metaTitleCounter');
    const metaDescCounter = document.getElementById('metaDescCounter');

    if (metaTitleInput && metaTitleCounter) {
        metaTitleInput.addEventListener('input', function() {
            const count = this.value.length;
            metaTitleCounter.textContent = count + '/60';
            metaTitleCounter.className = count > 60 ? 'text-sm text-red-500' : 'text-sm text-gray-400';
        });
    }

    if (metaDescInput && metaDescCounter) {
        metaDescInput.addEventListener('input', function() {
            const count = this.value.length;
            metaDescCounter.textContent = count + '/160';
            metaDescCounter.className = count > 160 ? 'text-sm text-red-500' : 'text-sm text-gray-400';
        });
    }

    // Auto-remplissage SEO basé sur le nom du produit
    const nameInput = document.getElementById('name');
    if (nameInput && metaTitleInput) {
        nameInput.addEventListener('blur', function() {
            if (!metaTitleInput.value && this.value) {
                metaTitleInput.value = this.value + ' - LEBOSS TECH';
                metaTitleInput.dispatchEvent(new Event('input'));
            }
        });
    }

    console.log('✅ Initialisation terminée - Version complète');
});

// Fonction de confirmation de modification
function confirmUpdate() {
    const productName = document.getElementById('name').value || 'ce produit';
    
    // Créer une modal de confirmation personnalisée
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-md mx-4 shadow-xl">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-orange-600 text-lg"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Confirmer la modification</h3>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-gray-600">
                    Êtes-vous sûr de vouloir modifier <strong>${productName}</strong> ?
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Cette action mettra à jour toutes les informations du produit.
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeConfirmModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button type="button" onclick="confirmAndSubmit()" 
                        class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Confirmer la modification
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    return false; // Empêcher la soumission immédiate
}

function closeConfirmModal() {
    const modal = document.querySelector('.fixed.inset-0');
    if (modal) {
        modal.remove();
    }
}

function confirmAndSubmit() {
    closeConfirmModal();
    
    // Afficher un indicateur de chargement
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Modification en cours...';
    submitBtn.disabled = true;
    
    // Soumettre le formulaire
    document.getElementById('productForm').submit();
}

// Fonction pour supprimer les images existantes
function removeExistingImage(imageId, button) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        // Créer un input hidden pour marquer l'image à supprimer
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = imageId;
        document.getElementById('productForm').appendChild(input);
        
        // Masquer l'image visuellement avec animation
        const imageContainer = button.closest('.relative');
        imageContainer.style.opacity = '0.5';
        imageContainer.style.pointerEvents = 'none';
        
        // Ajouter un indicateur de suppression
        const indicator = document.createElement('div');
        indicator.className = 'absolute inset-0 bg-red-500 bg-opacity-75 flex items-center justify-center rounded-lg';
        indicator.innerHTML = '<i class="fas fa-trash text-white text-2xl"></i>';
        imageContainer.appendChild(indicator);
        
        console.log('Image marquée pour suppression:', imageId);
    }
}
</script>

@push('scripts')
<script src="{{ asset('js/product-edit-enhanced.js') }}"></script>
@endpush
@endsection 