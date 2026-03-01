@extends('layouts.public')

@section('title', 'LEBOSS TECH - Solutions Informatiques & Numériques | Abidjan')
@section('description', 'LEBOSS TECH : votre partenaire informatique de confiance. Vente de matériel, installation réseau, maintenance, solutions numériques et marketing digital à Abidjan.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-navy-950 overflow-hidden min-h-[600px] flex items-center">
    <!-- Background pattern -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;40&quot; height=&quot;40&quot; viewBox=&quot;0 0 40 40&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M20 20.5V18H0v-2h20v-2H0v-2h20v-2H0V8h20V6H0V4h20V2H0V0h22v20h2V0h2v20h2V0h2v20h2V0h2v20h2V0h2v20.5z&quot;/%3E%3C/g%3E%3C/svg%3E');"></div>
        <!-- Gradient orbs -->
        <div class="absolute top-20 right-20 w-96 h-96 bg-leboss-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-24 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center bg-leboss-500/10 border border-leboss-500/20 text-leboss-400 px-4 py-1.5 rounded-full text-xs font-semibold mb-6 tracking-wide uppercase">
                    <span class="w-2 h-2 bg-leboss-500 rounded-full mr-2 animate-pulse"></span>
                    Solutions IT pour entreprises
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight tracking-tight">
                    Votre partenaire<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-leboss-400 to-leboss-500">informatique</span><br>
                    de confiance
                </h1>
                <p class="text-lg text-navy-300 mb-10 leading-relaxed max-w-lg">
                    LEBOSS TECH accompagne les entreprises et professionnels dans leur transformation numérique. 
                    Matériel, réseaux, maintenance et solutions sur mesure.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('services.index') }}" 
                       class="bg-leboss-500 hover:bg-leboss-600 text-white px-8 py-3.5 rounded-lg text-sm font-semibold transition-all hover:shadow-lg hover:shadow-leboss-500/25 inline-flex items-center justify-center">
                        Découvrir nos services
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="https://wa.me/2250566821609?text=Bonjour, je souhaite un devis pour mon entreprise" target="_blank"
                       class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-8 py-3.5 rounded-lg text-sm font-semibold transition-all inline-flex items-center justify-center backdrop-blur-sm">
                        <i class="fab fa-whatsapp mr-2 text-green-400"></i>
                        Demander un devis
                    </a>
                </div>
            </div>

            <!-- Stats cards -->
            <div class="hidden lg:grid grid-cols-2 gap-4">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-12 h-12 bg-leboss-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-building text-leboss-400 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-1">500+</div>
                    <div class="text-navy-400 text-sm">Clients entreprises</div>
                </div>
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all mt-8">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-cogs text-blue-400 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-1">7</div>
                    <div class="text-navy-400 text-sm">Domaines d'expertise</div>
                </div>
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-1">5 ans</div>
                    <div class="text-navy-400 text-sm">D'expérience terrain</div>
                </div>
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all mt-8">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-headset text-purple-400 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-navy-400 text-sm">Support disponible</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Bar - Logos partenaires -->
<section class="bg-white border-b border-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <p class="text-xs text-navy-400 uppercase tracking-wider font-semibold mb-4 md:mb-0 whitespace-nowrap">Partenaires & marques</p>
            <div class="flex items-center space-x-10 md:space-x-14 opacity-40 grayscale">
                <span class="text-2xl font-bold text-navy-600 tracking-tight">Dell</span>
                <span class="text-2xl font-bold text-navy-600 tracking-tight">HP</span>
                <span class="text-2xl font-bold text-navy-600 tracking-tight">Lenovo</span>
                <span class="text-2xl font-bold text-navy-600 tracking-tight hidden sm:block">Microsoft</span>
                <span class="text-2xl font-bold text-navy-600 tracking-tight hidden md:block">Canon</span>
                <span class="text-2xl font-bold text-navy-600 tracking-tight hidden lg:block">Cisco</span>
            </div>
        </div>
    </div>
</section>

<!-- Nos Services -->
<section class="py-20 bg-gray-50 reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-leboss-50 text-leboss-600 px-4 py-1.5 rounded-full text-xs font-semibold mb-4 uppercase tracking-wider">
                Ce que nous faisons
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-navy-900 mb-4">Une expertise complète à votre service</h2>
            <p class="text-navy-500 max-w-2xl mx-auto">De la fourniture de matériel à la transformation digitale, LEBOSS TECH couvre l'ensemble de vos besoins IT</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $homeServices = [
                    ['icon' => 'fas fa-laptop', 'title' => 'Matériel informatique', 'desc' => 'Vente d\'ordinateurs, imprimantes et équipements réseau', 'color' => 'orange'],
                    ['icon' => 'fas fa-network-wired', 'title' => 'Réseaux & infrastructure', 'desc' => 'Installation LAN, Wi-Fi, câblage et serveurs', 'color' => 'blue'],
                    ['icon' => 'fas fa-tools', 'title' => 'Maintenance & support', 'desc' => 'Dépannage, maintenance préventive et corrective', 'color' => 'green'],
                    ['icon' => 'fas fa-print', 'title' => 'Services d\'impression', 'desc' => 'Documents professionnels, flyers, cartes de visite', 'color' => 'purple'],
                    ['icon' => 'fas fa-code', 'title' => 'Solutions numériques', 'desc' => 'Applications, sites web et outils métiers', 'color' => 'indigo'],
                    ['icon' => 'fas fa-bullhorn', 'title' => 'Marketing digital', 'desc' => 'Visibilité en ligne, SEO et réseaux sociaux', 'color' => 'pink'],
                    ['icon' => 'fas fa-handshake', 'title' => 'Conseil IT', 'desc' => 'Audit, conseil et transformation numérique', 'color' => 'teal'],
                ];
            @endphp

            @foreach($homeServices as $index => $svc)
                <a href="{{ route('services.index') }}#service-{{ $index + 1 }}" class="group">
                    <div class="bg-white rounded-xl p-6 h-full border border-gray-100 hover:border-leboss-200 hover:shadow-lg hover:shadow-leboss-500/5 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-{{ $svc['color'] }}-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="{{ $svc['icon'] }} text-{{ $svc['color'] }}-500 text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold text-navy-900 mb-2 group-hover:text-leboss-500 transition-colors">{{ $svc['title'] }}</h3>
                        <p class="text-navy-500 text-xs leading-relaxed">{{ $svc['desc'] }}</p>
                    </div>
                </a>
            @endforeach

            <!-- CTA Card -->
            <a href="{{ route('services.index') }}" class="group">
                <div class="bg-gradient-to-br from-navy-900 to-navy-800 rounded-xl p-6 h-full flex flex-col items-center justify-center text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-arrow-right text-white text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white mb-1">Tout voir</h3>
                    <p class="text-navy-400 text-xs">En détail</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Chiffres Clés -->
<section class="py-16 bg-navy-950 counter-section">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="500" data-suffix="+">0</div>
                <div class="text-navy-400 text-sm font-medium">Clients accompagnés</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-leboss-400 mb-2 counter" data-target="1000" data-suffix="+">0</div>
                <div class="text-navy-400 text-sm font-medium">Interventions réalisées</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="5" data-suffix=" ans">0</div>
                <div class="text-navy-400 text-sm font-medium">D'expérience</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-leboss-400 mb-2 counter" data-target="7" data-suffix="">0</div>
                <div class="text-navy-400 text-sm font-medium">Domaines d'expertise</div>
            </div>
        </div>
    </div>
</section>

<!-- Pourquoi LEBOSS TECH -->
<section class="py-20 bg-white reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center bg-leboss-50 text-leboss-600 px-4 py-1.5 rounded-full text-xs font-semibold mb-4 uppercase tracking-wider">
                    Pourquoi nous choisir
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-navy-900 mb-6">Un partenaire IT qui comprend vos enjeux</h2>
                <p class="text-navy-500 mb-8 leading-relaxed">
                    Depuis 2019, LEBOSS TECH accompagne les entreprises, PME et institutions dans l'optimisation 
                    de leur infrastructure informatique. Notre approche sur mesure garantit des solutions adaptées 
                    à vos besoins réels.
                </p>
                <div class="space-y-5">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-leboss-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-bolt text-leboss-500"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-navy-900 mb-1">Réactivité garantie</h3>
                            <p class="text-navy-500 text-sm">Intervention sous 24h et devis gratuit pour tous vos projets</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-user-tie text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-navy-900 mb-1">Expertise certifiée</h3>
                            <p class="text-navy-500 text-sm">Techniciens qualifiés, formés aux standards Dell, HP et Lenovo</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-shield-alt text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-navy-900 mb-1">Garantie & suivi</h3>
                            <p class="text-navy-500 text-sm">Matériel garanti 6 mois, maintenance préventive et support continu</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-purple-500"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-navy-900 mb-1">Service de proximité</h3>
                            <p class="text-navy-500 text-sm">Présent à Abidjan avec déplacement chez le client dans tout le district</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visual -->
            <div class="hidden lg:block">
                <div class="relative">
                    <div class="bg-gradient-to-br from-navy-50 to-leboss-50 rounded-2xl p-10">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white rounded-xl p-5 shadow-sm">
                                <i class="fas fa-laptop text-leboss-500 text-2xl mb-3"></i>
                                <h4 class="text-sm font-bold text-navy-900">Vente & Distribution</h4>
                                <p class="text-xs text-navy-500 mt-1">Matériel professionnel</p>
                            </div>
                            <div class="bg-white rounded-xl p-5 shadow-sm">
                                <i class="fas fa-network-wired text-blue-500 text-2xl mb-3"></i>
                                <h4 class="text-sm font-bold text-navy-900">Infrastructure</h4>
                                <p class="text-xs text-navy-500 mt-1">Réseaux & serveurs</p>
                            </div>
                            <div class="bg-white rounded-xl p-5 shadow-sm">
                                <i class="fas fa-code text-indigo-500 text-2xl mb-3"></i>
                                <h4 class="text-sm font-bold text-navy-900">Développement</h4>
                                <p class="text-xs text-navy-500 mt-1">Solutions sur mesure</p>
                            </div>
                            <div class="bg-white rounded-xl p-5 shadow-sm">
                                <i class="fas fa-headset text-green-500 text-2xl mb-3"></i>
                                <h4 class="text-sm font-bold text-navy-900">Support 24/7</h4>
                                <p class="text-xs text-navy-500 mt-1">Assistance continue</p>
                            </div>
                        </div>
                    </div>
                    <!-- Floating badge -->
                    <div class="absolute -bottom-4 -right-4 bg-leboss-500 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-leboss-500/30 text-sm font-bold">
                        Depuis 2019 <i class="fas fa-check-circle ml-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-20 bg-gray-50 reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-leboss-50 text-leboss-600 px-4 py-1.5 rounded-full text-xs font-semibold mb-4 uppercase tracking-wider">
                Notre catalogue
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-navy-900 mb-4">Nos Catégories de Produits</h2>
            <p class="text-navy-500 max-w-2xl mx-auto">Matériel informatique professionnel neuf et reconditionné, garanti et testé</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}" class="group">
                    <div class="bg-white rounded-xl p-6 border border-gray-100 hover:border-leboss-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-leboss-50 rounded-xl flex items-center justify-center">
                                @switch($category->slug)
                                    @case('ordinateurs-bureau')
                                        <i class="fas fa-desktop text-leboss-500 text-lg"></i>
                                        @break
                                    @case('ordinateurs-portables')
                                        <i class="fas fa-laptop text-leboss-500 text-lg"></i>
                                        @break
                                    @case('imprimantes-laser')
                                        <i class="fas fa-print text-leboss-500 text-lg"></i>
                                        @break
                                    @case('ecrans-moniteurs')
                                        <i class="fas fa-tv text-leboss-500 text-lg"></i>
                                        @break
                                    @default
                                        <i class="fas fa-computer text-leboss-500 text-lg"></i>
                                @endswitch
                            </div>
                            <span class="text-xs font-semibold text-navy-400 bg-navy-50 px-3 py-1 rounded-full">{{ $category->products_count }} produits</span>
                        </div>
                        <h3 class="text-base font-bold text-navy-900 group-hover:text-leboss-500 transition-colors mb-1">{{ $category->name }}</h3>
                        <p class="text-navy-500 text-sm">{{ $category->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-20 bg-white reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex items-end justify-between mb-12">
            <div>
                <div class="inline-flex items-center bg-leboss-50 text-leboss-600 px-4 py-1.5 rounded-full text-xs font-semibold mb-4 uppercase tracking-wider">
                    Produits vedettes
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-navy-900">Nos meilleures offres</h2>
            </div>
            <a href="{{ route('products.index') }}" class="hidden md:inline-flex items-center text-leboss-500 hover:text-leboss-600 text-sm font-semibold">
                Voir tout le catalogue <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl border border-gray-100 hover:border-leboss-200 hover:shadow-lg transition-all duration-300 overflow-hidden group hover:-translate-y-1">
                    <div class="relative">
                        @if($product->getFirstMediaUrl('images'))
                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-navy-50 to-gray-100 flex items-center justify-center">
                                <i class="fas fa-image text-navy-200 text-4xl"></i>
                            </div>
                        @endif
                        @if($product->stock > 0)
                            <span class="absolute top-3 right-3 bg-green-500 text-white text-xs px-2.5 py-1 rounded-full font-semibold">En stock</span>
                        @else
                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2.5 py-1 rounded-full font-semibold">Rupture</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="text-xs text-leboss-500 font-semibold">{{ $product->category->name }}</span>
                        <h3 class="font-bold text-navy-900 mt-1 mb-2 text-sm line-clamp-2 group-hover:text-leboss-500 transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-lg font-bold text-navy-900">{{ number_format($product->price, 0, ',', ' ') }} <span class="text-xs text-navy-400 font-normal">FCFA</span></span>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('products.show', $product->slug) }}" class="flex-1 bg-navy-50 hover:bg-navy-100 text-navy-700 text-center py-2.5 rounded-lg text-xs font-semibold transition-colors">
                                Détails
                            </a>
                            <a href="{{ $product->whatsapp_url }}" target="_blank" onclick="fetch('{{ route('products.whatsapp-click', $product) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})"
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2.5 rounded-lg text-xs font-semibold transition-colors">
                                <i class="fab fa-whatsapp mr-1"></i>Commander
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-leboss-500 hover:text-leboss-600 text-sm font-semibold">
                Voir tout le catalogue <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Partenariat -->
<section class="py-20 bg-gradient-to-br from-navy-900 via-navy-950 to-navy-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-leboss-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto text-center px-6 sm:px-8 lg:px-10">
        <div class="inline-flex items-center bg-leboss-500/10 border border-leboss-500/20 text-leboss-400 px-4 py-1.5 rounded-full text-xs font-semibold mb-6 uppercase tracking-wider">
            Collaborons ensemble
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Prêt à moderniser votre infrastructure IT ?</h2>
        <p class="text-navy-300 mb-10 leading-relaxed max-w-2xl mx-auto">
            Que vous soyez une PME, une grande entreprise ou une institution, 
            LEBOSS TECH vous propose des solutions adaptées à votre budget et à vos objectifs. 
            Devis gratuit et sans engagement.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/2250566821609?text=Bonjour, je souhaite discuter d'un projet informatique pour mon entreprise" target="_blank" 
               class="bg-leboss-500 hover:bg-leboss-600 text-white px-8 py-4 rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-leboss-500/25 inline-flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2 text-lg"></i>
                Discuter de votre projet
            </a>
            <a href="{{ route('contact.index') }}" 
               class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-8 py-4 rounded-xl text-sm font-semibold transition-all inline-flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-envelope mr-2"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Slider functionality
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentSlide = 0;
    
    if (slides.length > 1) {
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
                slide.style.opacity = i === index ? '1' : '0';
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-opacity-100', i === index);
                dot.classList.toggle('bg-opacity-50', i !== index);
            });
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }
        
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        
        setInterval(nextSlide, 6000);
    }
});
</script>
@endpush