<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Enums\TransactionType;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyStyle;
use App\Models\PropertyType;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyDemoSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Biens d'exemple pour visualiser les composants et assembler la page
     * d'accueil, avant que le vrai back-office de gestion des biens n'existe
     * (module 7). A supprimer ou remplacer sans consequence.
     *
     * Photos : generees localement (GD, deja requis par les conversions
     * d'images du modele Property) plutot que telechargees depuis
     * picsum.photos. L'ancienne version dependait d'un acces internet et
     * d'un certificat SSL valide au moment du seed - une source frequente
     * d'echecs silencieux (pare-feu, proxy, CA obsolete sur XAMPP/Windows).
     * Ce ne sont pas de vraies photos de biens, juste de quoi visualiser la
     * mise en page correctement en attendant les vraies photos.
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
                'description' => 'Une villa lumineuse avec vue dégagée, pensée pour recevoir en toute saison.',
                'points_of_interest' => [
                    ['label' => 'Vue mer', 'position' => 'top-left'],
                    ['label' => 'Piscine', 'position' => 'bottom-right'],
                ],
            ],
            [
                'title' => 'Appartement Lumière',
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
                'description' => 'Une maison familiale avec jardin arboré.',
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
                'description' => 'Un studio pratique à deux pas du port.',
            ],
            [
                'title' => 'Duplex des Pins',
                'price' => 1450,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un duplex calme entouré de verdure.',
            ],
            [
                'title' => 'Résidence Belvédère',
                'price' => 980,
                'featured' => false,
                'transaction_type' => TransactionType::Location,
                'description' => 'Un appartement avec une belle vue dégagée.',
            ],
        ];

        foreach ($samples as $sample) {
            $property = Property::updateOrCreate(
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

            if ($property->getMedia('gallery')->isEmpty()) {
                try {
                    $path = $this->generatePlaceholderImage($sample['title']);
                    $property->addMedia($path)
                        ->usingFileName(Str::slug($sample['title']).'.jpg')
                        ->toMediaCollection('gallery');
                } catch (\Throwable $e) {
                    // Extension GD indisponible ou erreur inattendue : on continue
                    // sans photo plutôt que de faire échouer tout le seeder.
                    $this->command?->warn("Photo non générée pour {$sample['title']} : {$e->getMessage()}");
                }
            }
        }
    }
}
