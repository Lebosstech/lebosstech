@extends('layouts.app')

@section('title', 'Analytics Temps Réel - LEBOSS TECH')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header -->
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        Analytics Temps Réel
                        <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 animate-pulse">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                            EN DIRECT
                        </span>
                    </h1>
                    <p class="text-gray-600 mt-1">Suivi en temps réel de l'activité du site</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-500">
                        Dernière mise à jour: <span id="lastUpdate">--:--</span>
                    </div>
                    <button onclick="toggleAutoRefresh()" id="autoRefreshBtn" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Auto-actualisation ON
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- KPIs temps réel -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Visiteurs en ligne -->
            <div class="realtime-kpi bg-gradient-to-br from-green-500 to-emerald-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Visiteurs en ligne</p>
                        <p class="text-3xl font-bold" id="onlineVisitors">--</p>
                        <p class="text-green-100 text-xs mt-1">Actifs dernières 5 min</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <div class="w-3 h-3 bg-white rounded-full animate-ping"></div>
                    </div>
                </div>
            </div>

            <!-- Visiteurs aujourd'hui -->
            <div class="realtime-kpi bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Visiteurs aujourd'hui</p>
                        <p class="text-3xl font-bold" id="todayVisitors">--</p>
                        <p class="text-blue-100 text-xs mt-1">Depuis minuit</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pages vues -->
            <div class="realtime-kpi bg-gradient-to-br from-purple-500 to-pink-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Pages vues</p>
                        <p class="text-3xl font-bold" id="todayPageViews">--</p>
                        <p class="text-purple-100 text-xs mt-1">Aujourd'hui</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Clics WhatsApp -->
            <div class="realtime-kpi bg-gradient-to-br from-orange-500 to-red-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Clics WhatsApp</p>
                        <p class="text-3xl font-bold" id="todayWhatsAppClicks">--</p>
                        <p class="text-orange-100 text-xs mt-1">Aujourd'hui</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activité en temps réel -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Activité récente -->
            <div class="analytics-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Activité Récente</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                        Live
                    </span>
                </div>
                
                <div id="liveActivity" class="space-y-3 max-h-96 overflow-y-auto">
                    <!-- Activité en temps réel injectée ici -->
                </div>
            </div>

            <!-- Visiteurs récents -->
            <div class="analytics-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Visiteurs Récents</h3>
                
                <div id="recentVisitors" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- Visiteurs récents injectés ici -->
                </div>
            </div>
        </div>

        <!-- Pages populaires et sources de trafic -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pages populaires -->
            <div class="analytics-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Pages Populaires (Temps Réel)</h3>
                
                <div id="topPages" class="space-y-3">
                    <!-- Pages populaires injectées ici -->
                </div>
            </div>

            <!-- Sources de trafic -->
            <div class="analytics-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Sources de Trafic (Aujourd'hui)</h3>
                
                <div id="trafficSources" class="space-y-3">
                    <!-- Sources de trafic injectées ici -->
                </div>
            </div>
        </div>

        <!-- Carte géographique temps réel -->
        <div class="analytics-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Localisation des Visiteurs</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Carte (simulation) -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">Carte interactive des visiteurs</p>
                            <p class="text-sm text-gray-400 mt-1">Intégration Google Maps à venir</p>
                        </div>
                    </div>
                </div>

                <!-- Statistiques par région -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Répartition par région</h4>
                    <div id="regionStats" class="space-y-3">
                        <!-- Statistiques par région injectées ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let autoRefresh = true;
let refreshInterval;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    loadRealtimeData();
    startAutoRefresh();
});

// Chargement des données temps réel
function loadRealtimeData() {
    fetch('{{ route("admin.analytics.realtime") }}')
        .then(response => response.json())
        .then(data => {
            updateKPIs(data);
            updateLiveActivity(data.live_activity);
            updateRecentVisitors(data.recent_visitors);
            updateTopPages(data.top_pages);
            updateTrafficSources(data.traffic_sources);
            updateRegionStats(data);
            updateLastUpdate();
        })
        .catch(error => {
            console.error('Erreur lors du chargement des données:', error);
        });
}

// Mise à jour des KPIs
function updateKPIs(data) {
    document.getElementById('onlineVisitors').textContent = data.visitors_online || 0;
    document.getElementById('todayVisitors').textContent = data.todays_visitors || 0;
    document.getElementById('todayPageViews').textContent = data.todays_page_views || 0;
    document.getElementById('todayWhatsAppClicks').textContent = data.todays_whatsapp_clicks || 0;
}

// Mise à jour de l'activité en direct
function updateLiveActivity(activities) {
    const container = document.getElementById('liveActivity');
    
    if (!activities || activities.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucune activité récente</p>';
        return;
    }
    
    container.innerHTML = activities.map(activity => `
        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg animate-fadeIn">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">
                    Visiteur de ${activity.region || 'Localisation inconnue'}
                </p>
                <p class="text-xs text-gray-500">
                    ${activity.device_type} • ${activity.page_views} pages • ${activity.last_activity}
                </p>
            </div>
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Actif
                </span>
            </div>
        </div>
    `).join('');
}

// Mise à jour des visiteurs récents
function updateRecentVisitors(visitors) {
    const container = document.getElementById('recentVisitors');
    
    if (!visitors || visitors.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucun visiteur récent</p>';
        return;
    }
    
    container.innerHTML = visitors.map(visitor => `
        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">${visitor.location.charAt(0)}</span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">${visitor.location}</p>
                <p class="text-xs text-gray-500">${visitor.device} • ${visitor.browser}</p>
            </div>
            <div class="text-right">
                <div class="text-sm font-semibold text-gray-900">${visitor.page_views}</div>
                <div class="text-xs text-gray-500">pages</div>
            </div>
        </div>
    `).join('');
}

// Mise à jour des pages populaires
function updateTopPages(pages) {
    const container = document.getElementById('topPages');
    
    if (!pages || pages.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucune donnée disponible</p>';
        return;
    }
    
    container.innerHTML = pages.map((page, index) => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center">
                    <span class="text-xs font-semibold">${index + 1}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">${page.page}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-semibold text-gray-900">${page.views}</div>
                <div class="text-xs text-gray-500">vues</div>
            </div>
        </div>
    `).join('');
}

// Mise à jour des sources de trafic
function updateTrafficSources(sources) {
    const container = document.getElementById('trafficSources');
    
    if (!sources || sources.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucune donnée disponible</p>';
        return;
    }
    
    const total = sources.reduce((sum, source) => sum + source.visitors, 0);
    
    container.innerHTML = sources.map(source => {
        const percentage = total > 0 ? Math.round((source.visitors / total) * 100) : 0;
        return `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900">${source.source}</span>
                </div>
                <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900">${source.visitors}</div>
                    <div class="text-xs text-gray-500">${percentage}%</div>
                </div>
            </div>
        `;
    }).join('');
}

// Mise à jour des statistiques par région
function updateRegionStats(data) {
    const container = document.getElementById('regionStats');
    
    const regions = [
        { name: 'Abidjan', count: Math.floor(data.todays_visitors * 0.7), color: 'bg-blue-500' },
        { name: 'Intérieur', count: Math.floor(data.todays_visitors * 0.25), color: 'bg-green-500' },
        { name: 'International', count: Math.floor(data.todays_visitors * 0.05), color: 'bg-purple-500' }
    ];
    
    container.innerHTML = regions.map(region => `
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 ${region.color} rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">${region.name}</span>
            </div>
            <span class="text-sm font-semibold text-gray-900">${region.count}</span>
        </div>
    `).join('');
}

// Mise à jour de l'heure
function updateLastUpdate() {
    const now = new Date();
    document.getElementById('lastUpdate').textContent = now.toLocaleTimeString('fr-FR');
}

// Gestion de l'auto-actualisation
function startAutoRefresh() {
    refreshInterval = setInterval(loadRealtimeData, 10000); // 10 secondes
}

function stopAutoRefresh() {
    clearInterval(refreshInterval);
}

function toggleAutoRefresh() {
    const btn = document.getElementById('autoRefreshBtn');
    
    if (autoRefresh) {
        stopAutoRefresh();
        autoRefresh = false;
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Auto-actualisation OFF
        `;
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-secondary');
    } else {
        startAutoRefresh();
        autoRefresh = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Auto-actualisation ON
        `;
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-primary');
    }
}
</script>

@push('styles')
<style>
.realtime-kpi {
    @apply bg-white rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl;
}

.analytics-card {
    @apply bg-white rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl;
}

.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-blue-700 transition-all duration-200;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endpush
@endsection 