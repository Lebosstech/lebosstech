<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LEBOSS TECH MARKET - Appareils Électroniques de Qualité')</title>
    <meta name="description" content="@yield('description', 'Découvrez notre large gamme d\'appareils électroniques de qualité chez LEBOSS TECH MARKET. Commandez facilement via WhatsApp.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Navigation - Version agrandie -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <img class="h-12 w-auto" src="/images/logo.jpg" alt="LEBOSS TECH MARKET" onerror="this.style.display='none'">
                        <span class="ml-3 text-2xl font-bold text-leboss-500">LEBOSS TECH</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-leboss-500 px-4 py-3 rounded-md text-lg font-semibold transition-colors">
                        Accueil
                    </a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-leboss-500 px-4 py-3 rounded-md text-lg font-semibold transition-colors">
                        Produits
                    </a>
                    
                    <!-- Barre de recherche agrandie -->
                    <div class="relative">
                        <form method="GET" action="{{ route('search.index') }}" class="flex">
                            <input type="text" 
                                   name="q" 
                                   placeholder="Rechercher..."
                                   class="w-72 px-4 py-2.5 text-base border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-leboss-500 focus:border-transparent"
                                   id="navSearchInput">
                            <button type="submit" class="px-5 py-2.5 bg-leboss-500 text-white rounded-r-lg hover:bg-leboss-600 focus:outline-none focus:ring-2 focus:ring-leboss-500">
                                <i class="fas fa-search text-lg"></i>
                            </button>
                        </form>
                    </div>
                    

                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-leboss-500 px-4 py-3 rounded-md text-lg font-semibold transition-colors">
                        Contact
                    </a>
                    <a href="https://wa.me/2250566821609" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg font-semibold transition-colors">
                        <i class="fab fa-whatsapp mr-2 text-xl"></i>WhatsApp
                    </a>
                </div>

                <!-- Mobile menu button agrandi -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-3 rounded-lg text-gray-700 hover:text-leboss-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-leboss-500">
                        <span class="sr-only">Ouvrir le menu principal</span>
                        <svg class="block h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu agrandi -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-4 pt-4 pb-4 space-y-2 sm:px-6 bg-white shadow-lg">
                <!-- Barre de recherche mobile agrandie -->
                <div class="px-2 py-3">
                    <form method="GET" action="{{ route('search.index') }}" class="flex">
                        <input type="text" 
                               name="q" 
                               placeholder="Rechercher un produit..."
                               class="flex-1 px-4 py-3 text-base border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-leboss-500">
                        <button type="submit" class="px-5 py-3 bg-leboss-500 text-white rounded-r-lg hover:bg-leboss-600">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                    </form>
                </div>
                
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-leboss-500 block px-4 py-3 rounded-lg text-lg font-semibold">Accueil</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-leboss-500 block px-4 py-3 rounded-lg text-lg font-semibold">Produits</a>
                <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-leboss-500 block px-4 py-3 rounded-lg text-lg font-semibold">Contact</a>
                <a href="https://wa.me/2250566821609" target="_blank" class="bg-green-500 hover:bg-green-600 text-white block px-4 py-3 rounded-lg text-lg font-semibold">
                    <i class="fab fa-whatsapp mr-2 text-xl"></i>WhatsApp
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content avec marge ajustée -->
    <main class="pt-20">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img class="h-8 w-auto" src="/images/logo.jpg" alt="LEBOSS TECH MARKET" onerror="this.style.display='none'">
                        <span class="ml-2 text-xl font-bold">LEBOSS TECH MARKET</span>
                    </div>
                    <p class="text-orange-100 mb-4">
                        Votre partenaire de confiance pour tous vos besoins en appareils électroniques. 
                        Qualité, service et satisfaction garantis.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/2250566821609" target="_blank" class="text-green-400 hover:text-green-300">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>
                        <a href="mailto:contact@lebosstech.store" class="text-orange-200 hover:text-white">
                            <i class="fas fa-envelope text-2xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Accueil</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white">Produits</a></li>
                        <li><a href="{{ route('about.index') }}" class="text-gray-300 hover:text-white">À Propos</a></li>
                        <li><a href="{{ route('terms.index') }}" class="text-gray-300 hover:text-white">Conditions de Vente</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-orange-100">
                        <li>
                            <i class="fas fa-phone mr-2"></i>
                            +225 05 66 82 16 09
                        </li>
                        <li>
                            <i class="fas fa-envelope mr-2"></i>
                            contact@lebosstech.store
                        </li>
                        <li>
                            <i class="fas fa-globe mr-2"></i>
                            www.lebosstech.store
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Macory Anoumabo, Abidjan
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-orange-400">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-orange-100 text-sm">
                        © {{ date('Y') }} LEBOSS TECH MARKET. Tous droits réservés.
                    </p>
                    <div class="mt-4 md:mt-0">
                        <a href="#" class="text-orange-100 hover:text-white text-sm">Politique de confidentialité</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/2250566821609" target="_blank" class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110 z-50">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>

    <!-- Include WhatsApp Order Modal Component -->
    @include('components.whatsapp-order-modal')

    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html> 