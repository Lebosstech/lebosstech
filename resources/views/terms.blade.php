@extends('layouts.public')

@section('title', 'Conditions de Vente - LEBOSS TECH MARKET')
@section('description', 'Consultez nos conditions générales de vente, politique de garantie 90 jours, modalités de livraison et de retour pour vos achats d\'équipements informatiques reconditionnés.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white py-16">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in-up">
            <i class="fas fa-file-contract text-orange-500 mr-3"></i>
            Conditions de Vente
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up animation-delay-200">
            Conditions générales de vente et mentions légales de LEBOSS TECH MARKET
        </p>
        <div class="mt-8 animate-fade-in-up animation-delay-400">
            <div class="inline-flex items-center bg-orange-500 text-white px-6 py-3 rounded-full">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span class="font-semibold">Dernière mise à jour : {{ date('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Rapide Fixe -->
<div class="sticky top-16 bg-white border-b border-gray-200 shadow-sm z-40">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-3">
            <h2 class="text-lg font-semibold text-gray-900">Navigation Rapide</h2>
            <button id="toggleNav" class="md:hidden bg-orange-500 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div id="quickNav" class="hidden md:block pb-3">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach($navigation as $nav)
                <a href="#{{ $nav['id'] }}" class="nav-link text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-600 px-3 py-2 rounded-lg transition-colors text-center">
                    {{ $nav['title'] }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Contenu Principal -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <div class="bg-white p-8 rounded-2xl shadow-lg mb-8 animate-fade-in-up">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-2xl text-orange-500"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Bienvenue chez LEBOSS TECH MARKET</h2>
                </div>
                <div class="bg-orange-50 p-6 rounded-lg border-l-4 border-orange-500">
                    <p class="text-gray-700 leading-relaxed">
                        Les présentes Conditions Générales de Vente définissent les droits et obligations 
                        de LEBOSS TECH MARKET et de ses clients dans le cadre de la vente d'équipements 
                        informatiques reconditionnés. Nous nous engageons à respecter la réglementation 
                        ivoirienne et à offrir un service de qualité à tous nos clients.
                    </p>
                </div>
                
                <!-- Points Clés -->
                <div class="grid md:grid-cols-3 gap-6 mt-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shield-alt text-green-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">Garantie 90 Jours</h3>
                        <p class="text-sm text-gray-600">Sur tous nos produits reconditionnés</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-undo text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">Retour 3 Jours</h3>
                        <p class="text-sm text-gray-600">Droit de rétractation garanti</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-truck text-purple-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">Livraison Sécurisée</h3>
                        <p class="text-sm text-gray-600">Abidjan et intérieur du pays</p>
                    </div>
                </div>
            </div>

            <!-- Articles des Conditions -->
            @foreach($sections as $section)
            <div id="{{ $section['id'] }}" class="bg-white p-8 rounded-2xl shadow-lg mb-6 article-section animate-fade-in-up">
                <div class="flex items-start mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="{{ $section['icon'] }} text-orange-500"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $section['title'] }}</h2>
                        <div class="w-16 h-1 bg-orange-500"></div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @foreach($section['content'] as $paragraph)
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">{{ $paragraph }}</p>
                    </div>
                    @endforeach
                </div>
                
                <!-- Bouton retour en haut pour chaque section -->
                <div class="mt-6 text-center">
                    <a href="#" class="inline-flex items-center text-orange-500 hover:text-orange-600 text-sm font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Retour en haut
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Section Contact et Support -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8 rounded-2xl text-white text-center animate-fade-in-up">
                <h2 class="text-2xl font-bold mb-4">Questions sur nos Conditions de Vente ?</h2>
                <p class="text-orange-100 mb-6">
                    Notre équipe est à votre disposition pour toute clarification ou information complémentaire.
                </p>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <a href="https://wa.me/2250566821609" target="_blank" class="bg-white text-orange-500 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp Support
                    </a>
                    <a href="mailto:contact@lebosstech.store" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-orange-500 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Contact
                    </a>
                </div>
                
                <div class="mt-6 text-orange-100 text-sm">
                    <p>Réponse garantie sous 24h • Support 7j/7 • Conseils personnalisés</p>
                </div>
            </div>

            <!-- Section Informations Légales Complémentaires -->
            <div class="bg-gray-800 text-white p-8 rounded-2xl mt-8 animate-fade-in-up">
                <h2 class="text-xl font-bold mb-6 text-center">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    Informations Légales Complémentaires
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-bold mb-3 text-orange-500">Entreprise</h3>
                        <ul class="space-y-2 text-gray-300 text-sm">
                            <li><strong>Raison sociale :</strong> LEBOSS TECH MARKET</li>
                            <li><strong>Forme juridique :</strong> Société A Responsabilité Limitée</li>
                            <li><strong>Dirigeant :</strong> GOH TANGUY BRUNO</li>
                            <li><strong>Secteur d'activité :</strong> Vente équipements informatiques</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold mb-3 text-orange-500">Contact</h3>
                        <ul class="space-y-2 text-gray-300 text-sm">
                            <li><strong>Adresse :</strong> Macory Anoumabo, Abidjan</li>
                            <li><strong>Téléphone :</strong> +225 05 66 82 16 09</li>
                            <li><strong>Email :</strong> contact@lebosstech.store</li>
                            <li><strong>Site web :</strong> www.lebosstech.store</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-600 text-center text-gray-400 text-sm">
                    <p>Ces conditions de vente sont conformes à la réglementation ivoirienne en vigueur.</p>
                    <p class="mt-2">Dernière modification : {{ date('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bouton Retour en Haut Fixe -->
<button id="backToTop" class="fixed bottom-6 left-6 bg-gray-800 hover:bg-gray-700 text-white rounded-full p-3 shadow-lg transition-all duration-300 opacity-0 invisible">
    <i class="fas fa-arrow-up"></i>
</button>

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

.article-section {
    scroll-margin-top: 120px;
}

.nav-link.active {
    background-color: #E57125;
    color: white;
}

html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #E57125;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #d65a1e;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleNav = document.getElementById('toggleNav');
    const quickNav = document.getElementById('quickNav');
    
    if (toggleNav && quickNav) {
        toggleNav.addEventListener('click', function() {
            quickNav.classList.toggle('hidden');
        });
    }
    
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 120;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
                
                if (window.innerWidth < 768) {
                    quickNav.classList.add('hidden');
                }
            }
        });
    });
    
    const sections = document.querySelectorAll('.article-section');
    const navLinksArray = Array.from(navLinks);
    
    function updateActiveNav() {
        const scrollPos = window.scrollY + 150;
        
        sections.forEach((section, index) => {
            const sectionTop = section.offsetTop;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                navLinksArray.forEach(link => link.classList.remove('active'));
                const activeLink = document.querySelector(`a[href="#${section.id}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    }
    
    const backToTopBtn = document.getElementById('backToTop');
    
    function toggleBackToTop() {
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove('opacity-0', 'invisible');
            backToTopBtn.classList.add('opacity-100', 'visible');
        } else {
            backToTopBtn.classList.add('opacity-0', 'invisible');
            backToTopBtn.classList.remove('opacity-100', 'visible');
        }
    }
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    window.addEventListener('scroll', function() {
        updateActiveNav();
        toggleBackToTop();
    });
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(section);
    });
    
    updateActiveNav();
    toggleBackToTop();
});
</script>
@endpush
@endsection
