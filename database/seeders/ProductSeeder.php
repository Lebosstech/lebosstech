<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            // Ordinateurs de Bureau
            [
                'name' => 'PC Dell OptiPlex 7070 Reconditionné',
                'short_description' => 'PC de bureau professionnel Dell reconditionné, idéal pour bureautique et tâches professionnelles.',
                'description' => 'Dell OptiPlex 7070 reconditionné en excellent état. Testé et garanti 6 mois. Parfait pour bureautique, navigation web et applications professionnelles. Windows 11 pré-installé et activé.',
                'price' => 185000,
                'stock' => 12,
                'category_id' => $categories->where('slug', 'ordinateurs-bureau')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Processeur' => 'Intel Core i5-9500',
                    'RAM' => '8 Go DDR4',
                    'Stockage' => '256 Go SSD',
                    'Ports' => 'USB 3.0, HDMI, VGA',
                    'Réseau' => 'WiFi + Ethernet',
                    'OS' => 'Windows 11 Pro',
                    'État' => 'Reconditionné Grade A'
                ],
                'meta_title' => 'PC Dell OptiPlex 7070 Reconditionné - LEBOSS TECH',
                'meta_description' => 'PC Dell OptiPlex reconditionné au meilleur prix en Côte d\'Ivoire. Garantie 6 mois, livraison Abidjan.'
            ],
            [
                'name' => 'HP EliteDesk 800 G4 Mini PC',
                'short_description' => 'Mini PC professionnel HP reconditionné, compact et performant pour espaces réduits.',
                'description' => 'HP EliteDesk 800 G4 Mini PC reconditionné, ultra-compact mais puissant. Parfait pour les bureaux avec peu d\'espace. Performances professionnelles dans un format réduit.',
                'price' => 165000,
                'stock' => 8,
                'category_id' => $categories->where('slug', 'ordinateurs-bureau')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Processeur' => 'Intel Core i5-8500T',
                    'RAM' => '8 Go DDR4',
                    'Stockage' => '256 Go SSD',
                    'Format' => 'Mini PC (17.7 x 17.5 x 3.4 cm)',
                    'Connectivité' => 'WiFi, Bluetooth, Ethernet',
                    'OS' => 'Windows 11 Pro',
                    'État' => 'Reconditionné Grade A'
                ]
            ],
            
            // Ordinateurs Portables
            [
                'name' => 'MacBook Pro 13" 2019 Reconditionné',
                'short_description' => 'MacBook Pro 13" reconditionné, idéal pour créatifs et professionnels exigeants.',
                'description' => 'MacBook Pro 13" 2019 reconditionné en excellent état. Écran Retina, performances exceptionnelles pour design, développement et multimédia. Batterie remplacée, garantie 6 mois.',
                'price' => 485000,
                'stock' => 5,
                'category_id' => $categories->where('slug', 'ordinateurs-portables')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Écran' => '13.3" Retina (2560x1600)',
                    'Processeur' => 'Intel Core i5 8ème gen',
                    'RAM' => '8 Go LPDDR3',
                    'Stockage' => '256 Go SSD',
                    'GPU' => 'Intel Iris Plus 645',
                    'Autonomie' => 'Jusqu\'à 10h',
                    'État' => 'Reconditionné Grade A+'
                ]
            ],
            [
                'name' => 'Dell Latitude 5520 Reconditionné',
                'short_description' => 'Laptop professionnel Dell reconditionné, robuste et fiable pour usage intensif.',
                'description' => 'Dell Latitude 5520 reconditionné, ordinateur portable professionnel conçu pour la durabilité. Parfait pour entreprises et travailleurs nomades. Testé et garanti.',
                'price' => 285000,
                'stock' => 10,
                'category_id' => $categories->where('slug', 'ordinateurs-portables')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Écran' => '15.6" Full HD (1920x1080)',
                    'Processeur' => 'Intel Core i5-1135G7',
                    'RAM' => '8 Go DDR4',
                    'Stockage' => '256 Go SSD',
                    'GPU' => 'Intel Iris Xe',
                    'Connectivité' => 'WiFi 6, Bluetooth',
                    'État' => 'Reconditionné Grade A'
                ]
            ],
            [
                'name' => 'HP EliteBook 840 G6 Reconditionné',
                'short_description' => 'Ultrabook professionnel HP reconditionné, léger et performant.',
                'description' => 'HP EliteBook 840 G6 reconditionné, ultrabook professionnel alliant performance et mobilité. Design premium, sécurité renforcée et autonomie exceptionnelle.',
                'price' => 315000,
                'stock' => 7,
                'category_id' => $categories->where('slug', 'ordinateurs-portables')->first()->id,
                'is_active' => true,
                'specifications' => [
                    'Écran' => '14" Full HD IPS',
                    'Processeur' => 'Intel Core i5-8265U',
                    'RAM' => '16 Go DDR4',
                    'Stockage' => '512 Go SSD',
                    'Sécurité' => 'Lecteur d\'empreintes',
                    'Poids' => '1.33 kg',
                    'État' => 'Reconditionné Grade A'
                ]
            ],
            
            // Imprimantes Laser
            [
                'name' => 'HP LaserJet Pro M404n Reconditionnée',
                'short_description' => 'Imprimante laser monochrome HP reconditionnée, rapide et économique.',
                'description' => 'HP LaserJet Pro M404n reconditionnée, imprimante laser monochrome professionnelle. Vitesse d\'impression élevée, coût par page réduit. Parfaite pour bureaux.',
                'price' => 125000,
                'stock' => 15,
                'category_id' => $categories->where('slug', 'imprimantes-laser')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Type' => 'Laser monochrome',
                    'Vitesse' => 'Jusqu\'à 38 ppm',
                    'Résolution' => '4800 x 600 ppp',
                    'Connectivité' => 'USB, Ethernet',
                    'Formats' => 'A4, A5, A6, enveloppes',
                    'Cartouche' => 'HP 58A (3000 pages)',
                    'État' => 'Reconditionnée Grade A'
                ]
            ],
            [
                'name' => 'Canon imageCLASS MF445dw Reconditionnée',
                'short_description' => 'Imprimante laser multifonction Canon reconditionnée avec WiFi.',
                'description' => 'Canon imageCLASS MF445dw reconditionnée, imprimante laser multifonction 4-en-1. Impression, copie, scan, fax avec connectivité WiFi et impression mobile.',
                'price' => 185000,
                'stock' => 8,
                'category_id' => $categories->where('slug', 'imprimantes-laser')->first()->id,
                'is_active' => true,
                'specifications' => [
                    'Type' => 'Laser multifonction monochrome',
                    'Fonctions' => 'Impression, Copie, Scan, Fax',
                    'Vitesse' => 'Jusqu\'à 40 ppm',
                    'Connectivité' => 'WiFi, USB, Ethernet',
                    'Écran' => '5" tactile couleur',
                    'Recto-verso' => 'Automatique',
                    'État' => 'Reconditionnée Grade A'
                ]
            ],
            
            // Écrans & Moniteurs
            [
                'name' => 'Dell UltraSharp U2419H 24" Reconditionné',
                'short_description' => 'Écran Dell 24" Full HD reconditionné, qualité professionnelle.',
                'description' => 'Dell UltraSharp U2419H reconditionné, écran 24" Full HD avec dalle IPS. Couleurs précises et angles de vision larges. Parfait pour bureautique et design.',
                'price' => 115000,
                'stock' => 12,
                'category_id' => $categories->where('slug', 'ecrans-moniteurs')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Taille' => '24" (60.96 cm)',
                    'Résolution' => '1920 x 1080 Full HD',
                    'Dalle' => 'IPS',
                    'Connecteurs' => 'HDMI, DisplayPort, VGA',
                    'Réglages' => 'Hauteur, pivot, inclinaison',
                    'Bordures' => 'Ultra-fines',
                    'État' => 'Reconditionné Grade A'
                ]
            ],
            
            // Accessoires Informatiques
            [
                'name' => 'Pack Clavier-Souris Logitech MK540 Neuf',
                'short_description' => 'Pack clavier-souris sans fil Logitech, confortable et durable.',
                'description' => 'Pack Logitech MK540 neuf, combo clavier-souris sans fil. Clavier full-size avec pavé numérique et souris ergonomique. Autonomie exceptionnelle de 3 ans.',
                'price' => 35000,
                'stock' => 25,
                'category_id' => $categories->where('slug', 'accessoires-informatiques')->first()->id,
                'is_active' => true,
                'specifications' => [
                    'Type' => 'Pack clavier-souris sans fil',
                    'Connectivité' => 'USB (récepteur Unifying)',
                    'Autonomie clavier' => 'Jusqu\'à 3 ans',
                    'Autonomie souris' => 'Jusqu\'à 18 mois',
                    'Portée' => 'Jusqu\'à 10 mètres',
                    'Compatibilité' => 'Windows, Mac, Linux',
                    'État' => 'Neuf'
                ]
            ],
            [
                'name' => 'Webcam Logitech C920 HD Reconditionnée',
                'short_description' => 'Webcam HD Logitech reconditionnée, idéale pour visioconférences.',
                'description' => 'Logitech C920 HD reconditionnée, webcam de référence pour visioconférences professionnelles. Qualité vidéo Full HD 1080p et micro stéréo intégré.',
                'price' => 45000,
                'stock' => 18,
                'category_id' => $categories->where('slug', 'accessoires-informatiques')->first()->id,
                'is_active' => true,
                'specifications' => [
                    'Résolution vidéo' => 'Full HD 1080p à 30 fps',
                    'Champ de vision' => '78° diagonal',
                    'Mise au point' => 'Automatique',
                    'Microphones' => 'Stéréo intégrés',
                    'Compatibilité' => 'Windows, Mac, Chrome OS',
                    'Fixation' => 'Clip universel',
                    'État' => 'Reconditionnée Grade A'
                ]
            ],
            
            // Composants PC
            [
                'name' => 'RAM DDR4 16Go (2x8Go) Corsair Vengeance LPX',
                'short_description' => 'Mémoire RAM DDR4 16Go haute performance pour upgrade PC.',
                'description' => 'Kit mémoire Corsair Vengeance LPX 16Go (2x8Go) DDR4-3200. Mémoire haute performance pour gaming et applications exigeantes. Compatible avec la plupart des cartes mères.',
                'price' => 65000,
                'stock' => 20,
                'category_id' => $categories->where('slug', 'composants-pc')->first()->id,
                'is_active' => true,
                'specifications' => [
                    'Capacité' => '16 Go (2 x 8 Go)',
                    'Type' => 'DDR4',
                    'Fréquence' => '3200 MHz',
                    'Latence' => 'CL16',
                    'Tension' => '1.35V',
                    'Format' => 'DIMM 288 broches',
                    'État' => 'Neuf'
                ]
            ],
            [
                'name' => 'SSD Samsung 980 NVMe 500Go',
                'short_description' => 'SSD NVMe Samsung 500Go pour booster les performances de votre PC.',
                'description' => 'Samsung 980 NVMe SSD 500Go, stockage ultra-rapide pour améliorer significativement les performances de votre ordinateur. Installation facile et vitesses exceptionnelles.',
                'price' => 55000,
                'stock' => 15,
                'category_id' => $categories->where('slug', 'composants-pc')->first()->id,
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'Capacité' => '500 Go',
                    'Interface' => 'NVMe PCIe 3.0 x4',
                    'Format' => 'M.2 2280',
                    'Vitesse lecture' => 'Jusqu\'à 3500 Mo/s',
                    'Vitesse écriture' => 'Jusqu\'à 3000 Mo/s',
                    'Garantie' => '5 ans',
                    'État' => 'Neuf'
                ]
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
