<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Enums\ContactMessageStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom')->disabled(),
                TextInput::make('email')->label('Email')->disabled(),
                Textarea::make('message')->label('Message')->disabled()->rows(4)->columnSpanFull(),

                Select::make('status')
                    ->label('Statut')
                    ->options([
                        ContactMessageStatus::NonLu->value => 'Non lu',
                        ContactMessageStatus::Lu->value => 'Lu',
                        ContactMessageStatus::Traite->value => 'Traité',
                    ])
                    ->required(),
            ]);
    }
}
