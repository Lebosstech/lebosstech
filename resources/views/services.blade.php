@extends('layouts.public')

@section('title', 'Nos Services - LEBOSS TECH | Solutions IT Entreprises')
@section('description', 'Découvrez les 7 domaines d\'expertise de LEBOSS TECH : vente de matériel, installation réseau, dépannage, impression, solutions numériques, marketing digital et conseil IT.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-navy-950 overflow-hidden py-24">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950"></div>
        <div class="absolute top-10 right-10 w-96 h-96 bg-leboss-500/8 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 text-center">
        <div class="inline-flex items-center bg-leboss-500/10 border border-leboss-500/20 text-leboss-400 px-4 py-1.5 rounded-full text-xs font-semibold mb-6 uppercase tracking-wider">
            <span class="w-2 h-2 bg-leboss-500 rounded-full mr-2 animate-pulse"></span>
            7 domaines d'expertise
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight tracking-tight">
            Nos <span class="text-transparent bg-clip-text bg-gradient-to-r from-leboss-400 to-leboss-500">Services</span>
        </h1>
        <p class="text-lg text-navy-300 max-w-2xl mx-auto leading-relaxed">
            De la fourniture de matériel à la transformation digitale, LEBOSS TECH couvre l'ensemble 
            de vos besoins IT avec une expertise reconnue.
        </p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $service)
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-1" id="service-{{ $index + 1 }}">
                    <!-- Card Header with inline gradient -->
                    <div class="p-5" style="background: {{ $service['gradient'] }};">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <i class="{{ $service['icon'] }} text-white text-lg"></i>
                                </div>
                                <span class="ml-3 text-white/70 text-xs font-semibold uppercase tracking-wider">Service {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-navy-900 mb-3 group-hover:text-leboss-500 transition-colors">
                            {{ $service['title'] }}
                        </h3>
                        <p class="text-navy-500 text-sm mb-5 leading-relaxed">
                            {{ $service['short_description'] }}
                        </p>
                        
                        <!-- Details -->
                        <ul class="space-y-2.5 mb-6">
                            @foreach($service['details'] as $detail)
                                <li class="flex items-start text-sm text-navy-600">
                                    <i class="fas fa-check mt-0.5 mr-2.5 flex-shrink-0 text-xs" style="color: {{ $service['check_color'] }};"></i>
                                    <span>{{ $detail }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- CTA -->
                        <div class="pt-5 border-t border-gray-100">
                            <a href="https://wa.me/2250566821609?text=Bonjour, je suis intéressé par votre service : {{ urlencode($service['title']) }}" 
                               target="_blank"
                               class="inline-flex items-center text-sm font-semibold hover:opacity-80 transition-opacity" style="color: {{ $service['check_color'] }};">
                                <i class="fab fa-whatsapp mr-2 text-base"></i>
                                Demander un devis
                                <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Notre Processus -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-leboss-50 text-leboss-600 px-4 py-1.5 rounded-full text-xs font-semibold mb-4 uppercase tracking-wider">
                Notre méthode
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-navy-900 mb-4">Comment nous travaillons</h2>
            <p class="text-navy-500 max-w-2xl mx-auto">Un processus structuré pour des résultats concrets et mesurables</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center relative">
                <div class="w-16 h-16 bg-navy-950 rounded-2xl flex items-center justify-center mx-auto mb-5 relative z-10">
                    <span class="text-white text-xl font-bold">01</span>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Analyse des besoins</h3>
                <p class="text-navy-500 text-sm">Nous étudions votre environnement et comprenons vos objectifs</p>
                <div class="hidden md:block absolute top-8 left-[60%] w-full h-px bg-navy-200"></div>
            </div>
            
            <div class="text-center relative">
                <div class="w-16 h-16 bg-leboss-500 rounded-2xl flex items-center justify-center mx-auto mb-5 relative z-10">
                    <span class="text-white text-xl font-bold">02</span>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Proposition sur mesure</h3>
                <p class="text-navy-500 text-sm">Devis détaillé avec planning et garanties adaptés</p>
                <div class="hidden md:block absolute top-8 left-[60%] w-full h-px bg-navy-200"></div>
            </div>
            
            <div class="text-center relative">
                <div class="w-16 h-16 bg-navy-950 rounded-2xl flex items-center justify-center mx-auto mb-5 relative z-10">
                    <span class="text-white text-xl font-bold">03</span>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Mise en œuvre</h3>
                <p class="text-navy-500 text-sm">Déploiement rapide par nos techniciens certifiés</p>
                <div class="hidden md:block absolute top-8 left-[60%] w-full h-px bg-navy-200"></div>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-leboss-500 rounded-2xl flex items-center justify-center mx-auto mb-5 relative z-10">
                    <span class="text-white text-xl font-bold">04</span>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Suivi & support</h3>
                <p class="text-navy-500 text-sm">Maintenance continue et support technique réactif</p>
            </div>
        </div>
    </div>
</section>

<!-- Avantages -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-navy-900 mb-4">Pourquoi choisir LEBOSS TECH ?</h2>
            <p class="text-navy-500 max-w-2xl mx-auto">Des avantages concrets qui font la différence</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all">
                <div class="w-12 h-12 bg-leboss-50 rounded-xl flex items-center justify-center mb-5">
                    <i class="fas fa-bolt text-leboss-500 text-lg"></i>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Intervention rapide</h3>
                <p class="text-navy-500 text-xs leading-relaxed">Réponse sous 24h et déplacement rapide sur site à Abidjan</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background-color: #eff6ff;">
                    <i class="fas fa-user-tie text-lg" style="color: #3b82f6;"></i>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Expertise technique</h3>
                <p class="text-navy-500 text-xs leading-relaxed">Techniciens formés aux standards Dell, HP, Lenovo et Cisco</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background-color: #f0fdf4;">
                    <i class="fas fa-shield-alt text-lg" style="color: #22c55e;"></i>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Garantie complète</h3>
                <p class="text-navy-500 text-xs leading-relaxed">Matériel garanti, contrats de maintenance et SLA personnalisés</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background-color: #faf5ff;">
                    <i class="fas fa-handshake text-lg" style="color: #a855f7;"></i>
                </div>
                <h3 class="text-sm font-bold text-navy-900 mb-2">Partenaire de confiance</h3>
                <p class="text-navy-500 text-xs leading-relaxed">500+ clients satisfaits, PME et institutions depuis 2019</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-navy-900 via-navy-950 to-navy-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-leboss-500/5 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto text-center px-6 sm:px-8 lg:px-10">
        <div class="inline-flex items-center bg-leboss-500/10 border border-leboss-500/20 text-leboss-400 px-4 py-1.5 rounded-full text-xs font-semibold mb-6 uppercase tracking-wider">
            Prêt à démarrer ?
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Parlons de votre projet</h2>
        <p class="text-navy-300 mb-10 leading-relaxed max-w-2xl mx-auto">
            Obtenez un devis gratuit et personnalisé en moins de 24h. 
            Notre équipe d'experts vous accompagne dans la réalisation de vos ambitions IT.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/2250566821609?text=Bonjour, j'aimerais avoir un devis pour un projet informatique" target="_blank" 
               class="bg-leboss-500 hover:bg-leboss-600 text-white px-8 py-4 rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-leboss-500/25 inline-flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2 text-lg"></i>
                Discuter sur WhatsApp
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
