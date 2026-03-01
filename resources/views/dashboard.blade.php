@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold mb-4">Tableau de bord utilisateur</h1>
                <p class="mb-4">{{ __("You're logged in!") }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Bienvenue chez LEBOSS TECH</h3>
                        <p class="text-blue-700">Découvrez nos produits électroniques reconditionnés de qualité.</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Voir les produits
                        </a>
                    </div>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Mon Profil</h3>
                        <p class="text-green-700">Gérez vos informations personnelles et préférences.</p>
                        <a href="{{ route('profile.edit') }}" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Modifier le profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
