@extends('layouts.admin')

@section('title', 'Modifier le Slider - LEBOSS TECH ADMIN')

@push('styles')
<link href="{{ asset('css/slider-admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="slider-create-container">
    <!-- En-tête moderne -->
    <div class="page-header animate-fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="page-title flex items-center">
                    <i class="fas fa-edit text-purple-500 mr-4"></i>
                    Modifier le Slider
                </h1>
                <p class="text-gray-600 text-lg">
                    Modifiez votre bannière "{{ $slider->title }}"
                </p>
                <div class="flex items-center mt-3 text-sm text-gray-500 space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        Créé le {{ $slider->created_at->format('d/m/Y à H:i') }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-{{ $slider->is_active ? 'eye text-green-500' : 'eye-slash text-red-500' }} mr-2"></i>
                        {{ $slider->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.sliders.index') }}" 
                   class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                <button type="button" 
                        onclick="previewSlider({{ $slider->id }})"
                        class="btn-tertiary">
                    <i class="fas fa-eye mr-2"></i>
                    Aperçu
                </button>
            </div>
        </div>
    </div>

    <!-- Formulaire principal -->
    <div class="form-container animate-fade-in-up" style="animation-delay: 0.1s;">
        <form action="{{ route('admin.sliders.update', $slider) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              id="sliderForm"
              class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section Image (principale) -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-image text-purple-500 mr-3"></i>
                        Image du Slider
                    </h2>
                    <p class="section-description">
                        Modifiez l'image principale de votre slider (optionnel)
                    </p>
                </div>

                <div class="image-upload-area" id="imageUploadArea">
                    @php
                        $currentImageUrl = null;
                        // Priorité 1 : Media Library avec conversion
                        if ($slider->hasMedia('banners')) {
                            $currentImageUrl = $slider->getFirstMediaUrl('banners', 'banner');
                        }
                        // Priorité 2 : Stockage direct
                        elseif ($slider->image) {
                            $currentImageUrl = asset($slider->image);
                        }
                    @endphp

                    @if($currentImageUrl)
                        <div class="current-image-container">
                            <div class="current-image-header">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Image actuelle</h4>
                                <button type="button" 
                                        onclick="showImageUpload()" 
                                        class="btn-sm btn-secondary">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Changer l'image
                                </button>
                            </div>
                            <div class="current-image-preview">
                                <img src="{{ $currentImageUrl }}" 
                                     alt="{{ $slider->title }}" 
                                     class="current-image">
                                <div class="image-overlay">
                                    <button type="button" 
                                            onclick="showImageUpload()" 
                                            class="overlay-btn">
                                        <i class="fas fa-edit"></i>
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="upload-replacement" id="uploadReplacement" style="display: none;">
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h3 class="upload-title">Nouvelle image</h3>
                                <p class="upload-description">
                                    Glissez votre nouvelle image ici ou 
                                    <button type="button" class="upload-link" onclick="document.getElementById('imageInput').click()">parcourez vos fichiers</button>
                                </p>
                                <div class="upload-specs">
                                    <span class="spec-item">JPG, PNG, GIF</span>
                                    <span class="spec-item">Max 5MB</span>
                                    <span class="spec-item">1920x800px recommandé</span>
                                </div>
                            </div>
                            
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImage" src="" alt="Aperçu" class="preview-img">
                                <div class="preview-overlay">
                                    <button type="button" class="preview-btn" onclick="changeImage()">
                                        <i class="fas fa-edit"></i>
                                        Changer
                                    </button>
                                    <button type="button" class="preview-btn delete" onclick="cancelImageChange()">
                                        <i class="fas fa-times"></i>
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h3 class="upload-title">Ajouter une image</h3>
                            <p class="upload-description">
                                Glissez votre image ici ou 
                                <button type="button" class="upload-link" onclick="document.getElementById('imageInput').click()">parcourez vos fichiers</button>
                            </p>
                            <div class="upload-specs">
                                <span class="spec-item">JPG, PNG, GIF</span>
                                <span class="spec-item">Max 5MB</span>
                                <span class="spec-item">1920x800px recommandé</span>
                            </div>
                        </div>
                        
                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <img id="previewImage" src="" alt="Aperçu" class="preview-img">
                            <div class="preview-overlay">
                                <button type="button" class="preview-btn" onclick="changeImage()">
                                    <i class="fas fa-edit"></i>
                                    Changer
                                </button>
                                <button type="button" class="preview-btn delete" onclick="removeImage()">
                                    <i class="fas fa-trash"></i>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" 
                           name="image" 
                           id="imageInput" 
                           accept="image/*" 
                           class="hidden">
                </div>
                
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                
                <div class="input-helper mt-2">
                    <i class="fas fa-info-circle text-blue-400 mr-1"></i>
                    <span class="text-sm text-gray-500">
                        Laissez vide pour conserver l'image actuelle
                    </span>
                </div>
            </div>

            <!-- Section Contenu -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-edit text-blue-500 mr-3"></i>
                        Contenu du Slider
                    </h2>
                    <p class="section-description">
                        Modifiez le texte et les actions de votre slider
                    </p>
                </div>

                <div class="form-grid">
                    <!-- Titre -->
                    <div class="form-group col-span-2">
                        <label for="title" class="form-label required">Titre principal</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $slider->title) }}"
                               class="form-input @error('title') error @enderror" 
                               placeholder="ex: Découvrez nos nouveaux produits"
                               required>
                        <div class="input-helper">
                            <span class="char-counter">
                                <span id="titleCount">{{ strlen($slider->title) }}</span>/60 caractères
                            </span>
                        </div>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sous-titre -->
                    <div class="form-group col-span-2">
                        <label for="subtitle" class="form-label">Sous-titre</label>
                        <textarea name="subtitle" 
                                  id="subtitle" 
                                  rows="3"
                                  class="form-input @error('subtitle') error @enderror"
                                  placeholder="Description détaillée ou slogan accrocheur...">{{ old('subtitle', $slider->subtitle) }}</textarea>
                        <div class="input-helper">
                            <span class="char-counter">
                                <span id="subtitleCount">{{ strlen($slider->subtitle ?? '') }}</span>/150 caractères
                            </span>
                        </div>
                        @error('subtitle')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Texte du bouton -->
                    <div class="form-group">
                        <label for="button_text" class="form-label">Texte du bouton</label>
                        <input type="text" 
                               name="button_text" 
                               id="button_text" 
                               value="{{ old('button_text', $slider->button_text) }}"
                               class="form-input @error('button_text') error @enderror" 
                               placeholder="ex: Voir les produits">
                        @error('button_text')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lien du bouton -->
                    <div class="form-group">
                        <label for="button_link" class="form-label">Lien du bouton</label>
                        <input type="url" 
                               name="button_link" 
                               id="button_link" 
                               value="{{ old('button_link', $slider->button_link) }}"
                               class="form-input @error('button_link') error @enderror" 
                               placeholder="https://exemple.com">
                        @error('button_link')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section Configuration -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-cog text-green-500 mr-3"></i>
                        Configuration
                    </h2>
                    <p class="section-description">
                        Paramètres d'affichage et d'ordre
                    </p>
                </div>

                <div class="form-grid">
                    <!-- Ordre -->
                    <div class="form-group">
                        <label for="order" class="form-label required">Ordre d'affichage</label>
                        <input type="number" 
                               name="order" 
                               id="order" 
                               value="{{ old('order', $slider->order) }}"
                               min="1" 
                               max="100"
                               class="form-input @error('order') error @enderror" 
                               required>
                        <div class="input-helper">
                            <i class="fas fa-info-circle text-blue-400 mr-1"></i>
                            <span class="text-sm text-gray-500">
                                Plus le numéro est petit, plus le slider apparaît en premier
                            </span>
                        </div>
                        @error('order')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label class="form-label">Statut</label>
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" 
                                       name="is_active" 
                                       {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">Activer ce slider</span>
                        </div>
                        <div class="input-helper">
                            <i class="fas fa-eye text-green-400 mr-1"></i>
                            <span class="text-sm text-gray-500">
                                Les sliders actifs sont visibles sur le site
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aperçu en temps réel -->
            <div class="form-section" id="previewSection">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-eye text-indigo-500 mr-3"></i>
                        Aperçu du Slider
                    </h2>
                    <p class="section-description">
                        Voici comment votre slider apparaîtra sur le site
                    </p>
                </div>

                <div class="slider-preview-container">
                    <div class="slider-preview-item">
                        <div class="preview-image-container">
                            <img id="livePreviewImage" 
                                 src="{{ $currentImageUrl ?? '' }}" 
                                 alt="Aperçu" 
                                 class="preview-slider-image">
                            <div class="preview-content">
                                <h3 id="livePreviewTitle" class="preview-title">{{ $slider->title }}</h3>
                                <p id="livePreviewSubtitle" class="preview-subtitle">{{ $slider->subtitle }}</p>
                                <div id="livePreviewButton" 
                                     class="preview-button" 
                                     style="{{ $slider->button_text ? 'display: block;' : 'display: none;' }}">
                                    <span id="livePreviewButtonText">{{ $slider->button_text }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <div class="flex items-center justify-between">
                    <div class="form-info">
                        <i class="fas fa-lightbulb text-yellow-400 mr-2"></i>
                        <span class="text-sm text-gray-500">
                            Les modifications seront appliquées immédiatement
                        </span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.sliders.index') }}" 
                           class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        
                        <button type="button" 
                                onclick="toggleSliderStatus({{ $slider->id }}, !{{ $slider->is_active ? 'true' : 'false' }})"
                                class="btn-tertiary">
                            <i class="fas fa-{{ $slider->is_active ? 'eye-slash' : 'eye' }} mr-2"></i>
                            {{ $slider->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                        
                        <button type="submit" 
                                class="btn-primary" 
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span id="submitText">Sauvegarder les modifications</span>
                            <i class="fas fa-spinner fa-spin ml-2 hidden" id="submitSpinner"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/slider-admin.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('sliderForm');
    const imageInput = document.getElementById('imageInput');
    const uploadArea = document.getElementById('imageUploadArea');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const livePreviewImage = document.getElementById('livePreviewImage');
    const uploadReplacement = document.getElementById('uploadReplacement');
    
    // Éléments pour l'aperçu en temps réel
    const titleInput = document.getElementById('title');
    const subtitleInput = document.getElementById('subtitle');
    const buttonTextInput = document.getElementById('button_text');
    const livePreviewTitle = document.getElementById('livePreviewTitle');
    const livePreviewSubtitle = document.getElementById('livePreviewSubtitle');
    const livePreviewButton = document.getElementById('livePreviewButton');
    const livePreviewButtonText = document.getElementById('livePreviewButtonText');
    
    // Compteurs de caractères
    const titleCount = document.getElementById('titleCount');
    const subtitleCount = document.getElementById('subtitleCount');

    // Gestion du drag & drop
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleImageUpload(files[0]);
            }
        });
    }

    // Gestion de l'upload classique
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleImageUpload(e.target.files[0]);
            }
        });
    }

    // Fonction de gestion de l'upload
    function handleImageUpload(file) {
        // Validation du fichier
        if (!file.type.startsWith('image/')) {
            showNotification('Veuillez sélectionner un fichier image valide.', 'error');
            return;
        }

        if (file.size > 5 * 1024 * 1024) { // 5MB
            showNotification('L\'image ne peut pas dépasser 5 MB.', 'error');
            return;
        }

        // Lecture du fichier
        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImage) previewImage.src = e.target.result;
            if (livePreviewImage) livePreviewImage.src = e.target.result;
            
            if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
            if (imagePreview) imagePreview.style.display = 'block';
            
            updateLivePreview();
        };
        reader.readAsDataURL(file);
    }

    // Mise à jour de l'aperçu en temps réel
    function updateLivePreview() {
        if (livePreviewTitle) livePreviewTitle.textContent = titleInput.value || 'Titre du slider';
        if (livePreviewSubtitle) livePreviewSubtitle.textContent = subtitleInput.value || 'Sous-titre du slider';
        
        if (buttonTextInput.value) {
            if (livePreviewButton) livePreviewButton.style.display = 'block';
            if (livePreviewButtonText) livePreviewButtonText.textContent = buttonTextInput.value;
        } else {
            if (livePreviewButton) livePreviewButton.style.display = 'none';
        }
    }

    // Écouteurs pour l'aperçu en temps réel
    if (titleInput) {
        titleInput.addEventListener('input', function() {
            updateCharCount(this, titleCount, 60);
            updateLivePreview();
        });
    }

    if (subtitleInput) {
        subtitleInput.addEventListener('input', function() {
            updateCharCount(this, subtitleCount, 150);
            updateLivePreview();
        });
    }

    if (buttonTextInput) {
        buttonTextInput.addEventListener('input', updateLivePreview);
    }

    // Fonction de comptage des caractères
    function updateCharCount(input, counter, max) {
        if (!counter) return;
        
        const count = input.value.length;
        counter.textContent = count;
        
        if (count > max * 0.8) {
            counter.parentElement.classList.add('warning');
        } else {
            counter.parentElement.classList.remove('warning');
        }
    }

    // Soumission du formulaire
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            
            if (submitBtn) submitBtn.disabled = true;
            if (submitText) submitText.textContent = 'Sauvegarde en cours...';
            if (submitSpinner) submitSpinner.classList.remove('hidden');
        });
    }

    // Fonctions globales
    window.showImageUpload = function() {
        if (uploadReplacement) uploadReplacement.style.display = 'block';
        document.querySelector('.current-image-container').style.display = 'none';
    };

    window.cancelImageChange = function() {
        if (uploadReplacement) uploadReplacement.style.display = 'none';
        document.querySelector('.current-image-container').style.display = 'block';
        if (imageInput) imageInput.value = '';
        if (uploadPlaceholder) uploadPlaceholder.style.display = 'block';
        if (imagePreview) imagePreview.style.display = 'none';
    };

    window.changeImage = function() {
        if (imageInput) imageInput.click();
    };

    window.removeImage = function() {
        if (imageInput) imageInput.value = '';
        if (uploadPlaceholder) uploadPlaceholder.style.display = 'block';
        if (imagePreview) imagePreview.style.display = 'none';
    };

    // Fonctions pour les actions
    window.toggleSliderStatus = function(sliderId, isActive) {
        fetch(`/admin/sliders/${sliderId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_active: isActive })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification('Erreur lors de la mise à jour.', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur de connexion.', 'error');
        });
    };

    window.previewSlider = function(sliderId) {
        fetch(`/admin/sliders/${sliderId}/preview`)
        .then(response => response.json())
        .then(data => {
            // Implémenter la logique d'aperçu
            console.log('Aperçu du slider:', data);
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    };

    // Notification système
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endpush
@endsection 