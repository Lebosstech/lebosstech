@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Administration</h1>
                    <p class="text-gray-600 mt-2">Tableau de bord - LEBOSS TECH MARKET</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Products -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100">
                                <i class="fas fa-box text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-blue-600">Total Produits</h2>
                                <p class="text-2xl font-semibold text-blue-900">{{ $totalProducts }}</p>
                                <p class="text-xs text-blue-600">{{ $activeProducts }} actifs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Categories -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <i class="fas fa-tags text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-green-600">Catégories</h2>
                                <p class="text-2xl font-semibold text-green-900">{{ $totalCategories }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Contacts -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100">
                                <i class="fas fa-envelope text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-purple-600">Messages</h2>
                                <p class="text-2xl font-semibold text-purple-900">{{ $totalContacts }}</p>
                                @if($unreadContacts > 0)
                                    <p class="text-xs text-red-600">{{ $unreadContacts }} non lu(s)</p>
                                @else
                                    <p class="text-xs text-purple-600">Tous lus</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Clicks -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100">
                                <i class="fab fa-whatsapp text-yellow-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-yellow-600">Clics WhatsApp</h2>
                                <p class="text-2xl font-semibold text-yellow-900">{{ $totalWhatsappClicks }}</p>
                                <p class="text-xs text-yellow-600">Total</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Products -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Produits Récents</h3>
                                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Voir tout
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($recentProducts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentProducts as $product)
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @if($product->getFirstMediaUrl('images'))
                                                    <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                                <p class="text-sm font-semibold text-blue-600">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                                @if($product->stock <= 0)
                                                    <p class="text-xs text-red-600 mt-1">Rupture</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-box text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Aucun produit récent</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Contacts -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Messages Récents</h3>
                                <span class="text-sm text-gray-500">{{ $recentContacts->count() }} message(s)</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($recentContacts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentContacts as $contact)
                                        <div class="border-l-4 {{ $contact->is_read ? 'border-gray-300' : 'border-blue-500' }} pl-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900">{{ $contact->name }}</p>
                                                    <p class="text-sm text-gray-600">{{ $contact->email }}</p>
                                                    @if($contact->subject)
                                                        <p class="text-sm font-medium text-gray-700 mt-1">{{ $contact->subject }}</p>
                                                    @endif
                                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $contact->message }}</p>
                                                    <p class="text-xs text-gray-400 mt-2">{{ $contact->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if(!$contact->is_read)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Nouveau
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-envelope text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Aucun message récent</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <a href="{{ route('admin.products.create') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Nouveau Produit
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                            <i class="fas fa-tags mr-2"></i>
                            Nouvelle Catégorie
                        </a>
                        <a href="{{ route('admin.sliders.create') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                            <i class="fas fa-images mr-2"></i>
                            Nouveau Slider
                        </a>
                        <a href="{{ route('admin.analytics.dashboard') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-chart-line mr-2"></i>
                            Analytics Avancés
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Voir le Site
                        </a>
                    </div>
                </div>

                <!-- Analytics Preview -->
                <div class="mt-8">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">🚀 Nouveau : Analytics Avancés</h3>
                                <p class="text-gray-600 mb-4">Découvrez notre système d'analytics complet avec KPIs temps réel, graphiques interactifs, analyse géographique et alertes personnalisées.</p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        📊 KPIs Temps Réel
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🌍 Analyse Géographique
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        🚨 Alertes Intelligentes
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        📈 Graphiques Interactifs
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('admin.analytics.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-chart-bar mr-2"></i>
                                    Dashboard Analytics
                                </a>
                                <a href="{{ route('admin.analytics.realtime') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Temps Réel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 