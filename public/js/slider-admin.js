/**
 * LEBOSS TECH - Slider Admin Management
 */

console.log('LEBOSS TECH - Slider Admin JS chargé');

// Configuration globale
const Config = {
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    baseUrl: '/admin/sliders'
};

/**
 * Fonction pour afficher des notifications
 */
function showNotification(message, type = 'info', duration = 4000) {
    // Supprimer les notifications existantes
    document.querySelectorAll('.admin-notification').forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    notification.className = `admin-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 max-w-md`;
    
    let bgClass = 'bg-blue-500';
    let icon = 'info-circle';
    
    switch(type) {
        case 'success':
            bgClass = 'bg-green-500';
            icon = 'check-circle';
            break;
        case 'error':
            bgClass = 'bg-red-500';
            icon = 'exclamation-triangle';
            break;
        case 'warning':
            bgClass = 'bg-yellow-500';
            icon = 'exclamation-circle';
            break;
    }
    
    notification.className += ` ${bgClass} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${icon} mr-3"></i>
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Suppression automatique
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

/**
 * Supprimer un slider
 */
async function deleteSlider(sliderId) {
    const sliderCard = document.querySelector(`[data-slider-id="${sliderId}"]`);
    const sliderTitle = sliderCard?.querySelector('.slider-title')?.textContent || 'ce slider';
    
    const confirmMessage = `Êtes-vous sûr de vouloir supprimer "${sliderTitle}" ?\n\nCette action est irréversible.`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    try {
        console.log(`Suppression du slider ${sliderId}`);
        
        // Afficher un état de chargement
        if (sliderCard) {
            sliderCard.style.opacity = '0.5';
            sliderCard.style.pointerEvents = 'none';
        }
        
        const response = await fetch(`/admin/sliders/${sliderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': Config.csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        if (response.ok) {
            showNotification(`Slider "${sliderTitle}" supprimé avec succès.`, 'success');
            
            // Animation de suppression
            if (sliderCard) {
                sliderCard.style.transform = 'scale(0.8)';
                sliderCard.style.opacity = '0';
                setTimeout(() => {
                    sliderCard.remove();
                }, 300);
            } else {
                // Rechargement de la page si la carte n'est pas trouvée
                setTimeout(() => window.location.reload(), 1000);
            }
        } else {
            throw new Error('Erreur lors de la suppression');
        }
        
    } catch (error) {
        console.error('Erreur lors de la suppression:', error);
        showNotification('Erreur lors de la suppression du slider.', 'error');
        
        // Restaurer l'état
        if (sliderCard) {
            sliderCard.style.opacity = '1';
            sliderCard.style.pointerEvents = 'auto';
        }
    }
}

/**
 * Activer/Désactiver un slider
 */
async function toggleSliderStatus(sliderId, isActive) {
    try {
        console.log(`Toggle slider ${sliderId} to ${isActive}`);
        
        const response = await fetch(`/admin/sliders/${sliderId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': Config.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ is_active: isActive })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification(data.message, 'success');
        } else {
            throw new Error(data.message || 'Erreur lors de la mise à jour');
        }
        
    } catch (error) {
        console.error('Erreur lors du changement de statut:', error);
        showNotification(error.message || 'Erreur lors de la mise à jour du statut.', 'error');
        
        // Restaurer l'état précédent du toggle
        const toggle = document.querySelector(`input[onchange*="${sliderId}"]`);
        if (toggle) toggle.checked = !isActive;
    }
}

/**
 * Prévisualiser un slider
 */
async function previewSlider(sliderId) {
    try {
        const response = await fetch(`/admin/sliders/${sliderId}/preview`);
        const data = await response.json();
        
        const modal = document.getElementById('previewModal');
        const content = document.getElementById('previewContent');
        
        if (!modal || !content) {
            showNotification('Modal de prévisualisation non trouvée.', 'error');
            return;
        }
        
        content.innerHTML = `
            <div class="relative w-full h-96 bg-gray-900 rounded-lg overflow-hidden">
                ${data.image ? `<img src="${data.image}" alt="${data.title}" class="w-full h-full object-cover">` : ''}
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex items-center justify-center text-white text-center p-8">
                    <div>
                        <h2 class="text-4xl font-bold mb-4">${data.title}</h2>
                        ${data.subtitle ? `<p class="text-xl mb-6">${data.subtitle}</p>` : ''}
                        ${data.button_text ? `<button class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold">${data.button_text}</button>` : ''}
                    </div>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
        
    } catch (error) {
        console.error('Erreur lors de la prévisualisation:', error);
        showNotification('Erreur lors de la prévisualisation.', 'error');
    }
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function toggleSlidersOrder() {
    showNotification('Fonctionnalité de réorganisation en développement.', 'info');
}

function showSliderGuide() {
    showNotification('Guide : Créez, modifiez et gérez vos sliders depuis cette interface.', 'info', 6000);
}

// Exposer les fonctions globalement
window.toggleSliderStatus = toggleSliderStatus;
window.deleteSlider = deleteSlider;
window.previewSlider = previewSlider;
window.closePreviewModal = closePreviewModal;
window.toggleSlidersOrder = toggleSlidersOrder;
window.showSliderGuide = showSliderGuide;
window.showNotification = showNotification;
