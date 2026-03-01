@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Nouvelle Catégorie</h1>
                    <p class="text-gray-600 mt-2">Ajouter une nouvelle catégorie - LEBOSS TECH MARKET</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Interface en développement</h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Le formulaire de création de catégorie est en cours de développement. Interface complète bientôt disponible.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center py-12">
                    <i class="fas fa-plus-circle text-green-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Création de Catégorie</h3>
                    <p class="text-gray-500 mb-6">Formulaire de création complet en cours de développement.</p>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6 max-w-md mx-auto">
                        <h4 class="text-sm font-medium text-gray-800 mb-2">🚧 Fonctionnalités prévues :</h4>
                        <ul class="text-sm text-gray-600 text-left list-disc list-inside space-y-1">
                            <li>Nom et description</li>
                            <li>Icône personnalisée</li>
                            <li>Image de catégorie</li>
                            <li>Sous-catégories</li>
                            <li>Ordre d'affichage</li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('admin.categories.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
