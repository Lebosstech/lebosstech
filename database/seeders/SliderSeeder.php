<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'LEBOSS TECH MARKET',
                'subtitle' => 'Spécialiste de l\'informatique reconditionnée - Ordinateurs, Imprimantes & Accessoires',
                'button_text' => 'Découvrir nos produits',
                'button_link' => '/produits',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Ordinateurs Reconditionnés',
                'subtitle' => 'PC de bureau et portables de marques premium. Testés, garantis et à prix imbattables',
                'button_text' => 'Voir les ordinateurs',
                'button_link' => '/categories/ordinateurs-portables',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Imprimantes Laser',
                'subtitle' => 'Imprimantes laser professionnelles reconditionnées. Mono et couleur disponibles',
                'button_text' => 'Voir les imprimantes',
                'button_link' => '/categories/imprimantes-laser',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Garantie & Service',
                'subtitle' => 'Tous nos produits reconditionnés sont garantis 6 mois. Livraison rapide à Abidjan',
                'button_text' => 'Nous contacter',
                'button_link' => 'https://wa.me/2250566821609',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }
    }
}
