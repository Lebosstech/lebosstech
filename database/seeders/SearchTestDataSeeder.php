<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\PopularSearch;

class SearchTestDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Marques populaires d'équipements informatiques
        $brands = [
            'Apple', 'Samsung', 'HP', 'Dell', 'Lenovo', 'Asus', 'Acer', 
            'Microsoft', 'Huawei', 'Xiaomi', 'Sony', 'Canon', 'Epson',
            'LG', 'TCL', 'Infinix', 'Tecno', 'Oppo', 'Vivo', 'OnePlus'
        ];
        
        $conditions = ['neuf', 'excellent', 'tres_bon', 'bon', 'correct'];
        
        // Mettre à jour les produits existants avec des marques et conditions
        Product::chunk(10, function ($products) use ($brands, $conditions) {
            foreach ($products as $product) {
                $product->update([
                    'brand' => $brands[array_rand($brands)],
                    'condition' => $conditions[array_rand($conditions)]
                ]);
            }
        });
        
        // Ajouter des recherches populaires de test
        $popularSearches = [
            'iPhone',
            'Samsung Galaxy',
            'MacBook',
            'HP Laptop',
            'Dell Inspiron',
            'iPad',
            'Gaming PC',
            'Smartphone',
            'Ordinateur portable',
            'Casque Bluetooth',
            'Souris gaming',
            'Clavier mécanique',
            'Écran',
            'Imprimante',
            'Tablette',
            'Accessoires',
            'Chargeur',
            'Câble USB',
            'Disque dur',
            'Mémoire RAM'
        ];
        
        foreach ($popularSearches as $index => $search) {
            PopularSearch::create([
                'query' => $search,
                'search_count' => rand(5, 50),
                'results_count' => rand(0, 20),
                'last_searched_at' => now()->subDays(rand(0, 30))
            ]);
        }
        
        $this->command->info('Données de test de recherche ajoutées avec succès !');
    }
}
