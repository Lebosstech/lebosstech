@extends('layouts.public')

@section('title', 'Conditions de Partenariat - LEBOSS TECH')
@section('description', 'Nos conditions de vente et nos engagements B2B pour une relation de confiance. Découvrez notre approche gagnant-gagnant.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-navy-950 overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-leboss-500/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <div class="inline-flex items-center bg-leboss-500/20 text-leboss-400 px-4 py-2 rounded-full text-sm font-semibold mb-6 uppercase tracking-wider border border-leboss-500/30">
            <i class="fas fa-handshake mr-2"></i> Un partenariat clair
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">
            Conditions de <span class="text-transparent bg-clip-text bg-gradient-to-r from-leboss-400 to-leboss-500">Vente</span>
        </h1>
        <p class="text-xl text-navy-300 max-w-3xl mx-auto leading-relaxed">
            Chez LEBOSS TECH, nous favorisons une approche "Gagnant-Gagnant" basée sur la transparence, la confiance mutuelle et le succès de vos projets IT.
        </p>
        <div class="mt-8">
            <div class="inline-flex items-center bg-navy-800 border border-navy-700 text-navy-200 px-6 py-3 rounded-xl text-sm font-mono shadow-sm">
                <strong>RCCM :</strong> <span class="ml-2">CI-ABJ-03-2026-B12-00749</span>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Rapide & Contenu Principal -->
<section class="py-16 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Sidebar Navigation (Sticky sur Desktop) -->
            <div class="lg:w-1/4">
                <div class="sticky top-24 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-navy-900 text-lg mb-4 flex items-center">
                        <i class="fas fa-list-ul text-leboss-500 mr-3"></i> Sommaire
                    </h3>
                    <nav id="quickNav" class="space-y-2">
                        @foreach($navigation as $nav)
                            <a href="#{{ $nav['id'] }}" class="block nav-link text-sm font-medium text-navy-500 hover:text-leboss-600 hover:bg-leboss-50 px-3 py-2 rounded-lg transition-colors">
                                {{ $nav['title'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>

            <!-- Contenu des Articles -->
            <div class="lg:w-3/4">
                
                <!-- Intro gagnant-gagnant -->
                <div class="bg-navy-900 text-white p-8 rounded-2xl shadow-lg mb-10 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-leboss-500/20 rounded-full blur-2xl"></div>
                    <div class="flex gap-4 items-start relative z-10">
                        <i class="fas fa-lightbulb text-leboss-400 text-4xl mt-1"></i>
                        <div>
                            <h2 class="text-xl font-bold mb-2">L'approche LEBOSS TECH</h2>
                            <p class="text-navy-200 text-sm leading-relaxed">
                                Les conditions qui suivent s'éloignent du jargon juridique complexe et inutile. Elles expriment nos engagements mutuels. En travaillant avec nous, vous choisissez un partenaire technologique qui s'engage pour votre performance.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Liste des articles -->
                <div class="space-y-8">
                    @foreach($sections as $section)
                        <article id="{{ $section['id'] }}" class="article-section bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:border-leboss-200 transition-colors">
                            <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                                <div class="w-12 h-12 bg-leboss-50 text-leboss-600 rounded-xl flex items-center justify-center mr-4 text-xl flex-shrink-0">
                                    <i class="{{ $section['icon'] }}"></i>
                                </div>
                                <h2 class="text-xl font-bold text-navy-900">{{ $section['title'] }}</h2>
                            </div>
                            
                            <div class="space-y-4 text-navy-600 text-sm leading-relaxed">
                                @foreach($section['content'] as $paragraph)
                                    <p class="flex items-start">
                                        <i class="fas fa-chevron-right text-leboss-400 text-[10px] mt-1.5 mr-3 flex-shrink-0"></i>
                                        <span>{{ $paragraph }}</span>
                                    </p>
                                @endforeach
                            </div>
                            
                            <!-- Lien vers Garantie (si c'est l'article 7) -->
                            @if($section['id'] === 'article-7')
                                <div class="mt-6">
                                    <a href="{{ route('warranty.index') }}" class="inline-flex items-center text-sm font-bold text-leboss-600 hover:text-leboss-700 bg-leboss-50 hover:bg-leboss-100 px-4 py-2 rounded-lg transition-colors">
                                        Consulter la page détaillée des garanties <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
                
                <!-- Mention mise à jour -->
                <div class="mt-12 text-center text-navy-400 text-sm">
                    <p>Ces conditions entrent en vigueur à compter de la date de publication.</p>
                    <p>Mis à jour le {{ date('d/m/Y') }}</p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- CTA Besoin d'informations -->
<section class="py-16 bg-navy-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-leboss-500/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Des questions sur nos conditions ?</h2>
        <p class="text-navy-300 mb-8 max-w-2xl mx-auto">
            Nous détestons les mauvaises surprises autant que vous. Si un point n'est pas clair, ou si vous avez besoin d'aménagements contractuels pour votre entreprise, discutons-en !
        </p>
        <a href="https://wa.me/2250566821609" target="_blank" class="inline-flex items-center bg-leboss-500 hover:bg-leboss-600 text-white font-bold py-3 px-8 rounded-xl transition-all hover:shadow-lg hover:shadow-leboss-500/30">
            <i class="fab fa-whatsapp text-xl mr-3"></i> Parler à un conseiller
        </a>
    </div>
</section>

<style>
/* Style pour la navigation active */
.nav-link.active {
    background-color: #fef2f2; /* tailwind orange-50 ou leboss-50 */
    color: #E57125; /* leboss-500 */
    font-weight: 700;
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px; /* Espace pour le fixed header lors du scroll anchor */
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ScrollSpy pour le menu latéral
    const sections = document.querySelectorAll('.article-section');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    
    function updateActiveNav() {
        // Position actuelle du scroll (avec une marge pour l'entête)
        const scrollPos = window.scrollY + 120;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPos >= sectionTop && scrollPos <= sectionBottom) {
                navLinks.forEach(link => link.classList.remove('active'));
                const activeLink = document.querySelector(`.nav-link[href="#${section.id}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    }

    // Lier la fonction au scroll
    window.addEventListener('scroll', updateActiveNav);
    
    // Smooth scrolling avec offset pour la navbar fixe (if any)
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 100;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Initialiser l'état actif
    updateActiveNav();
});
</script>
@endpush
@endsection

