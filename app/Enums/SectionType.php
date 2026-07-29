<?php

namespace App\Enums;

enum SectionType: string
{
    case Hero = 'hero';
    case About = 'about';
    case FeaturedShowcase = 'featured_showcase';
    case HowItWorks = 'how_it_works';
    case PropertyGrid = 'property_grid';
    case Faq = 'faq';
    case Contact = 'contact';
    case Footer = 'footer';
    case HtmlLibre = 'html_libre';

    public function label(): string
    {
        return match ($this) {
            self::Hero => 'Hero',
            self::About => 'À propos',
            self::FeaturedShowcase => 'Bien vedette',
            self::HowItWorks => 'Comment ça marche',
            self::PropertyGrid => 'Grille de biens',
            self::Faq => 'FAQ',
            self::Contact => 'Contact',
            self::Footer => 'Footer',
            self::HtmlLibre => 'HTML libre',
        };
    }
}
