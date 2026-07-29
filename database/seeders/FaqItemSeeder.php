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
                'answer' => 'Notre plateforme connecte acheteurs, locataires et vendeurs grâce à des outils de recherche intuitifs et des annonces détaillées.',
            ],
            [
                'question' => "Est-ce gratuit d'utiliser la plateforme ?",
                'answer' => "Oui, la consultation des biens et la création d'un compte sont entièrement gratuites.",
            ],
            [
                'question' => 'Comment trouver un bien à acheter ou à vendre ?',
                'answer' => 'Utilisez la recherche pour trouver un bien, ou créez un compte pour soumettre le vôtre.',
            ],
            [
                'question' => 'Quelles informations contiennent les annonces ?',
                'answer' => 'Chaque annonce précise le prix, la localisation, la surface, le nombre de pièces et les photos du bien.',
            ],
            [
                'question' => 'Comment trouver un bien à louer ?',
                'answer' => 'Utilisez le filtre « Location » dans la barre de recherche pour n\'afficher que les biens disponibles à la location.',
            ],
        ];

        foreach ($items as $i => $item) {
            FaqItem::updateOrCreate(
                ['question' => $item['question']],
                ['answer' => $item['answer'], 'order' => $i + 1, 'published' => true]
            );
        }
    }
}
