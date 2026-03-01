@extends('layouts.admin')

@section('title', 'Détails Produit - LEBOSS TECH ADMIN')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-eye text-orange-500 mr-3"></i>
                        Détails du produit
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $product->name ?? 'Produit' }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.edit', $product ?? 1) }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informations générales -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-orange-50 border-b border-orange-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                            Informations générales
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nom du produit</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $product->name ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">SKU</label>
                                <p class="text-lg font-mono text-gray-900 bg-gray-100 px-3 py-1 rounded">{{ $product->sku ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Catégorie</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-folder mr-1"></i>
                                    {{ $product->category->name ?? 'Non définie' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Date de création</label>
                                <p class="text-lg text-gray-900">{{ isset($product) ? $product->created_at->format('d/m/Y à H:i') : 'Non définie' }}</p>
                            </div>
                        </div>
                        
                        @if(isset($product) && $product->description)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-900 leading-relaxed">{{ $product->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Images du produit -->
                @if(isset($product) && $product->getMedia('images')->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-orange-50 border-b border-orange-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-images text-orange-500 mr-2"></i>
                                Images du produit ({{ $product->getMedia('images')->count() }})
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($product->getMedia('images') as $image)
                                    <div class="relative group">
                                        <img src="{{ $image->getUrl() }}" 
                                             alt="Image produit" 
                                             class="w-full h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity"
                                             onclick="openImageModal('{{ $image->getUrl() }}')">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-lg flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-orange-50 border-b border-orange-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-images text-orange-500 mr-2"></i>
                                Images du produit
                            </h3>
                        </div>
                        <div class="p-6 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-image text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Aucune image disponible</p>
                                <p class="text-sm">Ajoutez des images en modifiant le produit</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-6">
                <!-- Statistiques -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-orange-50 border-b border-orange-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar text-orange-500 mr-2"></i>
                            Statistiques
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Prix -->
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Prix</p>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($product->price ?? 0, 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-boxes text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Stock disponible</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $product->stock ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Statut</span>
                                @if(isset($product) && $product->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-eye-slash mr-1"></i>
                                        Inactif
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">En vedette</span>
                                @if(isset($product) && $product->is_featured)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Oui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-star-o mr-1"></i>
                                        Non
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-orange-50 border-b border-orange-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-bolt text-orange-500 mr-2"></i>
                            Actions rapides
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.products.edit', $product ?? 1) }}" 
                           class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier le produit
                        </a>
                        
                        @if(isset($product))
                            <a href="{{ route('products.show', $product) }}" target="_blank"
                               class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Voir sur le site
                            </a>
                        @endif
                        
                        <button onclick="duplicateProduct()" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                            <i class="fas fa-copy mr-2"></i>
                            Dupliquer
                        </button>
                        
                        <button onclick="deleteProduct()" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'image -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-full p-4">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Image produit" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

<script>
function openImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function duplicateProduct() {
    if (confirm('Êtes-vous sûr de vouloir dupliquer ce produit ?')) {
        // Logique de duplication (à implémenter côté serveur)
        alert('Fonctionnalité de duplication en cours de développement');
    }
}

function deleteProduct() {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
        // Logique de suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.products.destroy", $product ?? 1) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Fermer le modal avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection 