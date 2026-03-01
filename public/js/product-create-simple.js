// Script JavaScript simplifié pour la création de produits LEBOSS TECH
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 LEBOSS TECH - Script de création de produits chargé');
    
    // Génération automatique du SKU
    const generateSKUBtn = document.getElementById('generateSKU');
    const skuInput = document.getElementById('sku');
    
    if (generateSKUBtn && skuInput) {
        generateSKUBtn.addEventListener('click', function() {
            const timestamp = Date.now().toString().slice(-6);
            const randomNum = Math.floor(Math.random() * 99) + 1;
            const sku = `LBT-${timestamp}${randomNum.toString().padStart(2, '0')}`;
            skuInput.value = sku;
            console.log('SKU généré:', sku);
        });
    }
    
    // Validation simple du formulaire
    const form = document.getElementById('productForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const sku = document.getElementById('sku').value.trim();
            const price = document.getElementById('price').value;
            const categoryId = document.getElementById('category_id').value;
            
            if (!name) {
                alert('Le nom du produit est obligatoire');
                e.preventDefault();
                return false;
            }
            
            if (!sku) {
                alert('Le SKU est obligatoire');
                e.preventDefault();
                return false;
            }
            
            if (!price || price <= 0) {
                alert('Le prix doit être supérieur à 0');
                e.preventDefault();
                return false;
            }
            
            if (!categoryId) {
                alert('Veuillez sélectionner une catégorie');
                e.preventDefault();
                return false;
            }
            
            console.log('✅ Formulaire valide, envoi en cours...');
            return true;
        });
    }
    
    // Bouton "Sauvegarder brouillon"
    const saveAsDraftBtn = document.getElementById('saveAsDraft');
    if (saveAsDraftBtn) {
        saveAsDraftBtn.addEventListener('click', function() {
            const draftInput = document.createElement('input');
            draftInput.type = 'hidden';
            draftInput.name = 'is_draft';
            draftInput.value = '1';
            form.appendChild(draftInput);
            form.submit();
        });
    }
    
    // Compteurs de caractères simples
    function setupCharCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        if (input && counter) {
            function updateCounter() {
                const length = input.value.length;
                counter.textContent = `${length}/${maxLength}`;
                counter.style.color = length > maxLength * 0.9 ? '#ef4444' : '#6b7280';
            }
            
            input.addEventListener('input', updateCounter);
            updateCounter();
        }
    }
    
    setupCharCounter('name', 'nameCounter', 255);
    setupCharCounter('short_description', 'shortDescCounter', 500);
    
    console.log('✅ Tous les événements sont configurés');
}); 