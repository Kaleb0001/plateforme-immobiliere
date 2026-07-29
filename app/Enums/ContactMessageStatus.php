<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case NonLu = 'non_lu';
    case Lu = 'lu';
    case Traite = 'traite';

    public function label(): string
    {
        return match ($this) {
            self::NonLu => 'Non lu',
            self::Lu => 'Lu',
            self::Traite => 'Traité',
        };
    }
}
