@extends('layouts.public')

@section('title', $product->meta_title ?: $product->name . ' - LEBOSS TECH MARKET')
@section('description', $product->meta_description ?: $product->short_description)

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-800">Accueil</a></li>
                <li class="text-gray-500">/</li>
                <li><a href="{{ route('products.index') }}" class="text-orange-600 hover:text-orange-800">Produits</a></li>
                <li class="text-gray-500">/</li>
                <li><a href="{{ route('products.category', $product->category->slug) }}" class="text-orange-600 hover:text-orange-800">{{ $product->category->name }}</a></li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-900">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div class="p-6">
                    @if($productImages && $productImages->count() > 0)
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="relative product-image-container">
                                <img id="mainImage" src="{{ $productImages->first()->getUrl() }}" alt="{{ $product->name }}" 
                                     class="w-full h-96 object-cover rounded-lg cursor-pointer main-product-image" onclick="openImageModal('{{ $productImages->first()->getUrl() }}')">
                                <!-- Indicateur d'images multiples -->
                                @if($productImages->count() > 1)
                                    <div class="absolute top-4 right-4 bg-black bg-opacity-75 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-images mr-1"></i>
                                        {{ $productImages->count() }} photos
                                    </div>
                                @endif
                                <!-- Bouton plein écran -->
                                <div class="absolute bottom-4 right-4">
                                    <button onclick="openImageModal('{{ $productImages->first()->getUrl() }}')" 
                                            class="bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-2 rounded-full transition-all">
                                        <i class="fas fa-expand text-lg"></i>
                                    </button>
                                </div>
                                <!-- Badge "Nouveau" ou "Populaire" -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                                        🔥 POPULAIRE
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Thumbnails -->
                            @if($productImages->count() > 1)
                                <div class="flex space-x-2 overflow-x-auto pb-2">
                                    @foreach($productImages as $index => $media)
                                        <button onclick="changeImage('{{ $media->getUrl() }}', {{ $index }})" 
                                                class="thumbnail-btn flex-shrink-0 w-20 h-20 rounded-md overflow-hidden border-2 {{ $index === 0 ? 'border-orange-500' : 'border-gray-200' }} hover:border-orange-400 transition-colors"
                                                data-index="{{ $index }}">
                                            <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-image text-gray-400 text-6xl mb-4"></i>
                                <p class="text-gray-500">Aucune image disponible</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-6 lg:py-6 lg:px-8">
                    <!-- Badges Marketing - Version avec contraste amélioré -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                        <!-- Badge catégorie -->
                        <a href="{{ route('products.category', $product->category->slug) }}" class="bg-orange-100 text-orange-900 text-sm font-bold px-4 py-2 rounded-lg hover:bg-orange-200 transition-colors text-center border-2 border-orange-300">
                            📂 {{ $product->category->name }}
                        </a>
                        
                        <!-- Badges principaux avec contraste amélioré -->
                        <div class="bg-purple-600 text-white text-sm font-bold px-4 py-2 rounded-lg animate-pulse text-center shadow-lg border-2 border-purple-700">
                            💎 QUALITÉ PREMIUM
                        </div>
                        <div class="bg-green-600 text-white text-sm font-bold px-4 py-2 rounded-lg text-center shadow-lg border-2 border-green-700">
                            🚚 LIVRAISON GRATUITE
                        </div>
                        <div class="bg-red-600 text-white text-sm font-black px-4 py-2 rounded-lg text-center shadow-xl border-4 border-red-800 animate-pulse">
                            🛡️ GARANTIE 1 AN
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <!-- Prix avec effet marketing -->
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 p-4 rounded-xl border-2 border-orange-200 mb-6 relative overflow-hidden">
                        <!-- Effet de brillance -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-20 animate-pulse"></div>
                        
                        <div class="relative">
                            @php
                                $originalPrice = $product->price * 1.25; // Prix "barré" 25% plus élevé
                                $savings = $originalPrice - $product->price;
                            @endphp
                            
                        <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <span class="text-lg text-gray-500 line-through font-medium">{{ number_format($originalPrice, 0, ',', ' ') }} FCFA</span>
                                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full animate-bounce">
                                        -25% 🔥
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="bg-red-500 text-white px-3 py-1 rounded-lg font-bold text-xs animate-pulse">
                                        ⏰ OFFRE LIMITÉE
                                    </div>
                                    <div class="text-xs text-red-600 font-semibold mt-1">Se termine dans 24h</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-4xl font-bold text-orange-600">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                    <div class="text-green-600 font-bold text-sm mt-1">
                                        💰 Vous économisez {{ number_format($savings, 0, ',', ' ') }} FCFA !
                                    </div>
                                </div>
                                @if($product->sku)
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                        <div class="text-xs text-gray-600 mt-1">⭐ Note: 4.8/5 (127 avis)</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>
                        
                    <!-- Stock avec urgence -->
                    <div class="mb-6">
                        @if($product->stock > 0)
                            @if($product->stock <= 3)
                                <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4 rounded-r-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-red-800 font-bold">
                                                🔥 ATTENTION ! Plus que {{ $product->stock }} exemplaire{{ $product->stock > 1 ? 's' : '' }} en stock !
                                            </p>
                                            <p class="text-red-700 text-sm">
                                                ⚡ {{ rand(8, 15) }} personnes regardent ce produit actuellement
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($product->stock <= 10)
                                <div class="bg-orange-100 border-l-4 border-orange-500 p-4 mb-4 rounded-r-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-fire text-orange-500 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-orange-800 font-bold">
                                                ⚡ STOCK LIMITÉ - {{ $product->stock }} unités restantes
                                            </p>
                                            <p class="text-orange-700 text-sm">
                                                📈 Forte demande sur ce produit - Commandez vite !
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4 rounded-r-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-green-800 font-bold">
                                                ✅ En stock - {{ $product->stock }} unités disponibles
                                            </p>
                                            <p class="text-green-700 text-sm">
                                                🚀 Expédition sous 24h - Livraison gratuite
                                            </p>
                                        </div>
                                    </div>
                            </div>
                            @endif
                        @else
                            <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4 rounded-r-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-red-800 font-bold">❌ Rupture de stock temporaire</p>
                                        <p class="text-red-700 text-sm">📞 Contactez-nous pour connaître la prochaine disponibilité</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                    </div>

                    <!-- Avantages exclusifs avec contraste maximal -->
                    <div class="bg-white p-6 rounded-xl mb-6 border-4 border-blue-600 shadow-lg">
                        <h4 class="font-black text-blue-900 mb-4 text-lg bg-blue-100 px-4 py-2 rounded-lg border-2 border-blue-300">🎁 AVANTAGES EXCLUSIFS LEBOSS TECH</h4>
                        <ul class="space-y-3">
                            <li class="flex items-center bg-green-50 p-3 rounded-lg border-2 border-green-300">
                                <i class="fas fa-check-circle text-green-700 mr-3 text-lg"></i>
                                <span class="font-bold text-gray-900"><span class="text-green-700">Livraison gratuite</span> en 24-48h à Abidjan</span>
                            </li>
                            <li class="flex items-center bg-blue-50 p-3 rounded-lg border-2 border-blue-300">
                                <i class="fas fa-shield-alt text-blue-700 mr-3 text-lg"></i>
                                <span class="font-bold text-gray-900"><span class="text-blue-700">Garantie constructeur</span> + extension LEBOSS</span>
                            </li>
                            <li class="flex items-center bg-orange-50 p-3 rounded-lg border-2 border-orange-300">
                                <i class="fas fa-tools text-orange-700 mr-3 text-lg"></i>
                                <span class="font-bold text-gray-900"><span class="text-orange-700">Installation gratuite</span> par nos techniciens</span>
                            </li>
                            <li class="flex items-center bg-purple-50 p-3 rounded-lg border-2 border-purple-300">
                                <i class="fas fa-headset text-purple-700 mr-3 text-lg"></i>
                                <span class="font-bold text-gray-900"><span class="text-purple-700">Support technique</span> 7j/7 par WhatsApp</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Compteur de visiteurs fictif -->
                    <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-lg mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-yellow-800">
                                <i class="fas fa-eye text-yellow-600 mr-2"></i>
                                <span id="viewCounter">{{ rand(45, 89) }}</span> personnes regardent ce produit
                            </div>
                            <div class="flex items-center text-green-800">
                                <i class="fas fa-shopping-cart text-green-600 mr-2"></i>
                                <span>{{ rand(12, 28) }}</span> vendus cette semaine
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Order Button - Version ultra-visible -->
                    <div class="mb-6">
                        @if($product->stock > 0)
                        <!-- Encadré de mise en avant du bouton avec contraste amélioré -->
                        <div class="bg-green-50 p-4 rounded-xl border-4 border-green-400 mb-4">
                            <div class="text-center mb-3">
                                <div class="text-xl font-black text-green-900 animate-bounce bg-white px-4 py-2 rounded-lg shadow-lg">
                                    🎯 COMMANDEZ MAINTENANT ET ÉCONOMISEZ !
                                </div>
                                <div class="text-sm text-green-800 font-bold mt-2 bg-green-100 px-3 py-1 rounded-lg">
                                    ⚡ Réponse immédiate sur WhatsApp • 🚚 Livraison express gratuite
                                </div>
                            </div>
                            
                            <button onclick="openWhatsAppModal({
                                id: {{ $product->id }},
                                name: '{{ addslashes($product->name) }}',
                                price: '{{ number_format($product->price, 0, '.', ' ') }}',
                                category: '{{ addslashes($product->category->name) }}',
                                slug: '{{ $product->slug }}',
                                image: '{{ $productImages && $productImages->count() > 0 ? $productImages->first()->getUrl() : '' }}',
                                clickTrackUrl: '{{ route('products.whatsapp-click', $product) }}'
                            })" class="w-full bg-green-600 hover:bg-green-700 text-white py-5 px-8 rounded-2xl font-bold text-xl transition-all transform hover:scale-105 shadow-2xl flex items-center justify-center border-4 border-green-800">
                                <div class="flex items-center">
                                    <i class="fab fa-whatsapp mr-4 text-3xl animate-pulse"></i>
                                    <div class="text-center">
                                        <div class="font-extrabold text-xl text-white">🛒 COMMANDER MAINTENANT</div>
                                        <div class="text-sm font-bold text-green-100">LIVRAISON GRATUITE • PAIEMENT À LA LIVRAISON</div>
                                    </div>
                                </div>
                            </button>
                        </div>
                        
                        <!-- Garanties et avantages sous le bouton - Version avec meilleure lisibilité -->
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="bg-green-100 border-2 border-green-300 rounded-xl p-3">
                                <div class="text-green-700 font-bold text-lg mb-1">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="text-green-900 font-bold text-sm">Paiement<br/>sécurisé</div>
                            </div>
                            <div class="bg-red-100 border-4 border-red-600 rounded-xl p-3 animate-pulse">
                                <div class="text-red-800 font-black text-xl mb-1">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="text-red-900 font-black text-base bg-white px-2 py-1 rounded border-2 border-red-400">GARANTIE<br/>1 AN</div>
                            </div>
                            <div class="bg-orange-100 border-2 border-orange-300 rounded-xl p-3">
                                <div class="text-orange-700 font-bold text-lg mb-1">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="text-orange-900 font-bold text-sm">Support<br/>24/7</div>
                            </div>
                        </div>
                        @else
                            <button class="w-full bg-gray-400 text-white py-4 px-6 rounded-xl font-bold text-lg cursor-not-allowed">
                                <i class="fas fa-times-circle mr-3"></i>
                                PRODUIT TEMPORAIREMENT INDISPONIBLE
                            </button>
                        <button onclick="openWhatsAppModal({
                            id: {{ $product->id }},
                            name: '{{ addslashes($product->name) }}',
                                price: '{{ number_format($product->price, 0, '.', ' ') }}',
                            category: '{{ addslashes($product->category->name) }}',
                            slug: '{{ $product->slug }}',
                                image: '{{ $productImages && $productImages->count() > 0 ? $productImages->first()->getUrl() : '' }}',
                            clickTrackUrl: '{{ route('products.whatsapp-click', $product) }}'
                            })" class="w-full mt-3 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                ÊTRE NOTIFIÉ DU RETOUR EN STOCK
                        </button>
                        @endif
                    </div>

                    <!-- Témoignages clients -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="font-bold text-gray-800 mb-3">💬 CE QUE DISENT NOS CLIENTS</h4>
                        <div class="space-y-3">
                            <div class="bg-white p-3 rounded-lg shadow-sm">
                                <div class="flex items-center mb-2">
                                    <div class="text-yellow-400 text-sm">⭐⭐⭐⭐⭐</div>
                                    <span class="text-sm text-gray-600 ml-2">Konan A.</span>
                                </div>
                                <p class="text-gray-700 text-sm">"Excellent produit, livraison rapide. Je recommande LEBOSS TECH !"</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg shadow-sm">
                                <div class="flex items-center mb-2">
                                    <div class="text-yellow-400 text-sm">⭐⭐⭐⭐⭐</div>
                                    <span class="text-sm text-gray-600 ml-2">Marie K.</span>
                                </div>
                                <p class="text-gray-700 text-sm">"Très bon rapport qualité-prix. Service client au top !"</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Features -->
                    <div class="border-t pt-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-shipping-fast text-orange-600"></i>
                                </div>
                                <span class="text-sm font-medium">Livraison Rapide</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-shield-alt text-green-600"></i>
                                </div>
                                <span class="text-sm font-medium">Produit Garanti</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-headset text-orange-600"></i>
                                </div>
                                <span class="text-sm font-medium">Support 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="border-t">
                <div class="flex border-b">
                    <button class="tab-button active px-6 py-3 font-medium text-orange-600 border-b-2 border-orange-600" data-tab="description">
                        Description détaillée
                    </button>
                    @if($product->specifications)
                        <button class="tab-button px-6 py-3 font-medium text-gray-600 hover:text-orange-600" data-tab="specifications">
                            Spécifications
                        </button>
                    @endif
                    <button class="tab-button px-6 py-3 font-medium text-gray-600 hover:text-orange-600" data-tab="reviews">
                        Avis clients (127)
                    </button>
                </div>

                <div class="p-6">
                    <!-- Description Tab -->
                    <div id="description" class="tab-content">
                        <div class="prose max-w-none">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    @if($product->specifications)
                        <div id="specifications" class="tab-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($product->specifications as $key => $value)
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="font-medium text-gray-700">{{ $key }}:</span>
                                        <span class="text-gray-900">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-content hidden">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-orange-600">4.8</div>
                                    <div class="text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                                    <div class="text-sm text-gray-600">127 avis</div>
                                </div>
                                <div class="flex-1">
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <span class="text-sm w-12">5 ⭐</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 85%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">108</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm w-12">4 ⭐</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 12%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">15</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm w-12">3 ⭐</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 2%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">3</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm w-12">2 ⭐</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 1%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">1</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm w-12">1 ⭐</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 0%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Avis individuels -->
                            <div class="space-y-4">
                                <div class="border-b pb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold">Konan A.</span>
                                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                                        </div>
                                        <span class="text-sm text-gray-500">Il y a 2 jours</span>
                                    </div>
                                    <p class="text-gray-700">"Excellent produit, conforme à la description. Livraison ultra rapide, je recommande vivement LEBOSS TECH !"</p>
                                </div>
                                
                                <div class="border-b pb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold">Marie K.</span>
                                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                                        </div>
                                        <span class="text-sm text-gray-500">Il y a 5 jours</span>
                                    </div>
                                    <p class="text-gray-700">"Très bon rapport qualité-prix. L'équipe LEBOSS TECH est très professionnelle et le service client est au top !"</p>
                                </div>
                                
                                <div class="border-b pb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold">Yao B.</span>
                                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                                        </div>
                                        <span class="text-sm text-gray-500">Il y a 1 semaine</span>
                                    </div>
                                    <p class="text-gray-700">"Installation gratuite comme promis, technicien très compétent. Je suis très satisfait de mon achat !"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">🔥 Produits similaires - Offres spéciales</h2>
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                        Dernières pièces !
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all transform hover:scale-105 overflow-hidden border border-gray-200">
                            <div class="relative">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                    @if($relatedProduct->getFirstMediaUrl('images'))
                                        <img src="{{ $relatedProduct->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Badges produits similaires -->
                                <div class="absolute top-2 left-2">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">-20%</span>
                                </div>
                                
                                @if($relatedProduct->stock <= 0)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                        Rupture de stock
                                    </div>
                                @elseif($relatedProduct->stock <= 5)
                                    <div class="absolute top-2 right-2 bg-orange-500 text-white px-2 py-1 rounded text-xs font-semibold animate-pulse">
                                        Plus que {{ $relatedProduct->stock }} !
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="hover:text-orange-600 transition-colors">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        @php $relatedOriginalPrice = $relatedProduct->price * 1.2; @endphp
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($relatedOriginalPrice, 0, ',', ' ') }}</span>
                                        <span class="text-lg font-bold text-orange-600 block">{{ number_format($relatedProduct->price, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <div class="text-xs text-yellow-500">⭐ 4.{{ rand(6,9) }}</div>
                                </div>
                                <button onclick="openWhatsAppModal({
                                    id: {{ $relatedProduct->id }},
                                    name: '{{ addslashes($relatedProduct->name) }}',
                                    price: '{{ number_format($relatedProduct->price, 0, '.', ' ') }}',
                                    category: '{{ addslashes($relatedProduct->category->name) }}',
                                    slug: '{{ $relatedProduct->slug }}',
                                    image: '{{ $relatedProduct->getFirstMediaUrl('images', 'thumb') }}',
                                    clickTrackUrl: '{{ route('products.whatsapp-click', $relatedProduct) }}'
                                })" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-center py-2 rounded-lg transition-all transform hover:scale-105 text-sm font-bold">
                                    <i class="fab fa-whatsapp mr-1"></i> Commander rapidement
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
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

/* Styles pour la galerie d'images */
#mainImage {
    transition: transform 0.3s ease;
    background: white;
    position: relative;
    z-index: 10;
}

#mainImage:hover {
    transform: scale(1.02);
}

.thumbnail-btn {
    transition: all 0.3s ease;
}

.thumbnail-btn:hover {
    transform: scale(1.05);
}

/* Correction pour éviter les overlays */
.product-image-container {
    background: white;
    position: relative;
    overflow: hidden;
}

.product-image-container::before,
.product-image-container::after {
    display: none !important;
}

/* Supprimer tout pseudo-élément qui pourrait créer un cercle */
*::before,
*::after {
    border-radius: 0 !important;
}

/* Forcer l'affichage correct de l'image */
.main-product-image {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    background: transparent !important;
}

/* Animations marketing */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(239, 68, 68, 0.5);
    }
    50% {
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.8), 0 0 30px rgba(239, 68, 68, 0.6);
    }
}

.animate-pulse-glow {
    animation: pulse-glow 2s infinite;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out infinite;
}

/* Effet de brillance sur les prix */
@keyframes shine {
    0% { background-position: -200px 0; }
    100% { background-position: 200px 0; }
}

.price-shine {
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    background-size: 200px 100%;
    animation: shine 3s infinite;
}

/* Compteur de visiteurs animé */
@keyframes count-up {
    0% { transform: translateY(20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}

#viewCounter {
    animation: count-up 0.5s ease-out;
}

/* Bouton pulsant pour l'urgence */
.btn-urgent {
    animation: pulse 1.5s infinite;
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
}

.btn-urgent:hover {
    animation: none;
    transform: scale(1.05);
}

/* Badge flottant */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Effet de zoom sur les cartes produits */
.product-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Gradient animé pour les badges */
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Effet de notification */
.notification-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}

/* Texte clignotant pour les offres */
.blink-text {
    animation: blink 1.5s linear infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

/* Effet de survol sur les témoignages */
.testimonial-card {
    transition: all 0.3s ease;
}

.testimonial-card:hover {
    transform: translateX(5px);
    border-left: 4px solid #f59e0b;
}

/* Indicateur de stock critique */
.stock-critical {
    position: relative;
    overflow: hidden;
}

.stock-critical::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
    animation: stock-warning 2s infinite;
}

@keyframes stock-warning {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Timer countdown */
.countdown-timer {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: #dc2626;
    animation: countdown-blink 1s infinite;
}

@keyframes countdown-blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/product-marketing.js') }}"></script>
<script>
// Image gallery
const allImages = @json($productImages ? $productImages->map(function($media) {
    return [
        'main' => $media->getUrl(),
        'thumb' => $media->getUrl()
    ];
}) : []);

function changeImage(src, index) {
    document.getElementById('mainImage').src = src;
    document.getElementById('mainImage').onclick = function() { openImageModal(src); };
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('border-orange-500');
        thumb.classList.add('border-gray-200');
    });
    
    const activeThumb = document.querySelector(`[data-index="${index}"]`);
    if (activeThumb) {
        activeThumb.classList.add('border-orange-500');
        activeThumb.classList.remove('border-gray-200');
    }
}

// Modal pour affichage plein écran
function openImageModal(imageSrc) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full">
            <img src="${imageSrc}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain rounded-lg">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all">
                <i class="fas fa-times text-xl"></i>
            </button>
            ${allImages.length > 1 ? `
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2">
                    <div class="flex space-x-2 bg-black bg-opacity-50 p-2 rounded-lg">
                        ${allImages.map((img, idx) => `
                            <button onclick="changeModalImage('${img.main}', ${idx})" class="modal-thumb w-12 h-12 rounded border-2 border-gray-400 overflow-hidden hover:border-orange-400 transition-colors ${idx === 0 ? 'border-orange-500' : ''}">
                                <img src="${img.thumb}" alt="Miniature ${idx + 1}" class="w-full h-full object-cover">
                            </button>
                        `).join('')}
                    </div>
                </div>
            ` : ''}
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.querySelector('.fixed.inset-0');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function changeModalImage(src, index) {
    const modalImg = document.querySelector('.fixed.inset-0 img');
    if (modalImg) {
        modalImg.src = src;
    }
    
    // Update modal thumbnails
    const modalThumbs = document.querySelectorAll('.modal-thumb');
    modalThumbs.forEach((thumb, idx) => {
        if (idx === index) {
            thumb.classList.add('border-orange-500');
            thumb.classList.remove('border-gray-400');
        } else {
            thumb.classList.remove('border-orange-500');
            thumb.classList.add('border-gray-400');
        }
    });
}

// Tabs functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'text-orange-600', 'border-orange-600');
                btn.classList.add('text-gray-600');
            });
            
            // Add active class to clicked button
            this.classList.add('active', 'text-orange-600', 'border-orange-600');
            this.classList.remove('text-gray-600');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
    
    // Marketing animations
    setTimeout(() => {
        updateViewCounter();
    }, 1000);
    
    // Mise à jour du compteur de visiteurs
    setInterval(updateViewCounter, 15000);
    
    // Animation du timer countdown
    startCountdownTimer();
});

// Fonction pour mettre à jour le compteur de visiteurs
function updateViewCounter() {
    const counter = document.getElementById('viewCounter');
    if (counter) {
        const currentCount = parseInt(counter.textContent);
        const newCount = currentCount + Math.floor(Math.random() * 3) + 1;
        counter.textContent = newCount;
        
        // Animation de mise à jour
        counter.style.transform = 'scale(1.2)';
        counter.style.color = '#dc2626';
        setTimeout(() => {
            counter.style.transform = 'scale(1)';
            counter.style.color = '#b45309';
        }, 300);
    }
}

// Timer de compte à rebours pour l'offre limitée
function startCountdownTimer() {
    const timerElements = document.querySelectorAll('.countdown-timer');
    let hours = 23;
    let minutes = Math.floor(Math.random() * 60);
    let seconds = Math.floor(Math.random() * 60);
    
    setInterval(() => {
        seconds--;
        if (seconds < 0) {
            seconds = 59;
            minutes--;
            if (minutes < 0) {
                minutes = 59;
                hours--;
                if (hours < 0) {
                    hours = 23;
                    minutes = 59;
                    seconds = 59;
                }
            }
        }
        
        const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        timerElements.forEach(el => {
            if (el) el.textContent = timeString;
        });
    }, 1000);
}

// Effet de scintillement sur les badges promotionnels
setInterval(() => {
    const badges = document.querySelectorAll('.animate-pulse');
    badges.forEach(badge => {
        badge.style.transform = 'scale(1.05)';
        setTimeout(() => {
            badge.style.transform = 'scale(1)';
        }, 200);
    });
}, 3000);
</script>
@endpush 