<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Affiche la page À Propos de LEBOSS TECH MARKET
     */
    public function index()
    {
        // Données de l'équipe
        $team = [
            [
                'name' => 'GOH TANGUY BRUNO',
                'position' => 'Fondateur & Directeur Technique',
                'expertise' => 'Expert en reconditionnement informatique depuis 2019',
                'description' => 'Passionné par les nouvelles technologies, Tanguy a fondé LEBOSS TECH avec la vision de démocratiser l\'accès à l\'informatique de qualité en Côte d\'Ivoire.'
            ],
            [
                'name' => 'KONATE MOHAMED',
                'position' => 'Responsable Commercial',
                'expertise' => 'Spécialiste en solutions informatiques B2B',
                'description' => 'Mohamed accompagne nos clients entreprises dans leurs projets d\'équipement informatique avec des solutions sur mesure et un service personnalisé.'
            ]
        ];

        // Partenaires et certifications
        $partners = [
            ['name' => 'Dell', 'logo' => 'dell-logo.png'],
            ['name' => 'HP', 'logo' => 'hp-logo.png'],
            ['name' => 'Lenovo', 'logo' => 'lenovo-logo.png'],
            ['name' => 'Acer', 'logo' => 'acer-logo.png'],
            ['name' => 'TP-Link', 'logo' => 'tplink-logo.png']
        ];

        // Témoignages clients
        $testimonials = [
            [
                'name' => 'Marie KOUASSI',
                'company' => 'Directrice, École Sainte-Marie',
                'message' => 'Grâce à LEBOSS TECH, nous avons pu équiper notre salle informatique avec des ordinateurs de qualité à prix abordable. Le service après-vente est exceptionnel !',
                'rating' => 5
            ],
            [
                'name' => 'Jean-Baptiste TRAORE',
                'company' => 'Gérant, Cabinet Comptable JBT',
                'message' => 'Les ordinateurs reconditionnés de LEBOSS TECH fonctionnent parfaitement. Cela fait 2 ans que nous travaillons avec eux, aucun problème !',
                'rating' => 5
            ],
            [
                'name' => 'Fatou DIALLO',
                'company' => 'Étudiante en Informatique',
                'message' => 'J\'ai acheté mon laptop chez LEBOSS TECH pour mes études. Excellent rapport qualité-prix et garantie respectée. Je recommande vivement !',
                'rating' => 5
            ]
        ];

        // Processus de reconditionnement
        $process = [
            [
                'step' => 1,
                'title' => 'Sélection Rigoureuse',
                'description' => 'Nous sélectionnons uniquement les équipements provenant d\'entreprises avec un historique de maintenance complet.',
                'icon' => 'fas fa-search'
            ],
            [
                'step' => 2,
                'title' => 'Tests Approfondis',
                'description' => 'Chaque composant est testé individuellement : processeur, mémoire, disque dur, écran, clavier, batterie.',
                'icon' => 'fas fa-cogs'
            ],
            [
                'step' => 3,
                'title' => 'Nettoyage Complet',
                'description' => 'Nettoyage intérieur et extérieur, remplacement des pièces défaillantes, installation système propre.',
                'icon' => 'fas fa-broom'
            ],
            [
                'step' => 4,
                'title' => 'Contrôle Qualité',
                'description' => 'Tests de performance, vérification logicielle, validation finale par nos techniciens certifiés.',
                'icon' => 'fas fa-check-circle'
            ],
            [
                'step' => 5,
                'title' => 'Garantie 6 Mois',
                'description' => 'Chaque produit est livré avec une garantie de 6 mois pièces et main d\'œuvre pour votre tranquillité.',
                'icon' => 'fas fa-shield-alt'
            ]
        ];

        return view('about', compact('team', 'partners', 'testimonials', 'process'));
    }
}
