<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LEBOSS TECH - Solutions Informatiques & Numériques')</title>
    <meta name="description" content="@yield('description', 'LEBOSS TECH : votre partenaire informatique de confiance à Abidjan. Vente de matériel, réseaux, maintenance, solutions numériques et marketing digital.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <!-- Top Bar -->
    <div class="bg-navy-950 text-navy-300 text-xs py-2 hidden md:block">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <span><i class="fas fa-phone-alt mr-1.5 text-leboss-500"></i>+225 05 66 82 16 09</span>
                <span><i class="fas fa-envelope mr-1.5 text-leboss-500"></i>contact@lebosstech.ci</span>
                <span><i class="fas fa-map-marker-alt mr-1.5 text-leboss-500"></i>Macory Anoumabo, Abidjan</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/2250566821609" target="_blank" class="hover:text-white transition-colors"><i class="fab fa-whatsapp"></i></a>
                <a href="mailto:contact@lebosstech.ci" class="hover:text-white transition-colors"><i class="fas fa-envelope"></i></a>
                <span class="text-navy-600">|</span>
                <a href="https://www.lebosstech.ci" class="hover:text-white transition-colors">www.lebosstech.ci</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100" id="mainNav">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="flex justify-between h-18">
                <div class="flex items-center py-3">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="/images/logo.jpg" alt="LEBOSS TECH" onerror="this.style.display='none'">
                        <div class="ml-3">
                            <span class="text-xl font-bold text-navy-900">LEBOSS</span>
                            <span class="text-xl font-bold text-leboss-500"> TECH</span>
                        </div>
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="nav-link text-navy-700 hover:text-leboss-500 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'text-leboss-500 bg-leboss-50' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('services.index') }}" class="nav-link text-navy-700 hover:text-leboss-500 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('services.*') ? 'text-leboss-500 bg-leboss-50' : '' }}">
                        Services
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link text-navy-700 hover:text-leboss-500 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('products.*') ? 'text-leboss-500 bg-leboss-50' : '' }}">
                        Produits
                    </a>
                    <a href="{{ route('about.index') }}" class="nav-link text-navy-700 hover:text-leboss-500 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('about.*') ? 'text-leboss-500 bg-leboss-50' : '' }}">
                        À Propos
                    </a>
                    <a href="{{ route('contact.index') }}" class="nav-link text-navy-700 hover:text-leboss-500 px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('contact.*') ? 'text-leboss-500 bg-leboss-50' : '' }}">
                        Contact
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-3">
                    <!-- Search -->
                    <form method="GET" action="{{ route('search.index') }}" class="flex">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Rechercher..."
                                   class="w-48 px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-leboss-500/30 focus:border-leboss-500 bg-gray-50"
                                   id="navSearchInput">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-leboss-500">
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                    </form>
                    <a href="https://wa.me/2250566821609?text=Bonjour, je souhaite un devis" target="_blank" 
                       class="bg-leboss-500 hover:bg-leboss-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all hover:shadow-lg hover:shadow-leboss-500/25 inline-flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i>Demander un devis
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-lg text-navy-700 hover:text-leboss-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden lg:hidden">
            <div class="px-4 pt-3 pb-4 space-y-1 bg-white shadow-lg border-t border-gray-100">
                <form method="GET" action="{{ route('search.index') }}" class="flex mb-3">
                    <input type="text" name="q" placeholder="Rechercher..."
                           class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-leboss-500">
                    <button type="submit" class="px-4 py-2.5 bg-leboss-500 text-white rounded-r-lg hover:bg-leboss-600">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <a href="{{ route('home') }}" class="text-navy-700 hover:text-leboss-500 hover:bg-leboss-50 block px-4 py-2.5 rounded-lg text-sm font-semibold">Accueil</a>
                <a href="{{ route('services.index') }}" class="text-navy-700 hover:text-leboss-500 hover:bg-leboss-50 block px-4 py-2.5 rounded-lg text-sm font-semibold">Services</a>
                <a href="{{ route('products.index') }}" class="text-navy-700 hover:text-leboss-500 hover:bg-leboss-50 block px-4 py-2.5 rounded-lg text-sm font-semibold">Produits</a>
                <a href="{{ route('about.index') }}" class="text-navy-700 hover:text-leboss-500 hover:bg-leboss-50 block px-4 py-2.5 rounded-lg text-sm font-semibold">À Propos</a>
                <a href="{{ route('contact.index') }}" class="text-navy-700 hover:text-leboss-500 hover:bg-leboss-50 block px-4 py-2.5 rounded-lg text-sm font-semibold">Contact</a>
                <a href="https://wa.me/2250566821609" target="_blank" class="bg-leboss-500 hover:bg-leboss-600 text-white block px-4 py-2.5 rounded-lg text-sm font-semibold mt-2">
                    <i class="fab fa-whatsapp mr-2"></i>Demander un devis
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 mx-4 mt-4 rounded-r-lg" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 mx-4 mt-4 rounded-r-lg" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Corporate -->
    <footer class="bg-navy-950 text-white">
        <!-- Main Footer -->
        <div class="max-w-7xl mx-auto py-16 px-6 sm:px-8 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center mb-6">
                        <img class="h-8 w-auto" src="/images/logo.jpg" alt="LEBOSS TECH" onerror="this.style.display='none'">
                        <div class="ml-2">
                            <span class="text-lg font-bold text-white">LEBOSS</span>
                            <span class="text-lg font-bold text-leboss-500"> TECH</span>
                        </div>
                    </div>
                    <p class="text-navy-300 text-sm leading-relaxed mb-6">
                        Votre partenaire informatique de confiance. Solutions IT complètes pour entreprises et professionnels en Côte d'Ivoire.
                    </p>
                    <div class="flex space-x-3">
                        <a href="https://wa.me/2250566821609" target="_blank" class="w-9 h-9 bg-navy-800 hover:bg-green-600 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                        <a href="mailto:contact@lebosstech.ci" class="w-9 h-9 bg-navy-800 hover:bg-leboss-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fas fa-envelope text-sm"></i>
                        </a>
                        <a href="https://www.lebosstech.ci" target="_blank" class="w-9 h-9 bg-navy-800 hover:bg-leboss-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fas fa-globe text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Nos Services</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('services.index') }}#service-1" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Distribution de matériel</a></li>
                        <li><a href="{{ route('services.index') }}#service-2" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Installation réseau</a></li>
                        <li><a href="{{ route('services.index') }}#service-3" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Maintenance informatique</a></li>
                        <li><a href="{{ route('services.index') }}#service-4" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Services d'impression</a></li>
                        <li><a href="{{ route('services.index') }}#service-5" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Solutions numériques</a></li>
                        <li><a href="{{ route('services.index') }}#service-6" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Marketing digital</a></li>
                    </ul>
                </div>

                <!-- Liens -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Liens Rapides</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Accueil</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Services</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Produits</a></li>
                        <li><a href="{{ route('about.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">À Propos</a></li>
                        <li><a href="{{ route('terms.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Conditions de Vente</a></li>
                        <li><a href="{{ route('warranty.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Information Garantie</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-navy-300 hover:text-leboss-400 text-sm transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Contact</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-leboss-500 mt-1 mr-3 w-4"></i>
                            <span class="text-navy-300">Macory Anoumabo,<br>Abidjan, Côte d'Ivoire</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt text-leboss-500 mr-3 w-4"></i>
                            <a href="tel:+2250566821609" class="text-navy-300 hover:text-white transition-colors">+225 05 66 82 16 09</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-leboss-500 mr-3 w-4"></i>
                            <a href="mailto:contact@lebosstech.ci" class="text-navy-300 hover:text-white transition-colors">contact@lebosstech.ci</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-globe text-leboss-500 mr-3 w-4"></i>
                            <span class="text-navy-300">www.lebosstech.ci</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-navy-800">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-navy-400 text-xs">
                    © {{ date('Y') }} LEBOSS TECH. Tous droits réservés. | SARL au capital social
                </p>
                <div class="mt-3 md:mt-0 flex items-center space-x-6">
                    <a href="{{ route('terms.index') }}" class="text-navy-400 hover:text-white text-xs transition-colors">Conditions de Vente</a>
                    <a href="#" class="text-navy-400 hover:text-white text-xs transition-colors">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/2250566821609" target="_blank" 
       class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg shadow-green-500/30 transition-all duration-300 hover:scale-110 z-50 group">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span class="absolute right-full mr-3 bg-navy-900 text-white text-xs px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
            Discuter sur WhatsApp
        </span>
    </a>

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

        // Scroll reveal animation
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });

        // Animated counters
        function animateCounters() {
            document.querySelectorAll('.counter').forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const suffix = counter.getAttribute('data-suffix') || '';
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target + suffix;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current) + suffix;
                    }
                }, 16);
            });
        }

        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        const counterSection = document.querySelector('.counter-section');
        if (counterSection) counterObserver.observe(counterSection);
    </script>
</body>
</html>