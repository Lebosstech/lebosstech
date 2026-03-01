/**
 * LEBOSS TECH - Enhanced Products JavaScript
 * Gestion avancée des produits avec favoris, comparaison, aperçu rapide
 */

class ProductsManager {
    constructor() {
        this.favorites = JSON.parse(localStorage.getItem('leboss_favorites') || '[]');
        this.compareList = JSON.parse(localStorage.getItem('leboss_compare') || '[]');
        this.currentView = localStorage.getItem('leboss_view') || 'grid';
        this.csrf_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        this.init();
    }

    init() {
        this.setView(this.currentView);
        this.updateFavoritesUI();
        this.updateCompareUI();
        this.initializeEventListeners();
        this.initializeAutoComplete();
    }

    // ==================== VIEW MANAGEMENT ====================
    setView(view) {
        this.currentView = view;
        localStorage.setItem('leboss_view', view);
        
        const container = document.getElementById('productsContainer');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        
        if (!container || !gridBtn || !listBtn) return;
        
        if (view === 'grid') {
            container.className = 'grid-view';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        } else {
            container.className = 'list-view';
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        }
    }

    // ==================== FAVORITES MANAGEMENT ====================
    toggleFavorite(productId) {
        const index = this.favorites.indexOf(productId);
        if (index > -1) {
            this.favorites.splice(index, 1);
            this.showNotification('Produit retiré des favoris', 'info');
        } else {
            this.favorites.push(productId);
            this.showNotification('Produit ajouté aux favoris', 'success');
        }
        
        localStorage.setItem('leboss_favorites', JSON.stringify(this.favorites));
        this.updateFavoritesUI();
    }

    updateFavoritesUI() {
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            const card = btn.closest('.product-card');
            if (!card) return;
            
            const productId = parseInt(card.dataset.productId);
            
            if (this.favorites.includes(productId)) {
                btn.classList.add('text-red-500', 'bg-red-50');
                btn.classList.remove('text-gray-600');
                btn.innerHTML = '<i class="fas fa-heart text-sm"></i>';
            } else {
                btn.classList.remove('text-red-500', 'bg-red-50');
                btn.classList.add('text-gray-600');
                btn.innerHTML = '<i class="far fa-heart text-sm"></i>';
            }
        });
    }

    // ==================== COMPARE FUNCTIONALITY ====================
    toggleCompareMode() {
        document.body.classList.toggle('compare-mode');
        const sidebar = document.getElementById('compareSidebar');
        if (sidebar) {
            sidebar.classList.toggle('translate-x-full');
        }
    }

    toggleCompare(productId) {
        if (this.compareList.length >= 3 && !this.compareList.includes(productId)) {
            this.showNotification('Vous ne pouvez comparer que 3 produits maximum', 'error');
            return;
        }
        
        const index = this.compareList.indexOf(productId);
        if (index > -1) {
            this.compareList.splice(index, 1);
            this.showNotification('Produit retiré de la comparaison', 'info');
        } else {
            this.compareList.push(productId);
            this.showNotification('Produit ajouté à la comparaison', 'success');
        }
        
        localStorage.setItem('leboss_compare', JSON.stringify(this.compareList));
        this.updateCompareUI();
    }

    updateCompareUI() {
        const count = document.getElementById('compareCount');
        const compareBtn = document.getElementById('compareToggle');
        
        if (count && compareBtn) {
            if (this.compareList.length > 0) {
                count.textContent = this.compareList.length;
                count.classList.remove('hidden');
                compareBtn.classList.add('bg-purple-500', 'text-white');
                compareBtn.classList.remove('bg-purple-100', 'text-purple-700');
            } else {
                count.classList.add('hidden');
                compareBtn.classList.remove('bg-purple-500', 'text-white');
                compareBtn.classList.add('bg-purple-100', 'text-purple-700');
            }
        }
        
        // Update compare buttons
        document.querySelectorAll('.compare-btn').forEach(btn => {
            const card = btn.closest('.product-card');
            if (!card) return;
            
            const productId = parseInt(card.dataset.productId);
            
            if (this.compareList.includes(productId)) {
                btn.classList.add('text-purple-500', 'bg-purple-50');
                btn.classList.remove('text-gray-600');
            } else {
                btn.classList.remove('text-purple-500', 'bg-purple-50');
                btn.classList.add('text-gray-600');
            }
        });
    }

    async loadCompare() {
        if (this.compareList.length === 0) {
            const compareList = document.getElementById('compareList');
            if (compareList) {
                compareList.innerHTML = '<p class="text-gray-500 text-center">Ajoutez des produits à comparer</p>';
            }
            return;
        }

        try {
            const response = await fetch('/api/products/compare', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf_token
                },
                body: JSON.stringify({ products: this.compareList })
            });

            const data = await response.json();
            
            if (data.success) {
                const compareList = document.getElementById('compareList');
                if (compareList) {
                    compareList.innerHTML = data.html;
                }
            }
        } catch (error) {
            console.error('Error loading compare:', error);
        }
    }

    // ==================== QUICK VIEW ====================
    async quickView(productId) {
        try {
            const response = await fetch(`/api/products/${productId}/quick-view`);
            const data = await response.json();
            
            if (data.success) {
                const modal = document.getElementById('quickViewModal');
                const content = document.getElementById('quickViewContent');
                
                if (modal && content) {
                    content.innerHTML = data.html;
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            }
        } catch (error) {
            console.error('Error loading quick view:', error);
            this.showNotification('Erreur lors du chargement', 'error');
        }
    }

    closeQuickView() {
        const modal = document.getElementById('quickViewModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // ==================== QUICK ORDER ====================
    async quickOrder(productId) {
        try {
            // Simuler une commande rapide WhatsApp
            const response = await fetch(`/whatsapp-click/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token
                }
            });

            if (response.ok) {
                this.showNotification('Redirection vers WhatsApp...', 'success');
                // La redirection est gérée côté serveur
            }
        } catch (error) {
            console.error('Error with quick order:', error);
        }
    }

    // ==================== AUTOCOMPLETE SEARCH ====================
    initializeAutoComplete() {
        const searchInput = document.getElementById('search');
        if (!searchInput) return;

        let timeout;
        const resultsContainer = document.createElement('div');
        resultsContainer.className = 'absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg shadow-lg z-10 hidden';
        searchInput.parentNode.appendChild(resultsContainer);

        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value.trim();

            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }

            timeout = setTimeout(async () => {
                try {
                    const response = await fetch(`/api/products/search?q=${encodeURIComponent(query)}`);
                    const products = await response.json();

                    this.displaySearchResults(products, resultsContainer);
                } catch (error) {
                    console.error('Search error:', error);
                }
            }, 300);
        });

        // Close results when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });
    }

    displaySearchResults(products, container) {
        if (products.length === 0) {
            container.innerHTML = '<div class="p-4 text-gray-500 text-center">Aucun produit trouvé</div>';
        } else {
            container.innerHTML = products.map(product => `
                <a href="${product.url}" class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                    ${product.image ? `<img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded mr-3">` : ''}
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 line-clamp-1">${product.name}</h4>
                        <p class="text-sm text-blue-600">${product.category}</p>
                        <p class="text-sm font-semibold text-gray-700">${product.price}</p>
                    </div>
                </a>
            `).join('');
        }
        container.classList.remove('hidden');
    }

    // ==================== PRICE SHORTCUTS ====================
    setPrice(min, max) {
        const minInput = document.querySelector('input[name="min_price"]');
        const maxInput = document.querySelector('input[name="max_price"]');
        
        if (minInput) minInput.value = min || '';
        if (maxInput) maxInput.value = max || '';
        
        // Auto-submit form
        setTimeout(() => {
            const form = document.getElementById('filtersForm');
            if (form) form.submit();
        }, 100);
    }

    // ==================== FILTERS ====================
    clearAllFilters() {
        const form = document.getElementById('filtersForm');
        if (form) {
            form.reset();
            // Use current page URL without filters
            window.location.href = window.location.pathname;
        }
    }

    // ==================== EVENT LISTENERS ====================
    initializeEventListeners() {
        // Auto-submit form on filter change
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            if (input.form && input.form.id === 'filtersForm') {
                input.addEventListener('change', () => {
                    if (input.name !== 'sort') {
                        setTimeout(() => {
                            input.form.submit();
                        }, 100);
                    }
                });
            }
        });

        // Click outside to close modals
        document.addEventListener('click', (e) => {
            if (e.target.id === 'quickViewModal') {
                this.closeQuickView();
            }
        });

        // Escape key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeQuickView();
                if (document.body.classList.contains('compare-mode')) {
                    this.toggleCompareMode();
                }
            }
        });
    }

    // ==================== NOTIFICATIONS ====================
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
        
        switch (type) {
            case 'success':
                notification.classList.add('bg-green-500');
                break;
            case 'error':
                notification.classList.add('bg-red-500');
                break;
            case 'info':
                notification.classList.add('bg-blue-500');
                break;
            default:
                notification.classList.add('bg-gray-500');
        }
        
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Animate out
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// ==================== GLOBAL FUNCTIONS ====================
let productsManager;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    productsManager = new ProductsManager();
});

// Global functions for backward compatibility
function setView(view) {
    if (productsManager) productsManager.setView(view);
}

function toggleFavorite(productId) {
    if (productsManager) productsManager.toggleFavorite(productId);
}

function toggleCompareMode() {
    if (productsManager) productsManager.toggleCompareMode();
}

function toggleCompare(productId) {
    if (productsManager) productsManager.toggleCompare(productId);
}

function quickView(productId) {
    if (productsManager) productsManager.quickView(productId);
}

function closeQuickView() {
    if (productsManager) productsManager.closeQuickView();
}

function quickOrder(productId) {
    if (productsManager) productsManager.quickOrder(productId);
}

function setPrice(min, max) {
    if (productsManager) productsManager.setPrice(min, max);
}

function clearAllFilters() {
    if (productsManager) productsManager.clearAllFilters();
}

function loadCompare() {
    if (productsManager) productsManager.loadCompare();
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProductsManager;
} 