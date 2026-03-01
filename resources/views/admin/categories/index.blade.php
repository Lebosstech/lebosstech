@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
                    <p class="text-gray-600 mt-2">Gérez vos catégories - LEBOSS TECH MARKET</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Vue en développement</h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Cette page est en cours de développement. Interface complète bientôt disponible.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center py-12">
                    <i class="fas fa-tags text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gestion des Catégories</h3>
                    <p class="text-gray-500 mb-6">Interface de gestion complète en cours de développement.</p>
                    <a href="{{ route('admin.dashboard') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
