<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::firstOrCreate(
            ['slug' => 'accueil'],
            ['meta_title' => 'Accueil', 'meta_description' => 'Trouvez le bien immobilier qui vous correspond.']
        );

        $sections = [
            [
                'type' => 'hero',
                'order' => 1,
                'config' => [
                    'headline_strong_1' => 'Nous vous offrons',
                    'headline_light_1' => ' une nouvelle façon',
                    'headline_light_2' => 'de trouver le ',
                    'headline_strong_2' => 'bien 🏠 de vos rêves',
                    'subtitle' => 'Nous vous aidons à trouver le bien idéal, un projet à la fois. Votre satisfaction est notre priorité.',
                    'tag_1' => 'Acheter un bien',
                    'tag_2' => 'Vendre un bien',
                ],
            ],
            [
                'type' => 'about',
                'order' => 2,
                'config' => [
                    'eyebrow' => 'À PROPOS',
                    'strong_text' => "Nous sommes votre partenaire de confiance dans l'immobilier. Notre équipe ",
                    'light_text' => 'est dédiée à vous offrir un service personnalisé et les meilleurs résultats possibles. De la recherche de votre bien idéal à la vente de votre propriété au juste prix, nous vous accompagnons à chaque étape.',
                ],
            ],
            [
                'type' => 'featured_showcase',
                'order' => 3,
                'config' => [],
            ],
            [
                'type' => 'how_it_works',
                'order' => 4,
                'config' => [
                    'eyebrow' => 'COMMENT ÇA MARCHE',
                    'title' => 'Comment ça marche ?',
                    'steps' => [
                        ['title' => 'Vérifier', 'text' => 'Fournissez les documents nécessaires pour vérifier votre identité et sécuriser la transaction.'],
                        ['title' => 'Rechercher un bien', 'text' => 'Utilisez nos outils de recherche pour filtrer les biens selon la localisation, le prix, la taille et bien plus.'],
                        ['title' => 'Concrétiser', 'text' => 'Une fois votre bien idéal trouvé, soumettez votre offre directement depuis la plateforme.'],
                    ],
                ],
            ],
            [
                'type' => 'property_grid',
                'order' => 5,
                'config' => [
                    'eyebrow' => 'EXPLORE',
                    'title' => 'Découvrez nos derniers biens',
                    'source' => 'latest',
                    'limit' => 3,
                    'show_intro_card' => true,
                    'intro_title' => 'Nouvelles opportunités',
                    'intro_text' => "Restez à l'affût de nos dernières annonces et trouvez le bien qui vous correspond.",
                ],
            ],
            [
                'type' => 'property_grid',
                'order' => 6,
                'config' => [
                    'eyebrow' => 'POPULAR',
                    'title' => 'Meilleurs biens à louer',
                    'source' => 'rent',
                    'limit' => 4,
                    'show_intro_card' => false,
                ],
            ],
            [
                'type' => 'faq',
                'order' => 7,
                'config' => [
                    'eyebrow' => 'FAQ',
                    'title' => 'Questions fréquentes',
                ],
            ],
            [
                'type' => 'contact',
                'order' => 8,
                'config' => [
                    'eyebrow' => 'CONTACT',
                    'title' => 'Vous ne savez pas par où commencer ? Contactez-nous et remplissez le formulaire.',
                    'subtitle' => 'Contactez-nous et dites-nous ce dont vous avez besoin.',
                ],
            ],
            [
                'type' => 'footer',
                'order' => 9,
                'config' => [
                    'nav_links' => [
                        ['label' => 'Vendre un bien', 'href' => route('register')],
                        ['label' => 'Acheter un bien', 'href' => route('properties.search', ['transaction' => 'vente'])],
                        ['label' => 'Louer', 'href' => route('properties.search', ['transaction' => 'location'])],
                        ['label' => 'À propos', 'href' => route('about')],
                        ['label' => 'Ressources', 'href' => '#'],
                    ],
                    'social_links' => [
                        ['label' => 'Instagram', 'href' => '#'],
                        ['label' => 'LinkedIn', 'href' => '#'],
                        ['label' => 'Facebook', 'href' => '#'],
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionData) {
            $page->sections()->updateOrCreate(
                ['type' => $sectionData['type'], 'order' => $sectionData['order']],
                ['config' => $sectionData['config'], 'visible' => true]
            );
        }
    }
}
