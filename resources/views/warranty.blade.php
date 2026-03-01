@extends('layouts.public')

@section('title', 'Informations de Garantie - LEBOSS TECH')
@section('description', 'Tout savoir sur la garantie LEBOSS TECH : couverture de 90 jours à 1 an, procédure de SAV, exclusions et nos engagements pour votre sérénité IT.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-navy-950 overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-leboss-500/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <div class="inline-flex items-center bg-leboss-500/20 text-leboss-400 px-4 py-2 rounded-full text-sm font-semibold mb-6 uppercase tracking-wider border border-leboss-500/30">
            <i class="fas fa-shield-check mr-2"></i> Engagement Qualité
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">
            Garantie <span class="text-transparent bg-clip-text bg-gradient-to-r from-leboss-400 to-leboss-500">LEBOSS TECH</span>
        </h1>
        <p class="text-xl text-navy-300 max-w-2xl mx-auto leading-relaxed">
            Parce que votre sérénité est notre priorité, nous nous engageons sur la fiabilité de nos équipements avec des garanties claires et un SAV réactif.
        </p>
    </div>
</section>

<!-- Contenu Principal -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Bloc RCCM Info Legale -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-12 flex flex-col sm:flex-row items-center justify-between">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="w-12 h-12 bg-navy-50 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-building text-navy-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-navy-900">LEBOSS TECH MARKET</h3>
                    <p class="text-sm text-navy-500">Entreprise légale et enregistrée</p>
                </div>
            </div>
            <div class="bg-leboss-50 text-leboss-700 px-4 py-2 rounded-lg font-mono text-sm border border-leboss-100">
                <strong>RCCM :</strong> CI-ABJ-03-2026-B12-00749
            </div>
        </div>

        <!-- Section 1 : Durées de Garantie -->
        <div class="mb-12">
            <h2 class="flex items-center text-2xl font-bold text-navy-900 mb-6">
                <div class="w-10 h-10 bg-leboss-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-leboss-500"></i>
                </div>
                Nos Durées de Garantie
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Garantie Standard -->
                <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden group hover:border-leboss-300 transition-colors">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-leboss-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-xl font-bold text-navy-900 mb-2">Standard 90 Jours</h3>
                    <p class="text-leboss-600 font-semibold mb-4">Inclus par défaut</p>
                    <p class="text-navy-600 text-sm leading-relaxed mb-6">
                        Sur l'ensemble de notre parc de matériel informatique reconditionné (ordinateurs, écrans, composants). 3 mois de tranquillité absolue.
                    </p>
                    <ul class="space-y-2 text-sm text-navy-700">
                        <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2"></i> Couverture pièces et main d'œuvre</li>
                        <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2"></i> Diagnostic gratuit</li>
                    </ul>
                </div>

                <!-- Garantie B2B -->
                <div class="bg-navy-900 p-8 rounded-2xl border border-navy-700 shadow-lg relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-navy-800 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-xl font-bold text-white mb-2">Extension B2B (1 an)</h3>
                    <p class="text-leboss-400 font-semibold mb-4">Sur devis & contrats</p>
                    <p class="text-navy-300 text-sm leading-relaxed mb-6">
                        Pour nos partenaires professionnels et achats en gros volume. Une couverture étendue pour sécuriser votre investissement à long terme.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-start"><i class="fas fa-check text-leboss-400 mt-1 mr-2"></i> Matériel de remplacement prêté</li>
                        <li class="flex items-start"><i class="fas fa-check text-leboss-400 mt-1 mr-2"></i> Intervention prioritaire sur site</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 2 : Ce qui est couvert -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-12">
            <h2 class="flex items-center text-2xl font-bold text-navy-900 mb-8 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                Ce qui est couvert par la garantie
            </h2>
            <div class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <h4 class="font-bold text-navy-900 mb-2 flex items-center">
                        <i class="fas fa-microchip text-navy-400 mr-2 w-5"></i> Défauts matériels
                    </h4>
                    <p class="text-sm text-navy-600">Pannes spontanées des composants internes (carte mère, RAM, processeur, carte graphique) intervenant dans des conditions normales d'utilisation.</p>
                </div>
                <div>
                    <h4 class="font-bold text-navy-900 mb-2 flex items-center">
                        <i class="fas fa-hdd text-navy-400 mr-2 w-5"></i> Stockage & Mémoire
                    </h4>
                    <p class="text-sm text-navy-600">Défaillance inattendue du disque dur (HDD/SSD) ou de la mémoire vive non liée à un choc physique ou électrique.</p>
                </div>
                <div>
                    <h4 class="font-bold text-navy-900 mb-2 flex items-center">
                        <i class="fas fa-desktop text-navy-400 mr-2 w-5"></i> Affichage
                    </h4>
                    <p class="text-sm text-navy-600">Pixels morts (au-delà des tolérances constructeur), défauts de rétroéclairage de l'écran ou problèmes d'affichage natifs.</p>
                </div>
                <div>
                    <h4 class="font-bold text-navy-900 mb-2 flex items-center">
                        <i class="fas fa-keyboard text-navy-400 mr-2 w-5"></i> Périphériques intégrés
                    </h4>
                    <p class="text-sm text-navy-600">Dysfonctionnement du clavier, du pavé tactile ou des modules de connectivité (Wi-Fi, Bluetooth) d'origine.</p>
                </div>
            </div>
        </div>

        <!-- Section 3 : Exclusions -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-12">
            <h2 class="flex items-center text-2xl font-bold text-navy-900 mb-8 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-times-circle text-red-500"></i>
                </div>
                Exclusions de Garantie
            </h2>
            <p class="text-navy-600 mb-6 font-medium">La garantie ne s'applique pas dans les cas suivants, qui relèvent de la responsabilité de l'utilisateur :</p>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                    <i class="fas fa-water text-gray-400 mt-1 mr-3 text-lg w-6 text-center"></i>
                    <div>
                        <h4 class="font-bold text-navy-900 text-sm mb-1">Dommages physiques/liquides</h4>
                        <p class="text-xs text-navy-600">Casse, fissures, chocs, ou oxydation due à un déversement de liquide.</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                    <i class="fas fa-bolt text-gray-400 mt-1 mr-3 text-lg w-6 text-center"></i>
                    <div>
                        <h4 class="font-bold text-navy-900 text-sm mb-1">Surtension électrique</h4>
                        <p class="text-xs text-navy-600">Composants grillés suite à des instabilités du réseau électrique (utilisation sans onduleur recommandée).</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                    <i class="fas fa-bug text-gray-400 mt-1 mr-3 text-lg w-6 text-center"></i>
                    <div>
                        <h4 class="font-bold text-navy-900 text-sm mb-1">Problèmes logiciels & Virus</h4>
                        <p class="text-xs text-navy-600">Infection par malware, pertes de données, ou dysfonctionnements liés à des logiciels tiers installés par le client.</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                    <i class="fas fa-tools text-gray-400 mt-1 mr-3 text-lg w-6 text-center"></i>
                    <div>
                        <h4 class="font-bold text-navy-900 text-sm mb-1">Intervention non autorisée</h4>
                        <p class="text-xs text-navy-600">Ouverture de la machine ou tentative de réparation par une personne non agréée par LEBOSS TECH.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-lg">
                <h4 class="font-bold text-orange-800 text-sm mb-1"><i class="fas fa-battery-half mr-2"></i> Note concernant les batteries</h4>
                <p class="text-xs text-orange-700">La batterie est un consommable. Son usure naturelle n'est pas couverte par la garantie. Seul un défaut critique de charge (batterie morte) signalé dans les 14 premiers jours pourra faire l'objet d'un remplacement.</p>
            </div>
        </div>

        <!-- Section 4 : Procédure SAV -->
        <div class="bg-navy-900 text-white p-8 rounded-2xl shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-leboss-500/10 rounded-full blur-3xl"></div>
            
            <h2 class="text-2xl font-bold mb-8 flex items-center">
                <i class="fas fa-cogs text-leboss-400 mr-4"></i> Procédure de Service Après-Vente
            </h2>
            
            <div class="space-y-6 relative">
                <!-- Ligne connectrice -->
                <div class="absolute left-6 top-10 bottom-10 w-0.5 bg-navy-700 hidden sm:block"></div>
                
                <div class="flex items-start relative">
                    <div class="w-12 h-12 bg-navy-800 border-2 border-leboss-500 rounded-full flex items-center justify-center flex-shrink-0 z-10 text-leboss-400 font-bold">1</div>
                    <div class="ml-6 pt-2">
                        <h4 class="font-bold text-lg mb-1">Contact Initial</h4>
                        <p class="text-navy-300 text-sm">Contactez notre support via WhatsApp au <strong class="text-white">+225 05 66 82 16 09</strong> avec votre numéro de facture ou de série et une courte description du problème.</p>
                    </div>
                </div>
                
                <div class="flex items-start relative">
                    <div class="w-12 h-12 bg-navy-800 border-2 border-navy-600 rounded-full flex items-center justify-center flex-shrink-0 z-10 text-white font-bold">2</div>
                    <div class="ml-6 pt-2">
                        <h4 class="font-bold text-lg mb-1">Diagnostic par nos techniciens</h4>
                        <p class="text-navy-300 text-sm">Apportez le matériel à notre atelier (ou intervention sur site pour contrats B2B). Le diagnostic est généralement posé sous 24h à 48h.</p>
                    </div>
                </div>
                
                <div class="flex items-start relative">
                    <div class="w-12 h-12 bg-navy-800 border-2 border-green-500 rounded-full flex items-center justify-center flex-shrink-0 z-10 text-green-400 font-bold">3</div>
                    <div class="ml-6 pt-2">
                        <h4 class="font-bold text-lg mb-1">Réparation ou Remplacement</h4>
                        <p class="text-navy-300 text-sm">Si la panne est couverte, nous réparons sans frais. Si la réparation est impossible, nous remplaçons par un produit équivalent. Délai moyen : 3 à 7 jours ouvrés.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 text-center">
                <a href="https://wa.me/2250566821609?text=Bonjour,%20j'ai%20une%20question%20concernant%20la%20garantie%20d'un%20produit" 
                   target="_blank"
                   class="inline-flex items-center justify-center bg-leboss-500 hover:bg-leboss-600 text-white px-8 py-3 rounded-xl font-bold transition-colors shadow-lg shadow-leboss-500/20">
                    <i class="fab fa-whatsapp mr-2 text-xl"></i> Contacter le SAV
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
