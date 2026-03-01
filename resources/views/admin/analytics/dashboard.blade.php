@extends('layouts.app')

@section('title', 'Analytics Dashboard - LEBOSS TECH')

@section('content')
<!-- Dashboard Analytics Avancé -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header avec contrôles -->
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Analytics Dashboard
                    </h1>
                    <p class="text-gray-600 mt-1">Tableau de bord analytique avancé</p>
                </div>
                
                <!-- Contrôles de période -->
                <div class="flex items-center space-x-4">
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button class="period-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ ($period ?? '7d') == 'today' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}" 
                                data-period="today">Aujourd'hui</button>
                        <button class="period-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ ($period ?? '7d') == '7d' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}" 
                                data-period="7d">7 jours</button>
                        <button class="period-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ ($period ?? '7d') == '30d' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}" 
                                data-period="30d">30 jours</button>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="flex space-x-2">
                        <button class="btn-secondary" onclick="refreshDashboard()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Actualiser
                        </button>
                        <button class="btn-primary" onclick="exportData()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exporter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- KPIs Principaux -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Revenus -->
            <div class="kpi-card bg-gradient-to-br from-green-500 to-emerald-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Revenus</p>
                        <p class="text-3xl font-bold">{{ number_format($kpis['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Visiteurs -->
            <div class="kpi-card bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Visiteurs</p>
                        <p class="text-3xl font-bold">{{ number_format($kpis['total_visitors'] ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Commandes -->
            <div class="kpi-card bg-gradient-to-br from-purple-500 to-pink-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Commandes</p>
                        <p class="text-3xl font-bold">{{ number_format($kpis['total_orders'] ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Conversions WhatsApp -->
            <div class="kpi-card bg-gradient-to-br from-orange-500 to-red-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">WhatsApp</p>
                        <p class="text-3xl font-bold">{{ number_format($kpis['total_whatsapp_clicks'] ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques principaux -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Évolution des revenus -->
            <div class="analytics-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Évolution des Revenus</h3>
                    <div class="flex space-x-2">
                        <button class="chart-btn active" data-metric="revenue">Revenus</button>
                        <button class="chart-btn" data-metric="orders">Commandes</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="revenueChart" width="100%" height="320"></canvas>
                </div>
            </div>

            <!-- Évolution du trafic -->
            <div class="analytics-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Trafic & Conversions</h3>
                    <div class="flex space-x-2">
                        <button class="chart-btn active" data-metric="visitors">Visiteurs</button>
                        <button class="chart-btn" data-metric="conversion">Conversion</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="trafficChart" width="100%" height="320"></canvas>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="analytics-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Actions Rapides</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button class="action-btn" onclick="window.location.reload()">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Temps Réel</span>
                </button>
                
                <button class="action-btn" onclick="exportData()">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Exporter</span>
                </button>
                
                <button class="action-btn" onclick="refreshDashboard()">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Actualiser</span>
                </button>
                
                <button class="action-btn" onclick="alert('Fonctionnalité en développement')">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Alertes</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuration des graphiques
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        x: {
            grid: {
                display: false
            }
        },
        y: {
            grid: {
                color: 'rgba(0, 0, 0, 0.05)'
            },
            ticks: {
                callback: function(value) {
                    return new Intl.NumberFormat('fr-FR').format(value);
                }
            }
        }
    }
};

// Données par défaut
const defaultData = {
    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
    revenue: [0, 0, 0, 0, 0, 0, 0],
    visitors: [0, 0, 0, 0, 0, 0, 0]
};

// Récupération sécurisée des données
const chartData = {
    revenue: {
        labels: {!! json_encode(isset($chartData['revenue']) ? $chartData['revenue']->pluck('date')->toArray() : $defaultData['labels']) !!},
        data: {!! json_encode(isset($chartData['revenue']) ? $chartData['revenue']->pluck('value')->toArray() : $defaultData['revenue']) !!}
    },
    visitors: {
        labels: {!! json_encode(isset($chartData['visitors']) ? $chartData['visitors']->pluck('date')->toArray() : $defaultData['labels']) !!},
        data: {!! json_encode(isset($chartData['visitors']) ? $chartData['visitors']->pluck('value')->toArray() : $defaultData['visitors']) !!}
    }
};

// Graphique des revenus
if (document.getElementById('revenueChart')) {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: chartData.revenue.labels,
            datasets: [{
                label: 'Revenus',
                data: chartData.revenue.data,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: chartOptions
    });
}

// Graphique du trafic
if (document.getElementById('trafficChart')) {
    const trafficCtx = document.getElementById('trafficChart').getContext('2d');
    const trafficChart = new Chart(trafficCtx, {
        type: 'line',
        data: {
            labels: chartData.visitors.labels,
            datasets: [{
                label: 'Visiteurs',
                data: chartData.visitors.data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: chartOptions
    });
}

// Gestion des boutons de période
document.querySelectorAll('.period-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const period = this.dataset.period;
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('period', period);
        window.location.href = currentUrl.toString();
    });
});

// Gestion des boutons de graphique
document.querySelectorAll('.chart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const metric = this.dataset.metric;
        const parent = this.closest('.analytics-card');
        
        if (parent) {
            parent.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            console.log('Changement de métrique:', metric);
        }
    });
});

// Fonction pour actualiser le dashboard
function refreshDashboard() {
    window.location.reload();
}

// Fonction pour exporter les données
function exportData() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = 
        '<div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">' +
            '<h3 class="text-lg font-semibold mb-4">Exporter les données</h3>' +
            '<div class="space-y-4">' +
                '<div>' +
                    '<label class="block text-sm font-medium text-gray-700 mb-2">Format</label>' +
                    '<select id="exportFormat" class="w-full border border-gray-300 rounded-md px-3 py-2">' +
                        '<option value="excel">Excel (.xlsx)</option>' +
                        '<option value="csv">CSV</option>' +
                        '<option value="pdf">PDF</option>' +
                    '</select>' +
                '</div>' +
                '<div class="flex justify-end space-x-3 mt-6">' +
                    '<button onclick="closeExportModal()" class="btn-secondary">Annuler</button>' +
                    '<button onclick="performExport()" class="btn-primary">Exporter</button>' +
                '</div>' +
            '</div>' +
        '</div>';
    document.body.appendChild(modal);
}

function closeExportModal() {
    const modal = document.querySelector('.fixed.inset-0');
    if (modal) {
        modal.remove();
    }
}

function performExport() {
    const format = document.getElementById('exportFormat').value;
    console.log('Export en format:', format);
    alert('Export en cours... (Fonctionnalité en développement)');
    closeExportModal();
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard Analytics LEBOSS TECH chargé avec succès');
});
</script>
@endsection

@push('styles')
<style>
.kpi-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.kpi-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.analytics-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.analytics-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.chart-btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6B7280;
    background-color: #F3F4F6;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.chart-btn:hover {
    background-color: #E5E7EB;
}

.chart-btn.active {
    background-color: #2563EB;
    color: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    text-align: center;
    background-color: #F9FAFB;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.action-btn:hover {
    background-color: #F3F4F6;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background-color: #2563EB;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.btn-primary:hover {
    background-color: #1D4ED8;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background-color: #F3F4F6;
    color: #374151;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.btn-secondary:hover {
    background-color: #E5E7EB;
}
</style>
@endpush 