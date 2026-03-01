@extends('layouts.public')

@section('title', 'À Propos - LEBOSS TECH MARKET')
@section('description', 'Découvrez l\'histoire de LEBOSS TECH MARKET, spécialiste en informatique reconditionnée depuis 2019. Notre équipe, notre mission et notre engagement pour l\'économie circulaire.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white py-20">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in-up">
            À Propos de <span class="text-orange-500">LEBOSS TECH</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up animation-delay-200">
            Votre partenaire de confiance en informatique reconditionnée depuis 2019
        </p>
        <div class="mt-8 animate-fade-in-up animation-delay-400">
            <div class="inline-flex items-center bg-orange-500 text-white px-6 py-3 rounded-full">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span class="font-semibold">Depuis 2019</span>
            </div>
        </div>
    </div>
</section>

<!-- Notre Histoire -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Notre Histoire</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-6"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="bg-orange-50 p-6 rounded-lg border-l-4 border-orange-500">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">2019 - Les Débuts</h3>
                        <p class="text-gray-700 leading-relaxed">
                            LEBOSS TECH MARKET naît de la vision de démocratiser l'accès à l'informatique de qualité en Côte d'Ivoire. 
                            Fondée par GOH TANGUY BRUNO, notre entreprise débute avec une mission claire : offrir des solutions informatiques 
                            reconditionnées fiables et abordables.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-gray-400">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aujourd'hui</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Nous sommes devenus le spécialiste de référence en informatique reconditionnée à Abidjan, 
                            avec plus de 500 clients satisfaits et un processus de reconditionnement certifié qui garantit 
                            la qualité de nos produits.
                        </p>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8 rounded-2xl text-white text-center">
                        <div class="mb-6">
                            <i class="fas fa-trophy text-6xl text-orange-200"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">5 Années d'Excellence</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="text-3xl font-bold">500+</div>
                                <div class="text-sm">Clients Satisfaits</div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="text-3xl font-bold">1000+</div>
                                <div class="text-sm">Équipements Reconditionnés</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notre Mission -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Notre Mission</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-8"></div>
            
            <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-orange-100">
                <div class="text-6xl text-orange-500 mb-6">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-6">Démocratiser l'informatique par le reconditionné</h3>
                <p class="text-xl text-gray-700 leading-relaxed mb-8">
                    Notre mission est de rendre l'informatique de qualité accessible à tous en Côte d'Ivoire. 
                    Nous croyons que chacun mérite d'avoir accès aux meilleures technologies, sans compromis sur la qualité, 
                    tout en contribuant à un avenir plus durable.
                </p>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-hand-holding-heart text-2xl text-orange-500"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Accessibilité</h4>
                        <p class="text-sm text-gray-600">Prix justes pour tous</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-2xl text-orange-500"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Qualité</h4>
                        <p class="text-sm text-gray-600">Standards élevés garantis</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-leaf text-2xl text-orange-500"></i>
                        </div>
                        <h4 class="font-bold text-gray-900">Durabilité</h4>
                        <p class="text-sm text-gray-600">Respect de l'environnement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notre Équipe -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Notre Équipe</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600">Des experts passionnés à votre service</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($team as $member)
                <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $member['name'] }}</h3>
                        <p class="text-orange-500 font-semibold">{{ $member['position'] }}</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-900 mb-2">
                                <i class="fas fa-star text-orange-500 mr-2"></i>Expertise
                            </h4>
                            <p class="text-gray-700">{{ $member['expertise'] }}</p>
                        </div>
                        
                        <p class="text-gray-600 leading-relaxed">{{ $member['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Processus de Reconditionnement -->
<section class="py-16 bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Notre Processus de Reconditionnement</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-300">5 étapes rigoureuses pour garantir la qualité</p>
            </div>
            
            <div class="grid md:grid-cols-5 gap-6">
                @foreach($process as $step)
                <div class="text-center group relative">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $step['icon'] }} text-2xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-white text-orange-500 rounded-full flex items-center justify-center font-bold text-sm">
                            {{ $step['step'] }}
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold mb-3">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">{{ $step['description'] }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-2xl inline-block">
                    <h3 class="text-2xl font-bold mb-2">
                        <i class="fas fa-shield-alt mr-2"></i>Garantie 6 Mois
                    </h3>
                    <p class="text-orange-100">Tous nos produits sont garantis pièces et main d'œuvre</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partenaires et Certifications -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Nos Partenaires</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600">Nous travaillons avec les plus grandes marques</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center">
                @foreach($partners as $partner)
                <div class="text-center group">
                    <div class="bg-gray-50 p-6 rounded-2xl hover:bg-orange-50 transition-colors duration-300 group-hover:shadow-lg">
                        <div class="text-4xl text-gray-400 group-hover:text-orange-500 transition-colors duration-300 mb-2">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 group-hover:text-orange-500 transition-colors duration-300">
                            {{ $partner['name'] }}
                        </h3>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-certificate text-orange-500 mr-2"></i>Certifications
                    </h3>
                    <p class="text-gray-700 mb-6">
                        Nos techniciens sont certifiés par nos partenaires pour garantir un reconditionnement aux standards internationaux.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <span class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Certification Technique
                        </span>
                        <span class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Standards Qualité
                        </span>
                        <span class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Service Agréé
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Engagement Écologique -->
<section class="py-16 bg-green-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-leaf text-green-500 mr-2"></i>Engagement Écologique
                </h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600">Contribuer à l'économie circulaire et à la protection de l'environnement</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-recycle text-3xl text-green-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Économie Circulaire</h3>
                    </div>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Prolongation de la durée de vie des équipements informatiques</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Réduction des déchets électroniques</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                            <span>Optimisation des ressources existantes</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-globe-africa text-3xl text-green-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Impact Environnemental</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">70%</div>
                            <div class="text-sm text-gray-600">Réduction empreinte carbone vs neuf</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">1000+</div>
                            <div class="text-sm text-gray-600">Équipements sauvés de la casse</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages Clients -->
<section class="py-16 bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Ce que disent nos clients</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-300">Leur satisfaction est notre plus belle récompense</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="bg-gray-800 p-8 rounded-2xl hover:bg-gray-700 transition-colors duration-300">
                    <div class="mb-6">
                        <div class="flex text-orange-500 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $testimonial['rating'] ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <p class="text-gray-300 italic leading-relaxed">"{{ $testimonial['message'] }}"</p>
                    </div>
                    
                    <div class="border-t border-gray-600 pt-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white">{{ $testimonial['name'] }}</h4>
                                <p class="text-sm text-gray-400">{{ $testimonial['company'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold mb-6">Prêt à nous faire confiance ?</h2>
            <p class="text-xl text-orange-100 mb-8">
                Découvrez notre sélection d'ordinateurs, laptops et équipements informatiques reconditionnés de qualité
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="bg-white text-orange-500 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-laptop mr-2"></i>
                    Voir nos Produits
                </a>
                <a href="{{ route('contact.index') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-orange-500 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Nous Contacter
                </a>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}
</style>
@endsection 