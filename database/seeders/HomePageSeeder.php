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
                    'headline_light_1' => ' une nouvelle facon',
                    'headline_light_2' => 'de trouver le ',
                    'headline_strong_2' => 'bien 🏠 de vos reves',
                    'subtitle' => 'Nous vous aidons a trouver le bien ideal, un projet a la fois. Votre satisfaction est notre priorite.',
                    'tag_1' => 'Acheter un bien',
                    'tag_2' => 'Vendre un bien',
                ],
            ],
            [
                'type' => 'about',
                'order' => 2,
                'config' => [
                    'eyebrow' => 'A PROPOS',
                    'strong_text' => 'Nous sommes votre partenaire de confiance dans l\'immobilier. Notre equipe ',
                    'light_text' => 'est dediee a vous offrir un service personnalise et les meilleurs resultats possibles. De la recherche de votre bien ideal a la vente de votre propriete au juste prix, nous vous accompagnons a chaque etape.',
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
                    'eyebrow' => 'COMMENT CA MARCHE',
                    'title' => 'Comment ca marche ?',
                    'steps' => [
                        ['title' => 'Verifier', 'text' => 'Fournissez les documents necessaires pour verifier votre identite et securiser la transaction.'],
                        ['title' => 'Rechercher un bien', 'text' => 'Utilisez nos outils de recherche pour filtrer les biens selon la localisation, le prix, la taille et bien plus.'],
                        ['title' => 'Concretiser', 'text' => 'Une fois votre bien ideal trouve, soumettez votre offre directement depuis la plateforme.'],
                    ],
                ],
            ],
            [
                'type' => 'property_grid',
                'order' => 5,
                'config' => [
                    'eyebrow' => 'EXPLORE',
                    'title' => 'Decouvrez nos derniers biens',
                    'source' => 'latest',
                    'limit' => 3,
                    'show_intro_card' => true,
                    'intro_title' => 'Nouvelles opportunites',
                    'intro_text' => "Restez a l'affut de nos dernieres annonces et trouvez le bien qui vous correspond.",
                ],
            ],
            [
                'type' => 'property_grid',
                'order' => 6,
                'config' => [
                    'eyebrow' => 'POPULAR',
                    'title' => 'Meilleurs biens a louer',
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
                    'title' => 'Questions frequentes',
                ],
            ],
            [
                'type' => 'contact',
                'order' => 8,
                'config' => [
                    'eyebrow' => 'CONTACT',
                    'title' => 'Vous ne savez pas par ou commencer ? Contactez-nous et remplissez le formulaire.',
                    'subtitle' => 'Contactez-nous et dites-nous ce dont vous avez besoin.',
                ],
            ],
            [
                'type' => 'footer',
                'order' => 9,
                'config' => [
                    'nav_links' => [
                        ['label' => 'Vendre un bien', 'href' => '#'],
                        ['label' => 'Acheter un bien', 'href' => '#'],
                        ['label' => 'Louer', 'href' => '#'],
                        ['label' => 'A propos', 'href' => '#'],
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
