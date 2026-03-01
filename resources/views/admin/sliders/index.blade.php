@extends('layouts.admin')

@section('title', 'Gestion des Sliders - LEBOSS TECH')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-images text-blue-600 mr-3"></i>
                        Gestion des Sliders
                    </h1>
                    <p class="text-gray-600 mt-2">Gérez les bannières de votre site LEBOSS TECH</p>
                </div>
                <a href="{{ route('admin.sliders.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau Slider
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-images text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $sliders->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Actifs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $sliders->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-eye-slash text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Inactifs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $sliders->where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-sort text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Ordre Max</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $sliders->max('order') ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des sliders -->
        @if($sliders->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Liste des sliders ({{ $sliders->total() }})</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slider
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ordre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Créé le
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sliders as $slider)
                                <tr class="hover:bg-gray-50" id="slider-row-{{ $slider->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-24">
                                                @php
                                                    $imageUrl = null;
                                                    if ($slider->hasMedia('banners')) {
                                                        $imageUrl = $slider->getFirstMediaUrl('banners', 'banner');
                                                    } elseif ($slider->image) {
                                                        $imageUrl = asset($slider->image);
                                                    }
                                                @endphp
                                                
                                                @if($imageUrl)
                                                    <img class="h-16 w-24 rounded-lg object-cover shadow-sm" 
                                                         src="{{ $imageUrl }}" 
                                                         alt="{{ $slider->title }}">
                                                @else
                                                    <div class="h-16 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-lg font-semibold text-gray-900">{{ $slider->title }}</div>
                                                @if($slider->subtitle)
                                                    <div class="text-sm text-gray-600">{{ Str::limit($slider->subtitle, 60) }}</div>
                                                @endif
                                                @if($slider->button_text)
                                                    <div class="text-xs text-blue-600 mt-1">
                                                        <i class="fas fa-link mr-1"></i>{{ $slider->button_text }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   {{ $slider->is_active ? 'checked' : '' }}
                                                   class="sr-only peer"
                                                   onchange="toggleSliderStatus({{ $slider->id }}, this.checked)">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                        <span class="ml-2 text-sm {{ $slider->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $slider->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            #{{ $slider->order }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $slider->created_at->format('d/m/Y') }}
                                        <br>
                                        <span class="text-xs text-gray-400">{{ $slider->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Aperçu -->
                                            <button onclick="previewSlider({{ $slider->id }})" 
                                                    class="text-green-600 hover:text-green-900 transition-colors"
                                                    title="Aperçu">
                                                <i class="fas fa-eye text-lg"></i>
                                            </button>
                                            
                                            <!-- Modifier -->
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            
                                            <!-- Supprimer -->
                                            <button onclick="deleteSlider({{ $slider->id }}, '{{ addslashes($slider->title) }}')" 
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Supprimer">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($sliders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $sliders->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- État vide -->
            <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-images text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun slider configuré</h3>
                <p class="text-gray-600 mb-6">Créez votre premier slider pour commencer à afficher des bannières.</p>
                <a href="{{ route('admin.sliders.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Créer le premier slider
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal d'aperçu -->
<div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Aperçu du Slider</h3>
            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div id="previewContent" class="relative w-full h-96 bg-gray-900 rounded-lg overflow-hidden">
                <!-- Contenu de l'aperçu sera injecté ici -->
            </div>
        </div>
    </div>
</div>

<!-- Notifications -->
<div id="notifications-container" class="fixed top-4 right-4 z-50 space-y-2">
    <!-- Les notifications seront ajoutées ici -->
</div>

@endsection

@push('scripts')
<script>
console.log('🚀 LEBOSS TECH - Admin Sliders chargé');

// Configuration
const Config = {
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    baseUrl: '/admin/sliders'
};

if (!Config.csrfToken) {
    console.error('❌ Token CSRF manquant');
}

/**
 * Afficher une notification
 */
function showNotification(message, type = 'info', duration = 4000) {
    const container = document.getElementById('notifications-container');
    if (!container) return;
    
    const notification = document.createElement('div');
    notification.className = `transform transition-all duration-300 max-w-sm w-full shadow-lg rounded-lg pointer-events-auto`;
    
    let bgColor = 'bg-blue-500';
    let icon = 'info-circle';
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            icon = 'check-circle';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            icon = 'exclamation-triangle';
            break;
        case 'warning':
            bgColor = 'bg-yellow-500';
            icon = 'exclamation-circle';
            break;
    }
    
    notification.innerHTML = `
        <div class="${bgColor} p-4 rounded-lg shadow-lg text-white">
            <div class="flex items-center">
                <i class="fas fa-${icon} text-xl mr-3"></i>
                <p class="flex-1 font-medium">${message}</p>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                        class="ml-3 text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    // Animation d'entrée
    notification.style.transform = 'translateX(100%)';
    notification.style.opacity = '0';
    
    container.appendChild(notification);
    
    // Déclencher l'animation
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
        notification.style.opacity = '1';
    }, 100);
    
    // Auto-suppression
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }
    }, duration);
}

/**
 * Toggle du statut d'un slider
 */
function toggleSliderStatus(sliderId, isActive) {
    console.log(`🔄 Toggle slider ${sliderId} vers ${isActive}`);
    
    fetch(`${Config.baseUrl}/${sliderId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': Config.csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ is_active: isActive })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Mise à jour visuelle du statut
            const row = document.getElementById(`slider-row-${sliderId}`);
            if (row) {
                const statusText = row.querySelector('span.ml-2');
                if (statusText) {
                    statusText.textContent = isActive ? 'Actif' : 'Inactif';
                    statusText.className = `ml-2 text-sm ${isActive ? 'text-green-600' : 'text-red-600'}`;
                }
            }
        } else {
            throw new Error(data.message || 'Erreur inconnue');
        }
    })
    .catch(error => {
        console.error('❌ Erreur toggle:', error);
        showNotification(`Erreur: ${error.message}`, 'error');
        
        // Remettre le toggle à son état précédent
        const checkbox = document.querySelector(`#slider-row-${sliderId} input[type="checkbox"]`);
        if (checkbox) {
            checkbox.checked = !isActive;
        }
    });
}

/**
 * Supprimer un slider
 */
function deleteSlider(sliderId, sliderTitle) {
    console.log(`🗑️ Suppression slider ${sliderId}: ${sliderTitle}`);
    
    if (!confirm(`Êtes-vous sûr de vouloir supprimer le slider "${sliderTitle}" ?\n\nCette action est irréversible.`)) {
        return;
    }
    
    // Créer et soumettre le formulaire de suppression
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `${Config.baseUrl}/${sliderId}`;
    form.style.display = 'none';
    
    // Token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = Config.csrfToken;
    form.appendChild(csrfInput);
    
    // Méthode DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    
    // Notification et soumission
    showNotification(`Suppression de "${sliderTitle}" en cours...`, 'info', 2000);
    form.submit();
}

/**
 * Prévisualiser un slider
 */
function previewSlider(sliderId) {
    console.log(`👁️ Aperçu slider ${sliderId}`);
    
    fetch(`${Config.baseUrl}/${sliderId}/preview`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const modal = document.getElementById('previewModal');
        const content = document.getElementById('previewContent');
        
        if (modal && content) {
            content.innerHTML = `
                ${data.image ? `<img src="${data.image}" alt="${data.title}" class="w-full h-full object-cover">` : ''}
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex items-center justify-center text-white text-center p-8">
                    <div>
                        <h2 class="text-4xl font-bold mb-4">${data.title}</h2>
                        ${data.subtitle ? `<p class="text-xl mb-6">${data.subtitle}</p>` : ''}
                        ${data.button_text ? `<button class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold">${data.button_text}</button>` : ''}
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
            showNotification('Aperçu chargé', 'success', 2000);
        }
    })
    .catch(error => {
        console.error('❌ Erreur aperçu:', error);
        showNotification(`Erreur: ${error.message}`, 'error');
    });
}

/**
 * Fermer le modal d'aperçu
 */
function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Interface admin sliders initialisée');
    showNotification('Interface chargée avec succès', 'success', 2000);
});
</script>
@endpush
