@extends('layouts.admin')

@section('title', 'Modifier Produit - LEBOSS TECH ADMIN')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête amélioré -->
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
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Voir sur le site
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire avec onglets -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                
                <!-- Navigation par onglets -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button type="button" onclick="showTab('general')" class="tab-button active py-4 px-1 border-b-2 border-orange-500 font-medium text-sm text-orange-600" id="tab-general">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informations générales
                        </button>
                        <button type="button" onclick="showTab('price')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-price">
                            <i class="fas fa-tags mr-2"></i>
                            Prix & Stock
                        </button>
                        <button type="button" onclick="showTab('images')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-images">
                            <i class="fas fa-images mr-2"></i>
                            Images
                        </button>
                        <button type="button" onclick="showTab('specs')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-specs">
                            <i class="fas fa-cogs mr-2"></i>
                            Spécifications
                        </button>
                        <button type="button" onclick="showTab('seo')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-seo">
                            <i class="fas fa-search mr-2"></i>
                            SEO & Marketing
                        </button>
                        <button type="button" onclick="showTab('settings')" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-settings">
                            <i class="fas fa-sliders-h mr-2"></i>
                            Paramètres
                        </button>
                    </nav>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Informations de base -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom du produit -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-orange-500 mr-1"></i>
                                Nom du produit *
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $product->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                                   placeholder="Nom du produit">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-barcode text-orange-500 mr-1"></i>
                                SKU *
                            </label>
                            <input type="text" name="sku" id="sku" required
                                   value="{{ old('sku', $product->sku ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sku') border-red-500 @enderror"
                                   placeholder="Code produit unique">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left text-orange-500 mr-1"></i>
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                                  placeholder="Description détaillée du produit">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix et Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Prix -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave text-orange-500 mr-1"></i>
                                Prix (FCFA) *
                            </label>
                            <input type="number" name="price" id="price" required min="0" step="1"
                                   value="{{ old('price', $product->price ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 @enderror"
                                   placeholder="0">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-boxes text-orange-500 mr-1"></i>
                                Stock
                            </label>
                            <input type="number" name="stock" id="stock" min="0"
                                   value="{{ old('stock', $product->stock ?? 0) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('stock') border-red-500 @enderror"
                                   placeholder="0">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-folder text-orange-500 mr-1"></i>
                                Catégorie *
                            </label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Images existantes -->
                    @if(isset($product) && $product->getMedia('images')->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-images text-orange-500 mr-1"></i>
                                Images actuelles
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @foreach($product->getMedia('images') as $image)
                                    <div class="relative group">
                                        <img src="{{ $image->getUrl('thumb') }}" 
                                             alt="Image produit" 
                                             class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                        <button type="button" 
                                                onclick="removeImage({{ $image->id }})"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Nouvelles images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-images text-orange-500 mr-1"></i>
                            Ajouter de nouvelles images
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-500 transition-colors">
                            <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                            <label for="images" class="cursor-pointer">
                                <div class="space-y-2">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <div class="text-lg font-medium text-gray-600">Cliquez pour ajouter des images</div>
                                    <div class="text-sm text-gray-500">PNG, JPG, JPEG jusqu'à 5MB chacune</div>
                                </div>
                            </label>
                        </div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cogs text-orange-500 mr-2"></i>
                            Options du produit
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Produit actif -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', $product->is_active ?? 1) ? 'checked' : '' }}
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                                    <i class="fas fa-eye text-green-500 mr-1"></i>
                                    Produit actif (visible sur le site)
                                </label>
                            </div>

                            <!-- Produit en vedette -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured ?? 0) ? 'checked' : '' }}
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">
                                    <i class="fas fa-star text-orange-500 mr-1"></i>
                                    Produit en vedette
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Prévisualisation des images
document.getElementById('images').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.createElement('div');
    preview.className = 'mt-4 grid grid-cols-2 md:grid-cols-4 gap-4';
    
    // Supprimer l'ancienne prévisualisation
    const oldPreview = document.querySelector('.image-preview');
    if (oldPreview) oldPreview.remove();
    
    if (files.length > 0) {
        preview.classList.add('image-preview');
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200';
                    
                    const container = document.createElement('div');
                    container.className = 'relative';
                    container.appendChild(img);
                    
                    preview.appendChild(container);
                };
                reader.readAsDataURL(file);
            }
        });
        
        e.target.parentNode.parentNode.appendChild(preview);
    }
});

// Suppression d'images existantes
function removeImage(imageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        // Créer un input hidden pour marquer l'image à supprimer
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = imageId;
        document.querySelector('form').appendChild(input);
        
        // Masquer l'image visuellement
        event.target.closest('.relative').style.opacity = '0.5';
        event.target.closest('.relative').style.pointerEvents = 'none';
    }
}
</script>
@endsection 