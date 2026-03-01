<div class="max-h-[80vh] overflow-y-auto">
    <div class="bg-white rounded-lg">
        @if($products->count() >= 2)
            <!-- Comparison Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50">
                                Caractéristiques
                            </th>
                            @foreach($products as $product)
                                <th class="px-4 py-3 text-center min-w-64">
                                    <div class="space-y-2">
                                        @if($product->getFirstMediaUrl('images'))
                                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-20 h-20 object-cover rounded-lg mx-auto">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg mx-auto flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm line-clamp-2">{{ $product->name }}</h3>
                                            <p class="text-xs text-blue-600">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Prix -->
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white">Prix</td>
                            @foreach($products as $product)
                                <td class="px-4 py-3 text-center">
                                    <span class="text-2xl font-bold text-blue-600">
                                        {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Stock -->
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-gray-50">Disponibilité</td>
                            @foreach($products as $product)
                                <td class="px-4 py-3 text-center">
                                    @if($product->stock > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            En stock ({{ $product->stock }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Rupture de stock
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        <!-- SKU -->
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white">SKU</td>
                            @foreach($products as $product)
                                <td class="px-4 py-3 text-center text-sm text-gray-600">
                                    {{ $product->sku ?: 'N/A' }}
                                </td>
                            @endforeach
                        </tr>

                        <!-- Description -->
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-gray-50">Description</td>
                            @foreach($products as $product)
                                <td class="px-4 py-3 text-center">
                                    <p class="text-sm text-gray-600 line-clamp-3">
                                        {{ $product->short_description }}
                                    </p>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Spécifications -->
                        @if($products->where('specifications', '!=', null)->count() > 0)
                            @php
                                $allSpecs = collect();
                                foreach($products as $product) {
                                    if($product->specifications && is_array($product->specifications)) {
                                        $allSpecs = $allSpecs->merge(array_keys($product->specifications));
                                    }
                                }
                                $uniqueSpecs = $allSpecs->unique()->take(5);
                            @endphp

                            @foreach($uniqueSpecs as $specKey)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                        {{ $specKey }}
                                    </td>
                                    @foreach($products as $product)
                                        <td class="px-4 py-3 text-center text-sm text-gray-600">
                                            {{ $product->specifications[$specKey] ?? 'N/A' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif

                        <!-- Actions -->
                        <tr class="bg-blue-50">
                            <td class="px-4 py-4 font-medium text-gray-900 sticky left-0 bg-blue-50">Actions</td>
                            @foreach($products as $product)
                                <td class="px-4 py-4 text-center">
                                    <div class="space-y-2">
                                        <button onclick="quickOrderFromCompare({{ $product->id }})" 
                                                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                            <i class="fab fa-whatsapp mr-1"></i> Commander
                                        </button>
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                            Voir détails
                                        </a>
                                        <button onclick="removeFromCompare({{ $product->id }})" 
                                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-1 px-3 rounded text-xs">
                                            Retirer
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-3">Résumé de la comparaison</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Prix le plus bas:</span>
                        @php $cheapest = $products->sortBy('price')->first(); @endphp
                        <p class="text-green-600 font-semibold">
                            {{ $cheapest->name }} - {{ number_format($cheapest->price, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Le plus cher:</span>
                        @php $expensive = $products->sortByDesc('price')->first(); @endphp
                        <p class="text-red-600 font-semibold">
                            {{ $expensive->name }} - {{ number_format($expensive->price, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Disponibles:</span>
                        <p class="text-blue-600 font-semibold">
                            {{ $products->where('stock', '>', 0)->count() }}/{{ $products->count() }} produits
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Not enough products -->
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-balance-scale text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pas assez de produits</h3>
                <p class="text-gray-600 mb-4">Ajoutez au moins 2 produits pour commencer la comparaison.</p>
                <button onclick="toggleCompareMode()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Continuer les achats
                </button>
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
function quickOrderFromCompare(productId) {
    // Similaire à la fonction d'aperçu rapide
    fetch(`/products/${productId}/whatsapp-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
    .then(data => {
        if(data.whatsapp_url) {
            window.open(data.whatsapp_url, '_blank');
        }
    });
}

function removeFromCompare(productId) {
    toggleCompare(productId);
    // Recharger la comparaison
    setTimeout(() => {
        loadCompare();
    }, 300);
}
</script> 