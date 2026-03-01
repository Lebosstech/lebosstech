// ============================================
// LEBOSS TECH - Création de Produits - JS
// ============================================

// Gestion avancée de la création de produits
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 LEBOSS TECH Product Creator - Initialisation...');
    
    const tabs = ['general', 'pricing', 'media', 'specifications', 'seo', 'preview'];
    let currentTab = 0;
    let selectedImages = [];
    let uploadedFiles = [];

    // ==========================================
    // GESTION DES ONGLETS
    // ==========================================
    
    // Navigation des onglets
    document.querySelectorAll('.tab-button').forEach((button, index) => {
        button.addEventListener('click', () => showTab(index));
    });

    function showTab(index) {
        // Masquer tous les onglets
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });

        // Afficher l'onglet sélectionné
        const targetTab = document.getElementById(tabs[index] + '-tab');
        if (targetTab) {
            targetTab.classList.remove('hidden');
            targetTab.classList.add('fade-in');
        }
        
        const activeButton = document.querySelectorAll('.tab-button')[index];
        if (activeButton) {
            activeButton.classList.add('active');
        }
        
        currentTab = index;
        updateNavigationButtons();
        updateProgressBar();
        
        // Mettre à jour l'aperçu si on arrive sur l'onglet preview
        if (tabs[index] === 'preview') {
            updatePreview();
        }
        
        console.log(`📂 Onglet actif: ${tabs[index]}`);
    }

    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prevTab');
        const nextBtn = document.getElementById('nextTab');
        const submitBtn = document.getElementById('submitBtn');

        if (prevBtn) prevBtn.style.display = currentTab > 0 ? 'flex' : 'none';
        
        if (currentTab === tabs.length - 1) {
            if (nextBtn) nextBtn.style.display = 'none';
            if (submitBtn) submitBtn.style.display = 'flex';
        } else {
            if (nextBtn) nextBtn.style.display = 'flex';
            if (submitBtn) submitBtn.style.display = 'none';
        }
    }

    function updateProgressBar() {
        const progressBar = document.getElementById('progressBar');
        if (progressBar) {
            const progress = ((currentTab + 1) / tabs.length) * 100;
            progressBar.style.width = progress + '%';
        }
    }

    // Navigation avec boutons
    const nextTabBtn = document.getElementById('nextTab');
    const prevTabBtn = document.getElementById('prevTab');
    
    if (nextTabBtn) {
        nextTabBtn.addEventListener('click', () => {
            if (currentTab < tabs.length - 1) {
                showTab(currentTab + 1);
            }
        });
    }

    if (prevTabBtn) {
        prevTabBtn.addEventListener('click', () => {
            if (currentTab > 0) {
                showTab(currentTab - 1);
            }
        });
    }

    // ==========================================
    // COMPTEURS DE CARACTÈRES AMÉLIORÉS
    // ==========================================
    
    function setupCharCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        if (input && counter) {
            const updateCounter = () => {
                const length = input.value.length;
                counter.textContent = length + '/' + maxLength;
                
                // Animation et couleur selon le pourcentage
                const percentage = (length / maxLength) * 100;
                
                if (percentage > 90) {
                    counter.className = 'text-sm text-red-500 font-bold animate-pulse';
                } else if (percentage > 70) {
                    counter.className = 'text-sm text-yellow-500 font-semibold';
                } else {
                    counter.className = 'text-sm text-gray-400';
                }
                
                // Animation de validation
                if (length > 0) {
                    input.classList.add('ring-2', 'ring-green-200');
                } else {
                    input.classList.remove('ring-2', 'ring-green-200');
                }
            };
            
            input.addEventListener('input', updateCounter);
            updateCounter(); // Initialiser
        }
    }

    setupCharCounter('name', 'nameCounter', 255);
    setupCharCounter('short_description', 'shortDescCounter', 500);
    setupCharCounter('meta_title', 'metaTitleCounter', 60);
    setupCharCounter('meta_description', 'metaDescCounter', 160);

    // ==========================================
    // GÉNÉRATION SKU INTELLIGENTE
    // ==========================================
    
    const generateSKUBtn = document.getElementById('generateSKU');
    if (generateSKUBtn) {
        generateSKUBtn.addEventListener('click', function() {
            const sku = 'LBT-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            const skuField = document.getElementById('sku');
            if (skuField) {
                skuField.value = sku;
                showNotification('SKU généré automatiquement', 'success');
            }
        });
    }

    // Auto-génération du SKU basé sur le nom
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            const skuField = document.getElementById('sku');
            if (skuField && !skuField.value) {
                const name = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 6);
                const random = Math.random().toString(36).substr(2, 4).toUpperCase();
                skuField.value = 'LBT-' + name + '-' + random;
            }
            updatePreview();
        });
    }

    // ==========================================
    // ÉDITEUR WYSIWYG AMÉLIORÉ
    // ==========================================
    
    const editor = document.getElementById('editor');
    const descriptionField = document.getElementById('description');

    if (editor && descriptionField) {
        // Synchroniser l'éditeur avec le champ caché
        editor.addEventListener('input', function() {
            descriptionField.value = this.innerHTML;
            updatePreview();
        });

        // Boutons de l'éditeur
        document.querySelectorAll('.editor-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');
                document.execCommand(action, false, null);
                editor.focus();
                
                // Animation du bouton
                this.classList.add('scale-95');
                setTimeout(() => this.classList.remove('scale-95'), 150);
            });
        });

        // Placeholder intelligent pour l'éditeur
        editor.addEventListener('focus', function() {
            if (this.innerHTML.includes('color: #9CA3AF')) {
                this.innerHTML = '';
            }
        });

        editor.addEventListener('blur', function() {
            if (this.textContent.trim() === '') {
                this.innerHTML = '<p style="color: #9CA3AF; font-style: italic;">Décrivez votre produit en détail...</p>';
            }
        });

        // Initialiser l'éditeur
        if (editor.textContent.trim() === '') {
            editor.innerHTML = '<p style="color: #9CA3AF; font-style: italic;">Décrivez votre produit en détail...</p>';
        }
    }

    // ==========================================
    // GESTION AVANCÉE DES IMAGES
    // ==========================================
    
    const dropZone = document.getElementById('imageDropZone');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    const previewSection = document.getElementById('imagePreviewSection');

    if (dropZone && fileInput) {
        console.log('🖼️ Initialisation du gestionnaire d\'images...');
        
        // Drag and drop avec animations
        dropZone.addEventListener('dragover', handleDragOver);
        dropZone.addEventListener('dragleave', handleDragLeave);
        dropZone.addEventListener('drop', handleDrop);
        
        // File input change
        fileInput.addEventListener('change', handleFileSelect);
        
        // Boutons de gestion des images
        const selectAllBtn = document.getElementById('selectAllImages');
        const removeSelectedBtn = document.getElementById('removeSelectedImages');
        const toggleStockBtn = document.getElementById('toggleStockImages');
        
        if (selectAllBtn) selectAllBtn.addEventListener('click', selectAllImages);
        if (removeSelectedBtn) removeSelectedBtn.addEventListener('click', removeSelectedImages);
        if (toggleStockBtn) toggleStockBtn.addEventListener('click', toggleStockImages);
    }

    function handleDragOver(e) {
        e.preventDefault();
        dropZone.classList.add('drag-over');
        showNotification('Relâchez pour télécharger', 'info');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
    }

    function handleDrop(e) {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        
        const files = Array.from(e.dataTransfer.files);
        processFiles(files);
        showNotification('Fichiers détectés, traitement en cours...', 'info');
    }

    function handleFileSelect(e) {
        const files = Array.from(e.target.files);
        processFiles(files);
    }

    function processFiles(files) {
        const validFiles = files.filter(file => file.type.startsWith('image/'));
        
        if (validFiles.length === 0) {
            showNotification('❌ Aucune image valide sélectionnée', 'error');
            return;
        }

        console.log(`📤 Traitement de ${validFiles.length} images...`);
        
        let processedCount = 0;
        
        validFiles.forEach(file => {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                showNotification(`⚠️ Image ${file.name} trop volumineuse (max 5MB)`, 'warning');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                addImageToPreview(e.target.result, file.name, file);
                processedCount++;
                
                if (processedCount === validFiles.length) {
                    showNotification(`✅ ${processedCount} image(s) ajoutée(s) avec succès`, 'success');
                }
            };
            reader.readAsDataURL(file);
        });

        // Afficher la section de prévisualisation avec animation
        if (previewSection) {
            previewSection.style.display = 'block';
            previewSection.classList.add('fade-in');
        }
        updateImageCount();
    }

    function addImageToPreview(src, name, file) {
        const imageId = 'image_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        
        const imageCard = document.createElement('div');
        imageCard.className = 'image-preview-card fade-in';
        imageCard.dataset.imageId = imageId;
        imageCard.innerHTML = `
            <div class="relative h-full">
                <img src="${src}" alt="${name}" class="w-full h-full object-cover">
                <div class="image-preview-overlay">
                    <button type="button" class="image-action-btn star" onclick="setMainImage('${imageId}')" title="Définir comme image principale">
                        <i class="fas fa-star"></i>
                    </button>
                    <button type="button" class="image-action-btn" onclick="editImage('${imageId}')" title="Éditer l'image">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="image-action-btn delete" onclick="removeImage('${imageId}')" title="Supprimer l'image">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="absolute top-2 left-2">
                    <input type="checkbox" class="image-checkbox h-4 w-4 text-blue-600 rounded" data-image-id="${imageId}">
                </div>
                <div class="main-badge" style="display: none;">
                    <i class="fas fa-crown mr-1"></i>
                    Principal
                </div>
            </div>
            <div class="p-3 bg-white">
                <p class="text-sm text-gray-700 truncate font-medium" title="${name}">${name}</p>
                <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs text-green-600">✓ Ajoutée</span>
                    <button type="button" class="text-xs text-blue-600 hover:text-blue-800" onclick="previewImage('${imageId}')">
                        <i class="fas fa-eye mr-1"></i>
                        Voir
                    </button>
                </div>
            </div>
        `;
        
        if (imagePreview) {
            imagePreview.appendChild(imageCard);
        }
        
        uploadedFiles.push({ 
            id: imageId, 
            file: file, 
            name: name, 
            src: src,
            size: file.size,
            type: file.type
        });
        
        // Définir comme image principale si c'est la première
        if (uploadedFiles.length === 1) {
            setMainImage(imageId);
        }
        
        console.log(`🖼️ Image ajoutée: ${name} (${formatFileSize(file.size)})`);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function updateImageCount() {
        const countElement = document.getElementById('imageCount');
        if (countElement) {
            countElement.textContent = uploadedFiles.length;
            
            // Animation du compteur
            countElement.classList.add('scale-110');
            setTimeout(() => countElement.classList.remove('scale-110'), 200);
        }
    }

    function selectAllImages() {
        document.querySelectorAll('.image-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
        showNotification('Toutes les images sélectionnées', 'info');
    }

    function removeSelectedImages() {
        const checkedBoxes = document.querySelectorAll('.image-checkbox:checked');
        if (checkedBoxes.length === 0) {
            showNotification('Aucune image sélectionnée', 'warning');
            return;
        }
        
        checkedBoxes.forEach(checkbox => {
            removeImage(checkbox.dataset.imageId);
        });
        
        showNotification(`${checkedBoxes.length} image(s) supprimée(s)`, 'success');
    }

    function toggleStockImages() {
        const gallery = document.getElementById('stockImagesGallery');
        const button = document.getElementById('toggleStockImages');
        
        if (gallery && button) {
            if (gallery.classList.contains('hidden')) {
                gallery.classList.remove('hidden');
                gallery.classList.add('fade-in');
                button.innerHTML = '<i class="fas fa-chevron-up mr-1"></i>Masquer les images';
            } else {
                gallery.classList.add('hidden');
                button.innerHTML = '<i class="fas fa-chevron-down mr-1"></i>Voir les images';
            }
        }
    }

    // ==========================================
    // FONCTIONS GLOBALES POUR LES IMAGES
    // ==========================================
    
    window.setMainImage = function(imageId) {
        console.log(`⭐ Définition image principale: ${imageId}`);
        
        // Retirer le badge principal de toutes les images
        document.querySelectorAll('.main-badge').forEach(badge => {
            badge.style.display = 'none';
        });
        
        // Retirer la classe main-image de toutes les cartes
        document.querySelectorAll('.image-preview-card').forEach(card => {
            card.classList.remove('main-image');
        });
        
        // Ajouter le badge à l'image sélectionnée
        const imageCard = document.querySelector(`[data-image-id="${imageId}"]`);
        if (imageCard) {
            const badge = imageCard.querySelector('.main-badge');
            if (badge) {
                badge.style.display = 'block';
            }
            imageCard.classList.add('main-image');
        }
        
        // Marquer comme image principale dans les données
        uploadedFiles.forEach(file => {
            file.isMain = file.id === imageId;
        });
        
        updatePreview();
        showNotification('Image principale définie', 'success');
    };

    window.removeImage = function(imageId) {
        console.log(`🗑️ Suppression image: ${imageId}`);
        
        const imageCard = document.querySelector(`[data-image-id="${imageId}"]`);
        if (imageCard) {
            // Animation de suppression
            imageCard.style.transform = 'scale(0)';
            imageCard.style.opacity = '0';
            
            setTimeout(() => {
                imageCard.remove();
            }, 300);
        }
        
        // Retirer des données
        uploadedFiles = uploadedFiles.filter(file => file.id !== imageId);
        
        // Si c'était l'image principale, définir la première comme principale
        if (uploadedFiles.length > 0 && !uploadedFiles.some(file => file.isMain)) {
            setMainImage(uploadedFiles[0].id);
        }
        
        updateImageCount();
        
        // Masquer la section si plus d'images
        if (uploadedFiles.length === 0 && previewSection) {
            previewSection.style.display = 'none';
        }
        
        updatePreview();
    };

    window.editImage = function(imageId) {
        showNotification('Fonctionnalité d\'édition bientôt disponible', 'info');
    };

    window.previewImage = function(imageId) {
        const file = uploadedFiles.find(f => f.id === imageId);
        if (file) {
            // Créer une modale de prévisualisation
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content max-w-4xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">${file.name}</h3>
                        <button onclick="this.closest('.modal-overlay').remove()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <img src="${file.src}" alt="${file.name}" class="w-full max-h-96 object-contain rounded-lg">
                    <div class="mt-4 text-sm text-gray-600">
                        <p>Taille: ${formatFileSize(file.size)} | Type: ${file.type}</p>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
    };

    // ==========================================
    // FONCTIONS UTILITAIRES
    // ==========================================
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification-toast notification-${type}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    function updatePreview() {
        // Logique de mise à jour de l'aperçu
        console.log('🔄 Mise à jour de l\'aperçu...');
    }

    // ==========================================
    // INITIALISATION FINALE
    // ==========================================
    
    // Afficher le premier onglet
    showTab(0);
    
    console.log('✅ LEBOSS TECH Product Creator - Prêt!');
    showNotification('Interface de création chargée avec succès', 'success');
});

// Fonction pour ajouter une spécification
function addSpecification() {
    const container = document.getElementById('specificationsContainer');
    const newSpec = document.createElement('div');
    newSpec.className = 'flex space-x-4 items-center p-3 bg-gray-50 rounded-lg border border-gray-200';
    newSpec.innerHTML = `
        <input type="text" name="spec_keys[]" placeholder="Nom de la caractéristique" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
        <input type="text" name="spec_values[]" placeholder="Valeur" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
        <button type="button" onclick="this.parentElement.remove()" 
                class="px-3 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition-colors">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newSpec);
}

// Templates de spécifications prédéfinies
function addSpecTemplate(type) {
    const container = document.getElementById('specificationsContainer');
    const templates = {
        laptop: [
            { key: 'Processeur', value: 'Intel Core i7' },
            { key: 'RAM', value: '16 GB DDR4' },
            { key: 'Stockage', value: '512 GB SSD' },
            { key: 'Écran', value: '15.6" Full HD' },
            { key: 'Carte graphique', value: 'NVIDIA GTX 1650' },
            { key: 'Système', value: 'Windows 11' },
            { key: 'Batterie', value: '6 cellules' }
        ],
        smartphone: [
            { key: 'Écran', value: '6.1" OLED' },
            { key: 'Processeur', value: 'A15 Bionic' },
            { key: 'Stockage', value: '128 GB' },
            { key: 'Appareil photo', value: '12 MP' },
            { key: 'Batterie', value: '3000 mAh' },
            { key: 'Système', value: 'iOS 15' },
            { key: 'Connectivité', value: '5G, WiFi 6' }
        ],
        accessory: [
            { key: 'Connectivité', value: 'Bluetooth 5.0' },
            { key: 'Autonomie', value: '20 heures' },
            { key: 'Charge', value: 'USB-C' },
            { key: 'Poids', value: '250g' },
            { key: 'Dimensions', value: '20x15x5 cm' }
        ]
    };

    const template = templates[type];
    if (!template) return;

    // Vider le conteneur existant
    container.innerHTML = '';

    // Ajouter chaque spécification du template
    template.forEach(spec => {
        const newSpec = document.createElement('div');
        newSpec.className = 'flex space-x-4 items-center p-3 bg-gray-50 rounded-lg border border-gray-200';
        newSpec.innerHTML = `
            <input type="text" name="spec_keys[]" value="${spec.key}" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
            <input type="text" name="spec_values[]" value="${spec.value}" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
            <button type="button" onclick="this.parentElement.remove()" 
                    class="px-3 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition-colors">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newSpec);
    });

    // Ajouter une ligne vide pour les spécifications supplémentaires
    addSpecification();
}

// Compteurs de caractères pour les champs SEO
document.addEventListener('DOMContentLoaded', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    const metaTitleCounter = document.getElementById('metaTitleCounter');
    const metaDescCounter = document.getElementById('metaDescCounter');

    if (metaTitle && metaTitleCounter) {
        metaTitle.addEventListener('input', function() {
            const count = this.value.length;
            metaTitleCounter.textContent = `${count}/60`;
            metaTitleCounter.className = count > 60 ? 'text-sm text-red-500' : 'text-sm text-gray-400';
        });
    }

    if (metaDescription && metaDescCounter) {
        metaDescription.addEventListener('input', function() {
            const count = this.value.length;
            metaDescCounter.textContent = `${count}/160`;
            metaDescCounter.className = count > 160 ? 'text-sm text-red-500' : 'text-sm text-gray-400';
        });
    }

    // Mise à jour de l'aperçu en temps réel
    updatePreview();
    
    // Écouter les changements sur les champs principaux
    const fieldsToWatch = ['name', 'price', 'description', 'category_id'];
    fieldsToWatch.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', updatePreview);
            field.addEventListener('change', updatePreview);
        }
    });
});

// Fonction pour mettre à jour l'aperçu du produit
function updatePreview() {
    const preview = document.getElementById('productPreview');
    if (!preview) return;

    const name = document.querySelector('[name="name"]')?.value || 'Nom du produit';
    const price = document.querySelector('[name="price"]')?.value || '0';
    const description = document.querySelector('[name="description"]')?.value || 'Description du produit...';
    const category = document.querySelector('[name="category_id"] option:checked')?.textContent || 'Catégorie';

    // Mettre à jour l'aperçu
    preview.innerHTML = `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image -->
            <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-gray-400 text-6xl"></i>
                <div class="text-center mt-4">
                    <p class="text-gray-500">Aperçu de l'image</p>
                    <p class="text-sm text-gray-400">Ajoutez une image dans l'onglet Médias</p>
                </div>
            </div>

            <!-- Informations -->
            <div class="space-y-6">
                <div>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full mb-2">
                        ${category}
                    </span>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">${name}</h1>
                    <div class="text-4xl font-bold text-orange-600 mb-6">
                        ${parseInt(price).toLocaleString('fr-FR')} FCFA
                    </div>
                </div>

                <div class="prose max-w-none">
                    <p class="text-gray-600 leading-relaxed">${description}</p>
                </div>

                <div class="flex space-x-4">
                    <button class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Commander via WhatsApp
                    </button>
                    <button class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-heart mr-2"></i>
                        Favoris
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Événements pour les boutons d'ajout de spécification
document.addEventListener('DOMContentLoaded', function() {
    const addSpecBtn = document.getElementById('addSpecification');
    if (addSpecBtn) {
        addSpecBtn.addEventListener('click', addSpecification);
    }
});

// Génération automatique du SKU
function generateSKU() {
    const name = document.querySelector('[name="name"]')?.value || '';
    const category = document.querySelector('[name="category_id"] option:checked')?.textContent || '';
    
    if (!name) {
        alert('Veuillez d\'abord saisir le nom du produit');
        return;
    }

    // Générer un SKU basé sur le nom et la catégorie
    const nameCode = name.substring(0, 3).toUpperCase();
    const categoryCode = category.substring(0, 3).toUpperCase();
    const randomNum = Math.floor(Math.random() * 9999).toString().padStart(4, '0');
    
    const sku = `${categoryCode}-${nameCode}-${randomNum}`;
    document.querySelector('[name="sku"]').value = sku;
}

// Validation du formulaire avant soumission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
});

function validateForm() {
    const errors = [];
    
    // Validation du nom
    const name = document.querySelector('[name="name"]')?.value.trim();
    if (!name) {
        errors.push('Le nom du produit est requis');
    }

    // Validation du prix
    const price = document.querySelector('[name="price"]')?.value;
    if (!price || parseFloat(price) <= 0) {
        errors.push('Le prix doit être supérieur à 0');
    }

    // Validation de la catégorie
    const category = document.querySelector('[name="category_id"]')?.value;
    if (!category) {
        errors.push('Veuillez sélectionner une catégorie');
    }

    // Validation du stock
    const stock = document.querySelector('[name="stock"]')?.value;
    if (stock && parseInt(stock) < 0) {
        errors.push('Le stock ne peut pas être négatif');
    }

    // Afficher les erreurs
    if (errors.length > 0) {
        alert('Erreurs de validation :\n' + errors.join('\n'));
        return false;
    }

    return true;
}

// Sauvegarde automatique en brouillon
let draftTimeout;
function saveDraft() {
    clearTimeout(draftTimeout);
    draftTimeout = setTimeout(() => {
        const formData = new FormData(document.querySelector('form'));
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            draftData[key] = value;
        }
        
        localStorage.setItem('product_draft', JSON.stringify(draftData));
        
        // Afficher une indication de sauvegarde
        showNotification('Brouillon sauvegardé', 'success');
    }, 2000);
}

// Restaurer le brouillon
function restoreDraft() {
    const draft = localStorage.getItem('product_draft');
    if (!draft) return;

    if (confirm('Un brouillon a été trouvé. Voulez-vous le restaurer ?')) {
        const draftData = JSON.parse(draft);
        
        Object.entries(draftData).forEach(([key, value]) => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = value;
            }
        });
        
        updatePreview();
    }
}

// Notification simple
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Écouter les changements pour la sauvegarde automatique
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('input', saveDraft);
        form.addEventListener('change', saveDraft);
    }
    
    // Restaurer le brouillon au chargement
    restoreDraft();
});