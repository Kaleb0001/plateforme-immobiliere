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
     * Biens d'exemple pour visualiser les composants et assembler la page
     * d'accueil, avant que le vrai back-office de gestion des biens n'existe
     * (module 7). A supprimer ou remplacer sans consequence.
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
                'transaction_type' => TransactionType::Vente,
                'description' => 'Une villa lumineuse avec vue degagee, pensee pour recevoir en toute saison.',
                'points_of_interest' => [
                    ['label' => 'Vue mer', 'position' => 'top-left'],
                    ['label' => 'Piscine', 'position' => 'bottom-right'],
                ],
            ],
            [
                'title' => 'Appartement Lumiere',
                'price' => 195000,
                'featured' => false,
                'transaction_type' => TransactionType::Vente,
                'description' => 'Un appartement clair, proche des commerces et des transports.',
            ],
            [
                'title' => 'Maison des Oliviers',
                'price' => 310000,
                'featured' => false,
                'transaction_type' => TransactionType::Vente,
                'description' => 'Une maison familiale avec jardin arbore.',
            ],
            [
                'title' => 'Loft Central',
                'price' => 1200,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un loft industriel en plein centre-ville.',
            ],
            [
                'title' => 'Studio Marina',
                'price' => 750,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un studio pratique a deux pas du port.',
            ],
            [
                'title' => 'Duplex des Pins',
                'price' => 1450,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un duplex calme entoure de verdure.',
            ],
            [
                'title' => 'Residence Belvedere',
                'price' => 980,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un appartement avec une belle vue degagee.',
            ],
        ];

        foreach ($samples as $sample) {
            Property::firstOrCreate(
                ['title' => $sample['title']],
                [
                    'description' => $sample['description'],
                    'transaction_type' => $sample['transaction_type'],
                    'property_type_id' => $type?->id,
                    'property_style_id' => $style?->id,
                    'price' => $sample['price'],
                    'city_id' => $city?->id,
                    'status' => PropertyStatus::Publie,
                    'featured' => $sample['featured'],
                    'points_of_interest' => $sample['points_of_interest'] ?? null,
                    'published_at' => now(),
                ]
            );
        }
    }
}
