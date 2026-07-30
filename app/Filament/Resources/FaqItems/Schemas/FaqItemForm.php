<?php

namespace App\Filament\Resources\FaqItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('Question')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('answer')
                    ->label('Réponse')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Toggle::make('published')
                    ->label('Publiée')
                    ->default(true),
            ]);
    }
}
