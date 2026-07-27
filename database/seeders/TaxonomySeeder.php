<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\PropertyStyle;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    /**
     * Donnees d'exemple pour developper/tester le back-office et les formulaires -
     * a remplacer par le vrai catalogue une fois celui-ci gere depuis l'admin (module 7).
     */
    public function run(): void
    {
        foreach (['Paris', 'Lyon', 'Marseille'] as $name) {
            City::firstOrCreate(['name' => $name]);
        }

        foreach (['Appartement', 'Villa', 'Maison', 'Bureau', 'Terrain'] as $name) {
            PropertyType::firstOrCreate(['name' => $name]);
        }

        foreach (['Moderne', 'Industriel', 'Contemporain', 'Traditionnel'] as $name) {
            PropertyStyle::firstOrCreate(['name' => $name]);
        }
    }
}
