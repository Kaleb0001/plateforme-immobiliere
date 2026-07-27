<?php

namespace App\Enums;

enum TransactionType: string
{
    case Vente = 'vente';
    case Location = 'location';

    public function label(): string
    {
        return match ($this) {
            self::Vente => 'Vente',
            self::Location => 'Location',
        };
    }
}
