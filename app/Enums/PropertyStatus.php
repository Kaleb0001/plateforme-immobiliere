<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Brouillon = 'brouillon';
    case EnAttenteValidation = 'en_attente_validation';
    case Publie = 'publie';
    case Refuse = 'refuse';
    case Vendu = 'vendu';
    case Loue = 'loue';

    public function label(): string
    {
        return match ($this) {
            self::Brouillon => 'Brouillon',
            self::EnAttenteValidation => 'En attente de validation',
            self::Publie => 'Publie',
            self::Refuse => 'Refuse',
            self::Vendu => 'Vendu',
            self::Loue => 'Loue',
        };
    }
}
