/**
 * LEBOSS TECH - JavaScript avancé pour la liste des produits
 * Fonctionnalités : Filtres temps réel, vues multiples, animations, etc.
 */

class ProductManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupIntersectionObserver();
        this.setupKeyboardShortcuts();
    }

    init() {
        // Configuration initiale
        this.currentView = localStorage.getItem('productView') || 'grid';
        this.filterForm = document.getElementById('filterForm');
        this.searchInput = document.getElementById('searchInput');
        this.gridView = document.getElementById('gridView');
        this.listView = document.getElementById('listView');
        this.gridViewBtn = document.getElementById('gridViewBtn');
        this.listViewBtn = document.getElementById('listViewBtn');
        
        // État de l'application
        this.isLoading = false;
        this.searchTimeout = null;
        this.lastSearchQuery = '';
        
        // Restaurer la vue préférée
        this.setView(this.currentView);
        
        // Initialiser les tooltips
        this.initTooltips();
        
        // Charger les statistiques temps réel
        this.loadRealTimeStats();
        
        console.log('🚀 ProductManager initialisé avec succès');
    }

    setupEventListeners() {
        // Toggle vue grille/liste
        this.gridViewBtn?.addEventListener('click', () => this.setView('grid'));
        this.listViewBtn?.addEventListener('click', () => this.setView('list'));

        // Recherche en temps réel
        this.searchInput?.addEventListener('input', (e) => {
            this.handleSearch(e.target.value);
        });

        // Filtres automatiques
        document.querySelectorAll('select[name]').forEach(select => {
            select.addEventListener('change', () => this.submitFilters());
        });

        // Actions rapides
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action]')) {
                this.handleQuickAction(e.target.dataset.action, e.target);
            }
        });

        // Drag & Drop pour réorganiser (si admin)
        this.setupDragAndDrop();

        // Double-clic pour édition rapide
        document.addEventListener('dblclick', (e) => {
            const productCard = e.target.closest('.product-card');
            if (productCard) {
                const productId = productCard.dataset.productId;
                window.location.href = `/admin/products/${productId}/edit`;
            }
        });
    }

    setView(view) {
        this.currentView = view;
        localStorage.setItem('productView', view);

        if (view === 'grid') {
            this.gridView?.classList.remove('hidden');
            this.listView?.classList.add('hidden');
            this.gridViewBtn?.classList.add('active');
            this.listViewBtn?.classList.remove('active');
        } else {
            this.gridView?.classList.add('hidden');
            this.listView?.classList.remove('hidden');
            this.listViewBtn?.classList.add('active');
            this.gridViewBtn?.classList.remove('active');
        }

        // Animation de transition
        this.animateViewChange();
    }

    animateViewChange() {
        const activeView = this.currentView === 'grid' ? this.gridView : this.listView;
        if (activeView) {
            activeView.style.opacity = '0';
            activeView.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                activeView.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                activeView.style.opacity = '1';
                activeView.style.transform = 'translateY(0)';
            }, 50);
        }
    }

    handleSearch(query) {
        // Éviter les recherches en doublon
        if (query === this.lastSearchQuery) return;
        this.lastSearchQuery = query;

        // Debounce pour éviter trop de requêtes
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);

        // Feedback visuel immédiat
        this.showSearchLoading();
    }

    showSearchLoading() {
        const searchIcon = document.querySelector('.search-icon');
        if (searchIcon) {
            searchIcon.className = 'search-icon fas fa-spinner fa-spin';
            setTimeout(() => {
                searchIcon.className = 'search-icon fas fa-search';
            }, 1000);
        }
    }

    performSearch(query) {
        if (this.isLoading) return;
        this.isLoading = true;

        // Soumettre le formulaire
        this.submitFilters();
    }

    submitFilters() {
        if (this.filterForm) {
            // Ajouter un indicateur de chargement
            this.showLoadingState();
            this.filterForm.submit();
        }
    }

    showLoadingState() {
        // Effet de shimmer sur les cartes
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.add('loading-skeleton');
        });
    }

    clearFilters() {
        const form = this.filterForm;
        if (!form) return;

        form.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'text' || input.type === 'search') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
        
        this.submitFilters();
    }

    setupIntersectionObserver() {
        const options = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    
                    // Lazy loading des images
                    const img = entry.target.querySelector('img[data-src]');
                    if (img) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                }
            });
        }, options);

        // Observer toutes les cartes produits
        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl+K ou Cmd+K pour focus sur la recherche
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.searchInput?.focus();
            }

            // G pour vue grille, L pour vue liste
            if (e.key === 'g' && !e.target.matches('input, textarea, select')) {
                this.setView('grid');
            }
            if (e.key === 'l' && !e.target.matches('input, textarea, select')) {
                this.setView('list');
            }

            // N pour nouveau produit
            if (e.key === 'n' && !e.target.matches('input, textarea, select')) {
                window.location.href = '/admin/products/create';
            }

            // Échap pour effacer les filtres
            if (e.key === 'Escape' && this.searchInput === document.activeElement) {
                this.clearFilters();
                this.searchInput.blur();
            }
        });
    }

    initTooltips() {
        // Créer des tooltips dynamiques
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            this.createTooltip(element);
        });
    }

    createTooltip(element) {
        let tooltip = null;

        element.addEventListener('mouseenter', () => {
            tooltip = document.createElement('div');
            tooltip.className = 'tooltip-popup';
            tooltip.textContent = element.dataset.tooltip;
            
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.left = rect.left + (element.offsetWidth / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';

            setTimeout(() => tooltip.classList.add('visible'), 10);
        });

        element.addEventListener('mouseleave', () => {
            if (tooltip) {
                tooltip.classList.remove('visible');
                setTimeout(() => tooltip.remove(), 300);
            }
        });
    }

    setupDragAndDrop() {
        // Drag & Drop pour réorganiser les produits (admin seulement)
        if (!document.body.dataset.userRole || document.body.dataset.userRole !== 'admin') {
            return;
        }

        let draggedElement = null;

        document.addEventListener('dragstart', (e) => {
            if (e.target.closest('.product-card')) {
                draggedElement = e.target.closest('.product-card');
                draggedElement.classList.add('dragging');
            }
        });

        document.addEventListener('dragend', (e) => {
            if (draggedElement) {
                draggedElement.classList.remove('dragging');
                draggedElement = null;
            }
        });

        document.addEventListener('dragover', (e) => {
            e.preventDefault();
            const dropTarget = e.target.closest('.product-card');
            if (dropTarget && dropTarget !== draggedElement) {
                dropTarget.classList.add('drag-over');
            }
        });

        document.addEventListener('dragleave', (e) => {
            const dropTarget = e.target.closest('.product-card');
            if (dropTarget) {
                dropTarget.classList.remove('drag-over');
            }
        });

        document.addEventListener('drop', (e) => {
            e.preventDefault();
            const dropTarget = e.target.closest('.product-card');
            if (dropTarget && draggedElement && dropTarget !== draggedElement) {
                this.reorderProducts(draggedElement, dropTarget);
            }
            document.querySelectorAll('.drag-over').forEach(el => el.classList.remove('drag-over'));
        });
    }

    reorderProducts(dragged, target) {
        // Logique de réorganisation des produits
        const draggedId = dragged.dataset.productId;
        const targetId = target.dataset.productId;
        
        // Ici on pourrait faire un appel AJAX pour sauvegarder l'ordre
        console.log(`Réorganisation: ${draggedId} → ${targetId}`);
        
        this.showNotification('Ordre des produits mis à jour', 'success');
    }

    handleQuickAction(action, element) {
        switch (action) {
            case 'toggle-status':
                this.toggleProductStatus(element);
                break;
            case 'toggle-featured':
                this.toggleProductFeatured(element);
                break;
            case 'duplicate':
                this.duplicateProduct(element);
                break;
            case 'export':
                this.exportProducts();
                break;
        }
    }

    toggleProductStatus(element) {
        const productId = element.closest('.product-card').dataset.productId;
        const currentStatus = element.dataset.status === 'active';
        
        // Animation de chargement
        element.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        // Simulation d'appel AJAX
        setTimeout(() => {
            const newStatus = !currentStatus;
            element.dataset.status = newStatus ? 'active' : 'inactive';
            element.innerHTML = newStatus ? 
                '<i class="fas fa-eye"></i>' : 
                '<i class="fas fa-eye-slash"></i>';
                
            this.showNotification(
                `Produit ${newStatus ? 'activé' : 'désactivé'}`, 
                'success'
            );
        }, 500);
    }

    duplicateProduct(element) {
        const productId = element.closest('.product-card').dataset.productId;
        
        if (confirm('Êtes-vous sûr de vouloir dupliquer ce produit ?')) {
            window.location.href = `/admin/products/${productId}/duplicate`;
        }
    }

    exportProducts() {
        const filters = new FormData(this.filterForm);
        const params = new URLSearchParams(filters);
        
        this.showNotification('Export en cours...', 'info');
        
        // Simulation d'export
        setTimeout(() => {
            // window.location.href = `/admin/products/export?${params}`;
            this.showNotification('Export terminé', 'success');
        }, 2000);
    }

    loadRealTimeStats() {
        // Mise à jour des statistiques en temps réel
        setInterval(() => {
            this.updateStats();
        }, 30000); // Toutes les 30 secondes
    }

    updateStats() {
        // Simuler la mise à jour des stats
        fetch('/admin/products/stats')
            .then(response => response.json())
            .then(data => {
                this.updateStatCards(data);
            })
            .catch(() => {
                // Gestion silencieuse des erreurs
            });
    }

    updateStatCards(stats) {
        Object.entries(stats).forEach(([key, value]) => {
            const statElement = document.querySelector(`[data-stat="${key}"]`);
            if (statElement) {
                this.animateNumber(statElement, value);
            }
        });
    }

    animateNumber(element, newValue) {
        const currentValue = parseInt(element.textContent) || 0;
        const difference = newValue - currentValue;
        const steps = 20;
        const stepValue = difference / steps;
        let current = currentValue;

        const interval = setInterval(() => {
            current += stepValue;
            element.textContent = Math.round(current);
            
            if (Math.abs(current - newValue) < Math.abs(stepValue)) {
                element.textContent = newValue;
                clearInterval(interval);
            }
        }, 50);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getIconByType(type)} mr-2"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.appendChild(notification);

        // Auto-fermeture après 5 secondes
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 300);
        }, 5000);

        // Fermeture manuelle
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 300);
        });
    }

    getIconByType(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
}

// Styles pour les notifications
const notificationStyles = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 400px;
        z-index: 9999;
        transform: translateX(100%);
        animation: slideIn 0.3s ease-out forwards;
    }

    .notification-success { border-left: 4px solid #10b981; }
    .notification-error { border-left: 4px solid #ef4444; }
    .notification-warning { border-left: 4px solid #f59e0b; }
    .notification-info { border-left: 4px solid #3b82f6; }

    .notification-content {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .notification-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #6b7280;
        padding: 4px;
        margin-left: 12px;
    }

    .notification.fade-out {
        animation: slideOut 0.3s ease-in forwards;
    }

    @keyframes slideIn {
        to { transform: translateX(0); }
    }

    @keyframes slideOut {
        to { transform: translateX(100%); }
    }

    .tooltip-popup {
        position: absolute;
        background: #1f2937;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        pointer-events: none;
        opacity: 0;
        transform: translateY(5px);
        transition: all 0.3s ease;
        z-index: 10000;
    }

    .tooltip-popup.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .product-card.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
    }

    .product-card.drag-over {
        border: 2px dashed #f97316;
        background: #fff7ed;
    }
`;

// Injecter les styles
const styleSheet = document.createElement('style');
styleSheet.textContent = notificationStyles;
document.head.appendChild(styleSheet);

// Initialiser le gestionnaire de produits quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    window.productManager = new ProductManager();
});

// Fonctions globales pour compatibilité avec les événements inline
window.submitFilters = () => window.productManager?.submitFilters();
window.clearFilters = () => window.productManager?.clearFilters();
window.exportProducts = () => window.productManager?.exportProducts();
window.toggleFilters = () => {
    const filterBar = document.querySelector('.search-filter-bar');
    filterBar?.classList.toggle('hidden');
};

// Export pour modules ES6 si utilisé
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProductManager;
} 