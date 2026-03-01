@extends('layouts.public')

@section('title', 'Contact - LEBOSS TECH MARKET')
@section('description', 'Contactez LEBOSS TECH MARKET pour vos besoins en équipements informatiques. WhatsApp, téléphone, email - Réponse rapide garantie. Showroom à Macory Anoumabo, Abidjan.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-500 via-orange-600 to-red-600 text-white py-20">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">
            <i class="fas fa-comments text-white mr-4"></i>
            Contactez-nous
        </h1>
        <p class="text-xl md:text-2xl text-orange-100 max-w-3xl mx-auto animate-fade-in-up animation-delay-200">
            {{ $contactInfo['tagline'] }}
        </p>
        <div class="mt-8 animate-fade-in-up animation-delay-400">
            <div class="inline-flex items-center bg-white text-orange-600 px-8 py-4 rounded-full shadow-lg">
                <i class="fas fa-clock mr-3"></i>
                <span class="font-semibold">Réponse garantie sous 24h</span>
            </div>
        </div>
    </div>
</section>

<!-- Moyens de Contact Rapide -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Comment nous contacter ?</h2>
            <p class="text-gray-600 text-lg">Choisissez le moyen qui vous convient le mieux</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($contactMethods as $method)
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 text-center animate-fade-in-up">
                <div class="w-16 h-16 bg-{{ $method['color'] }}-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $method['icon'] }} text-2xl text-{{ $method['color'] }}-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $method['title'] }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ $method['description'] }}</p>
                <p class="font-semibold text-gray-900 mb-4">{{ $method['value'] }}</p>
                <a href="{{ $method['link'] }}" target="{{ str_contains($method['link'], 'http') ? '_blank' : '_self' }}" 
                   class="inline-flex items-center bg-{{ $method['color'] }}-500 hover:bg-{{ $method['color'] }}-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="{{ $method['icon'] }} mr-2"></i>
                    Contacter
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Carte Google Maps -->
<section id="map-section" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-map-marked-alt text-orange-500 mr-3"></i>
                Trouvez-nous
            </h2>
            <p class="text-gray-600 text-lg">Notre showroom vous attend à Macory Anoumabo</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in-up">
            <div class="aspect-w-16 aspect-h-9">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.6858424328425!2d-3.97986172428972!3d5.311616236057273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1eda99e4b0393%3A0xef838b8d3d27bda3!2sPC%20MARKET%20CI%20-%20LEBOSS%20TECH!5e0!3m2!1sfr!2sci!4v1750366267889!5m2!1sfr!2sci" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-96 md:h-[450px]">
                </iframe>
            </div>
            
            <div class="p-6 bg-gray-50">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">
                            <i class="fas fa-store text-orange-500 mr-2"></i>
                            PC MARKET CI - LEBOSS TECH
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $contactInfo['address'] }}</p>
                        <div class="flex space-x-4">
                            <a href="https://wa.me/{{ $contactInfo['whatsapp'] }}" target="_blank" 
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                <i class="fab fa-whatsapp mr-1"></i>WhatsApp
                            </a>
                            <a href="tel:{{ $contactInfo['phone'] }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                <i class="fas fa-phone mr-1"></i>Appeler
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">
                            <i class="fas fa-route text-orange-500 mr-2"></i>
                            Comment s'y rendre
                        </h3>
                        <ul class="text-gray-600 text-sm space-y-1">
                            <li>• Quartier Macory Anoumabo</li>
                            <li>• Proche des transports en commun</li>
                            <li>• Parking disponible</li>
                            <li>• Accessible en taxi/bus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulaire de Contact et Informations -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Formulaire -->
            <div class="bg-white p-8 rounded-2xl shadow-lg animate-fade-in-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-paper-plane text-orange-500 mr-3"></i>
                    Envoyez-nous un message
                </h2>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>Nom complet *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone mr-1"></i>Téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="+225 XX XX XX XX XX"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i>Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1"></i>Sujet *
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               placeholder="Ex: Demande de devis, Support technique..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="contact_method" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-comments mr-1"></i>Moyen de contact préféré *
                        </label>
                        <select id="contact_method" name="contact_method" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('contact_method') border-red-500 @enderror">
                            <option value="">Choisissez votre préférence</option>
                            <option value="whatsapp" {{ old('contact_method') == 'whatsapp' ? 'selected' : '' }}>WhatsApp (Réponse immédiate)</option>
                            <option value="email" {{ old('contact_method') == 'email' ? 'selected' : '' }}>Email (Réponse sous 24h)</option>
                            <option value="phone" {{ old('contact_method') == 'phone' ? 'selected' : '' }}>Téléphone (Rappel)</option>
                            <option value="visit" {{ old('contact_method') == 'visit' ? 'selected' : '' }}>Visite en magasin</option>
                        </select>
                        @error('contact_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-comment-alt mr-1"></i>Message *
                        </label>
                        <textarea id="message" name="message" rows="5" required
                                  placeholder="Décrivez votre demande en détail..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
            
            <!-- Informations de contact -->
            <div class="space-y-8">
                <!-- Informations générales -->
                <div class="bg-white p-8 rounded-2xl shadow-lg animate-fade-in-up">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-info-circle text-orange-500 mr-3"></i>
                        Informations de contact
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-building text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $contactInfo['company'] }}</p>
                                <p class="text-gray-600 text-sm">Société à Responsabilité Limitée</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-map-marker-alt text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Adresse</p>
                                <p class="text-gray-600 text-sm">{{ $contactInfo['address'] }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-phone text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Téléphone</p>
                                <a href="tel:{{ $contactInfo['phone'] }}" class="text-orange-600 hover:text-orange-700 text-sm">{{ $contactInfo['phone'] }}</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-envelope text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Email</p>
                                <a href="mailto:{{ $contactInfo['email'] }}" class="text-orange-600 hover:text-orange-700 text-sm">{{ $contactInfo['email'] }}</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-globe text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Site web</p>
                                <p class="text-orange-600 text-sm">{{ $contactInfo['website'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Horaires -->
                <div class="bg-white p-8 rounded-2xl shadow-lg animate-fade-in-up">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-clock text-orange-500 mr-3"></i>
                        Horaires d'ouverture
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($schedule as $day => $hours)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="font-medium text-gray-900">{{ $day }}</span>
                            <span class="text-orange-600 font-semibold">{{ $hours }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <p class="text-green-700 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Ouvert 7j/7</strong> - Support WhatsApp disponible 24h/24
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Contact -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Questions fréquentes</h2>
            <p class="text-gray-600 text-lg">Trouvez rapidement les réponses à vos questions</p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="space-y-4">
                @foreach($faq as $index => $item)
                <div class="bg-gray-50 rounded-lg shadow-md animate-fade-in-up">
                    <button class="faq-button w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-100 transition-colors"
                            onclick="toggleFaq({{ $index }})">
                        <span class="font-semibold text-gray-900">{{ $item['question'] }}</span>
                        <i class="fas fa-chevron-down text-orange-500 transform transition-transform" id="faq-icon-{{ $index }}"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600">{{ $item['answer'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-orange-500 to-red-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Prêt à nous contacter ?</h2>
        <p class="text-xl text-orange-100 mb-8">Notre équipe vous attend pour répondre à tous vos besoins informatiques</p>
        
        <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <a href="https://wa.me/{{ $contactInfo['whatsapp'] }}" target="_blank" 
               class="bg-white text-orange-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </a>
            <a href="tel:{{ $contactInfo['phone'] }}" 
               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-phone mr-2"></i>Appeler
            </a>
            <a href="mailto:{{ $contactInfo['email'] }}" 
               class="bg-white text-orange-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-envelope mr-2"></i>Email
            </a>
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

.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%;
}

.aspect-w-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

@push('scripts')
<script>
function toggleFaq(index) {
    const content = document.querySelector(`#faq-icon-${index}`).closest('.bg-gray-50').querySelector('.faq-content');
    const icon = document.querySelector(`#faq-icon-${index}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Animation au scroll
document.addEventListener('DOMContentLoaded', function() {
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
    
    const animatedElements = document.querySelectorAll('.animate-fade-in-up');
    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(element);
    });
    
    // Smooth scroll pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
@endsection
