<div class="max-h-[70vh] overflow-y-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Image Section -->
        <div class="space-y-4">
            @if($product->getFirstMediaUrl('images'))
                <div class="aspect-w-1 aspect-h-1">
                    <img src="{{ $product->getFirstMediaUrl('images', 'main') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-80 object-cover rounded-lg">
                </div>
            @else
                <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-6xl"></i>
                </div>
            @endif
            
            @if($product->getMedia('images')->count() > 1)
                <div class="flex space-x-2 overflow-x-auto">
                    @foreach($product->getMedia('images')->take(4) as $media)
                        <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border border-gray-200">
                            <img src="{{ $media->getUrl('thumb') }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="space-y-4">
            <!-- Category -->
            <div>
                <span class="text-sm text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded">
                    {{ $product->category->name }}
                </span>
            </div>
            
            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
            
            <!-- Price & Stock -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-3xl font-bold text-blue-600">
                        {{ number_format($product->price, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                    </span>
                    @if($product->sku)
                        <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                    @endif
                </div>
                
                @if($product->stock > 0)
                    <div class="flex items-center text-green-600">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="font-semibold">En stock ({{ $product->stock }} disponible{{ $product->stock > 1 ? 's' : '' }})</span>
                    </div>
                @else
                    <div class="flex items-center text-red-600">
                        <i class="fas fa-times-circle mr-2"></i>
                        <span class="font-semibold">Rupture de stock</span>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
            </div>

            <!-- Key Features -->
            @if($product->specifications && is_array($product->specifications))
                <div>
                    <h3 class="text-lg font-semibold mb-2">Caractéristiques principales</h3>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach(array_slice($product->specifications, 0, 4) as $key => $value)
                            <div class="flex justify-between py-1 text-sm">
                                <span class="font-medium text-gray-600">{{ $key }}:</span>
                                <span class="text-gray-900">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-3 pt-4 border-t">
                <button onclick="quickWhatsAppOrder({{ $product->id }})" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    <i class="fab fa-whatsapp mr-2 text-lg"></i>
                    Commander via WhatsApp
                </button>
                
                <div class="flex space-x-2">
                    <a href="{{ route('products.show', $product->slug) }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium text-center transition-colors">
                        Voir tous les détails
                    </a>
                    <button onclick="toggleFavorite({{ $product->id }})" 
                            class="px-4 py-2 bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-500 rounded-lg transition-colors">
                        <i class="fas fa-heart"></i>
                    </button>
                    <button onclick="toggleCompare({{ $product->id }})" 
                            class="px-4 py-2 bg-gray-100 hover:bg-purple-50 text-gray-600 hover:text-purple-500 rounded-lg transition-colors">
                        <i class="fas fa-balance-scale"></i>
                    </button>
                </div>
            </div>

            <!-- Product Features -->
            <div class="grid grid-cols-3 gap-4 pt-4 border-t text-center">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-shipping-fast text-blue-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Livraison Rapide</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Garanti</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-headset text-purple-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Support 24/7</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function quickWhatsAppOrder(productId) {
    // Récupérer l'URL WhatsApp du produit et l'ouvrir
    fetch(`/products/${productId}/whatsapp-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    }).then(() => {
        // Ouvrir WhatsApp
        window.open('{{ $product->whatsapp_url }}', '_blank');
        // Fermer le modal
        closeQuickView();
    });
}
</script> 