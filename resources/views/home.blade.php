@extends('layouts.public')

@section('title', 'LEBOSS TECH MARKET - Spécialiste Informatique Reconditionnée Abidjan')
@section('description', 'LEBOSS TECH MARKET : Ordinateurs, laptops, imprimantes laser et accessoires informatiques reconditionnés. Garantie 6 mois, prix imbattables à Abidjan.')

@section('content')
<!-- Hero Slider -->
<section class="relative">
    @if($sliders->count() > 0)
        <div class="slider-container relative h-96 md:h-[600px] overflow-hidden">
            @foreach($sliders as $index => $slider)
                <div class="slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 transition-opacity duration-1000">
                    <div class="relative h-full">
                        @php
                            $sliderImageUrl = null;
                            // Priorité 1 : Media Library avec conversion
                            if ($slider->hasMedia('banners')) {
                                $sliderImageUrl = $slider->getFirstMediaUrl('banners', 'banner');
                            }
                            // Priorité 2 : Stockage direct
                            elseif ($slider->image) {
                                $sliderImageUrl = asset($slider->image);
                            }
                        @endphp
                        
                        @if($sliderImageUrl)
                            <img src="{{ $sliderImageUrl }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-leboss-600 to-leboss-dark-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white max-w-5xl mx-auto px-4">
                                <h1 class="text-4xl md:text-7xl font-bold mb-6 text-shadow-lg">{{ $slider->title }}</h1>
                                @if($slider->subtitle)
                                    <p class="text-xl md:text-3xl mb-10 font-light leading-relaxed">{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}" class="bg-leboss-500 hover:bg-leboss-600 text-white px-10 py-4 rounded-lg text-xl font-semibold transition-all transform hover:scale-105 inline-block shadow-lg">
                                        {{ $slider->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($sliders->count() > 1)
                <!-- Navigation arrows -->
                <button class="slider-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button class="slider-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
                
                <!-- Dots indicator -->
                <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    @foreach($sliders as $index => $slider)
                        <button class="slider-dot w-4 h-4 rounded-full bg-white {{ $index === 0 ? 'bg-opacity-100' : 'bg-opacity-50' }} transition-all"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Default hero when no sliders -->
        <div class="relative h-96 md:h-[600px] bg-gradient-to-r from-leboss-600 to-leboss-dark-600">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white max-w-5xl mx-auto px-4">
                    <h1 class="text-4xl md:text-7xl font-bold mb-6">LEBOSS TECH MARKET</h1>
                    <p class="text-xl md:text-3xl mb-10 font-light">Spécialiste de l'informatique reconditionnée - Ordinateurs, Imprimantes & Accessoires</p>
                    <a href="{{ route('products.index') }}" class="bg-white text-leboss-500 px-10 py-4 rounded-lg text-xl font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 inline-block shadow-lg">
                        Découvrir nos produits
                    </a>
                </div>
            </div>
        </div>
    @endif
</section>

<!-- Pourquoi le Reconditionné Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Pourquoi choisir le reconditionné ?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Découvrez les avantages du matériel informatique reconditionné : qualité professionnelle, prix attractifs et engagement écologique</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-dollar-sign text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Prix Imbattables</h3>
                <p class="text-gray-600">Économisez jusqu'à 70% par rapport au neuf tout en conservant des performances excellentes</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tools text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Testés & Garantis</h3>
                <p class="text-gray-600">Tous nos produits sont rigoureusement testés et garantis 6 mois pour votre sérénité</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-leaf text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Écologique</h3>
                <p class="text-gray-600">Participez à l'économie circulaire en donnant une seconde vie au matériel informatique</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-award text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Qualité Pro</h3>
                <p class="text-gray-600">Matériel de marques premium (Dell, HP, Lenovo) utilisé en entreprise</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Nos Spécialités</h2>
            <p class="text-xl text-gray-600">Découvrez notre gamme complète de matériel informatique reconditionné</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}" class="group">
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 p-8 text-center border border-gray-100">
                        @if($category->getFirstMediaUrl('images'))
                            <img src="{{ $category->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $category->name }}" class="w-20 h-20 mx-auto mb-6 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 mx-auto mb-6 bg-leboss-100 rounded-lg flex items-center justify-center">
                                @switch($category->slug)
                                    @case('ordinateurs-bureau')
                                        <i class="fas fa-desktop text-leboss-600 text-3xl"></i>
                                        @break
                                    @case('ordinateurs-portables')
                                        <i class="fas fa-laptop text-leboss-600 text-3xl"></i>
                                        @break
                                    @case('imprimantes-laser')
                                        <i class="fas fa-print text-leboss-600 text-3xl"></i>
                                        @break
                                    @case('ecrans-moniteurs')
                                        <i class="fas fa-tv text-leboss-600 text-3xl"></i>
                                        @break
                                    @case('accessoires-informatiques')
                                        <i class="fas fa-keyboard text-leboss-600 text-3xl"></i>
                                        @break
                                    @case('composants-pc')
                                        <i class="fas fa-microchip text-leboss-600 text-3xl"></i>
                                        @break
                                    @default
                                        <i class="fas fa-computer text-leboss-600 text-3xl"></i>
                                @endswitch
                            </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-leboss-600 transition-colors mb-3">{{ $category->name }}</h3>
                        <p class="text-gray-600 mb-4 text-sm">{{ $category->description }}</p>
                        <div class="flex items-center justify-center text-leboss-600 font-semibold">
                            <span class="mr-2">{{ $category->products_count }} produits</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Nos Meilleures Offres</h2>
            <p class="text-xl text-gray-600">Sélection de nos produits reconditionnés les plus populaires</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 overflow-hidden">
                    <div class="relative">
                        @if($product->getFirstMediaUrl('images'))
                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-5xl"></i>
                            </div>
                        @endif
                        @if($product->stock <= 0)
                            <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                Rupture de stock
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-leboss-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            ⭐ Vedette
                        </div>
                        <div class="absolute bottom-3 left-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            Reconditionné
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-3">
                            <span class="text-xs text-leboss-600 font-bold bg-leboss-50 px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3 text-lg line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->short_description }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-leboss-600">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            @if($product->stock > 0)
                                <span class="text-green-600 text-sm font-semibold">✓ En stock</span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-3 rounded-lg transition-colors font-semibold">
                                Voir détails
                            </a>
                            <a href="{{ $product->whatsapp_url }}" target="_blank" onclick="fetch('{{ route('products.whatsapp-click', $product) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})" 
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg transition-colors font-semibold">
                                <i class="fab fa-whatsapp mr-1"></i> Commander
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-16">
            <a href="{{ route('products.index') }}" class="bg-leboss-500 hover:bg-leboss-600 text-white px-10 py-4 rounded-lg text-xl font-semibold transition-all transform hover:scale-105 inline-block shadow-lg">
                Voir tous les produits
            </a>
        </div>
    </div>
</section>
@endif

<!-- Témoignages / Confiance Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Pourquoi nous faire confiance ?</h2>
            <p class="text-xl text-gray-600">LEBOSS TECH, votre partenaire de confiance pour l'informatique reconditionnée</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="text-center p-8 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                <div class="bg-green-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shipping-fast text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Livraison Express</h3>
                <p class="text-gray-700 text-lg">Livraison rapide et sécurisée dans tout Abidjan. Commandez aujourd'hui, recevez demain à domicile ou au bureau.</p>
            </div>
            
            <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                <div class="bg-blue-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Garantie 6 Mois</h3>
                <p class="text-gray-700 text-lg">Tous nos produits reconditionnés bénéficient d'une garantie de 6 mois. Votre tranquillité d'esprit est notre priorité.</p>
            </div>
            
            <div class="text-center p-8 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                <div class="bg-purple-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fab fa-whatsapp text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Support WhatsApp</h3>
                <p class="text-gray-700 text-lg">Notre équipe est disponible sur WhatsApp pour vous accompagner avant, pendant et après votre achat.</p>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl font-bold text-leboss-600 mb-2">500+</div>
                <div class="text-gray-600">Clients satisfaits</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-leboss-600 mb-2">6 mois</div>
                <div class="text-gray-600">Garantie produits</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-leboss-600 mb-2">24h</div>
                <div class="text-gray-600">Livraison Abidjan</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-leboss-600 mb-2">70%</div>
                <div class="text-gray-600">Économies vs neuf</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-leboss-600 to-leboss-dark-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Prêt à équiper votre bureau ?</h2>
        <p class="text-xl text-leboss-100 mb-10 leading-relaxed">Contactez-nous dès maintenant via WhatsApp pour obtenir un devis personnalisé ou passer votre commande. Notre équipe vous conseille gratuitement !</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/2250566821609?text=Bonjour, je souhaite un devis pour équiper mon bureau" target="_blank" 
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all transform hover:scale-105 inline-flex items-center justify-center shadow-lg">
                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                Demander un devis
            </a>
            <a href="{{ route('products.index') }}" 
               class="bg-white hover:bg-gray-100 text-leboss-600 px-8 py-4 rounded-lg text-lg font-semibold transition-all transform hover:scale-105 inline-flex items-center justify-center shadow-lg">
                <i class="fas fa-laptop mr-3"></i>
                Voir le catalogue
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
        
        // Auto-advance slides
        setInterval(nextSlide, 6000);
    }
});
</script>
@endpush 