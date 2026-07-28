<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Enums\TransactionType;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyStyle;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyDemoSeeder extends Seeder
{
    /**
     * Quelques biens d'exemple pour visualiser les composants (carte, carrousel...)
     * avant que le vrai back-office de gestion des biens n'existe (module 7).
     * A supprimer ou remplacer sans consequence.
     */
    public function run(): void
    {
        $city = City::first();
        $type = PropertyType::first();
        $style = PropertyStyle::first();

        $samples = [
            [
                'title' => 'Villa Horizon',
                'price' => 420000,
                'featured' => true,
                'description' => 'Une villa lumineuse avec vue degagee, pensee pour recevoir en toute saison.',
            ],
            [
                'title' => 'Appartement Lumiere',
                'price' => 195000,
                'featured' => false,
                'description' => 'Un appartement clair, proche des commerces et des transports.',
            ],
            [
                'title' => 'Maison des Oliviers',
                'price' => 310000,
                'featured' => false,
                'description' => 'Une maison familiale avec jardin arbore.',
            ],
        ];

        foreach ($samples as $sample) {
            Property::firstOrCreate(
                ['title' => $sample['title']],
                [
                    'description' => $sample['description'],
                    'transaction_type' => TransactionType::Vente,
                    'property_type_id' => $type?->id,
                    'property_style_id' => $style?->id,
                    'price' => $sample['price'],
                    'city_id' => $city?->id,
                    'status' => PropertyStatus::Publie,
                    'featured' => $sample['featured'],
                    'published_at' => now(),
                ]
            );
        }
    }
}
