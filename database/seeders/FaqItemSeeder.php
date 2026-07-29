<?php

namespace Database\Seeders;

use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question' => 'Comment fonctionne notre plateforme ?',
                'answer' => "Notre plateforme connecte acheteurs, locataires et vendeurs grace a des outils de recherche intuitifs et des annonces detaillees.",
            ],
            [
                'question' => "Est-ce gratuit d'utiliser la plateforme ?",
                'answer' => "Oui, la consultation des biens et la creation d'un compte sont entierement gratuites.",
            ],
            [
                'question' => 'Comment trouver un bien a acheter ou a vendre ?',
                'answer' => 'Utilisez la recherche pour trouver un bien, ou creez un compte pour soumettre le votre.',
            ],
            [
                'question' => 'Quelles informations contiennent les annonces ?',
                'answer' => 'Chaque annonce precise le prix, la localisation, la surface, le nombre de pieces et les photos du bien.',
            ],
            [
                'question' => 'Comment trouver un bien a louer ?',
                'answer' => 'Utilisez le filtre "Location" dans la barre de recherche pour n\'afficher que les biens disponibles a la location.',
            ],
        ];

        foreach ($items as $i => $item) {
            FaqItem::firstOrCreate(
                ['question' => $item['question']],
                ['answer' => $item['answer'], 'order' => $i + 1, 'published' => true]
            );
        }
    }
}
