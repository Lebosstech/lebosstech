<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ordinateurs de Bureau',
                'slug' => 'ordinateurs-bureau',
                'description' => 'Ordinateurs de bureau reconditionnés de qualité professionnelle. PC complets, tours et mini PC pour bureautique et gaming.',
                'is_active' => true,
            ],
            [
                'name' => 'Ordinateurs Portables',
                'slug' => 'ordinateurs-portables',
                'description' => 'Laptops reconditionnés de marques premium : Dell, HP, Lenovo, Apple. Testés et garantis pour tous vos besoins.',
                'is_active' => true,
            ],
            [
                'name' => 'Imprimantes Laser',
                'slug' => 'imprimantes-laser',
                'description' => 'Imprimantes laser reconditionnées mono et couleur. Idéales pour bureaux et particuliers avec cartouches disponibles.',
                'is_active' => true,
            ],
            [
                'name' => 'Écrans & Moniteurs',
                'slug' => 'ecrans-moniteurs',
                'description' => 'Écrans LCD, LED et moniteurs reconditionnés. Toutes tailles disponibles pour bureautique et gaming.',
                'is_active' => true,
            ],
            [
                'name' => 'Accessoires Informatiques',
                'slug' => 'accessoires-informatiques',
                'description' => 'Claviers, souris, webcams, haut-parleurs et tous accessoires informatiques neufs et reconditionnés.',
                'is_active' => true,
            ],
            [
                'name' => 'Composants PC',
                'slug' => 'composants-pc',
                'description' => 'RAM, disques durs, SSD, cartes graphiques et composants PC reconditionnés pour upgrade et réparation.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
