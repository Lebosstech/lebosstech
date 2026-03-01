<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = [
            [
                'title' => 'Distribution de matériel informatique',
                'icon' => 'fas fa-laptop',
                'gradient' => 'linear-gradient(to right, #E57125, #D55A0E)',
                'check_color' => '#E57125',
                'short_description' => 'Vente de matériels informatiques neufs et reconditionnés.',
                'details' => [
                    'Ordinateurs de bureau et portables',
                    'Imprimantes laser et jet d\'encre',
                    'Accessoires et périphériques',
                    'Équipements réseaux (routeurs, switches, câbles)',
                    'Logiciels professionnels et licences',
                    'Matériel neuf et reconditionné garanti',
                ],
            ],
            [
                'title' => 'Installation et configuration de réseaux',
                'icon' => 'fas fa-network-wired',
                'gradient' => 'linear-gradient(to right, #3b82f6, #2563eb)',
                'check_color' => '#3b82f6',
                'short_description' => 'Mise en place de réseaux locaux et Wi-Fi professionnels.',
                'details' => [
                    'Réseaux locaux (LAN) filaires et sans fil',
                    'Configuration de réseaux Wi-Fi entreprise',
                    'Câblage informatique structuré',
                    'Configuration de serveurs',
                    'Installation d\'équipements réseaux',
                    'Sécurisation des réseaux',
                ],
            ],
            [
                'title' => 'Dépannage et maintenance informatique',
                'icon' => 'fas fa-tools',
                'gradient' => 'linear-gradient(to right, #22c55e, #16a34a)',
                'check_color' => '#22c55e',
                'short_description' => 'Diagnostic, réparation et maintenance de vos équipements.',
                'details' => [
                    'Diagnostic complet de pannes',
                    'Réparation d\'ordinateurs et laptops',
                    'Maintenance préventive planifiée',
                    'Maintenance corrective en urgence',
                    'Réparation d\'imprimantes',
                    'Dépannage réseau et connectivité',
                ],
            ],
            [
                'title' => 'Services d\'impression',
                'icon' => 'fas fa-print',
                'gradient' => 'linear-gradient(to right, #a855f7, #9333ea)',
                'check_color' => '#a855f7',
                'short_description' => 'Impression de documents professionnels et supports de communication.',
                'details' => [
                    'Impression de documents professionnels',
                    'Flyers et affiches publicitaires',
                    'Cartes de visite et cartes d\'invitation',
                    'Rapports et mémoires reliés',
                    'Banderoles et supports grand format',
                    'Impression couleur et noir & blanc',
                ],
            ],
            [
                'title' => 'Conception de solutions numériques',
                'icon' => 'fas fa-code',
                'gradient' => 'linear-gradient(to right, #6366f1, #4f46e5)',
                'check_color' => '#6366f1',
                'short_description' => 'Développement de solutions digitales sur mesure.',
                'details' => [
                    'Applications mobiles et web',
                    'Plateformes e-commerce',
                    'Solutions métiers personnalisées',
                    'Outils numériques adaptés aux besoins',
                    'Systèmes de gestion (ERP, CRM)',
                    'Intégration de systèmes existants',
                ],
            ],
            [
                'title' => 'Marketing digital et communication',
                'icon' => 'fas fa-bullhorn',
                'gradient' => 'linear-gradient(to right, #ec4899, #db2777)',
                'check_color' => '#ec4899',
                'short_description' => 'Création de visibilité en ligne et stratégie digitale.',
                'details' => [
                    'Création et gestion de sites web',
                    'Gestion de présence sur les réseaux sociaux',
                    'Référencement local et SEO',
                    'Stratégies de communication digitale',
                    'Création de contenus visuels',
                    'Campagnes publicitaires en ligne',
                ],
            ],
            [
                'title' => 'Conseil et accompagnement informatique',
                'icon' => 'fas fa-handshake',
                'gradient' => 'linear-gradient(to right, #14b8a6, #0d9488)',
                'check_color' => '#14b8a6',
                'short_description' => 'Assistance, audit et conseils pour votre transformation numérique.',
                'details' => [
                    'Audit de systèmes informatiques',
                    'Conseil en transformation numérique',
                    'Accompagnement de projets IT',
                    'Formation des équipes',
                    'Optimisation des infrastructures',
                    'Plan de continuité informatique',
                ],
            ],
        ];

        return view('services', compact('services'));
    }
}
