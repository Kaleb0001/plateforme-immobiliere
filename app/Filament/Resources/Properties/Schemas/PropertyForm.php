<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Enums\PropertyStatus;
use App\Enums\TransactionType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('URL (slug)')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(4)
                    ->columnSpanFull(),

                Select::make('transaction_type')
                    ->label('Transaction')
                    ->options([
                        TransactionType::Vente->value => 'Vente',
                        TransactionType::Location->value => 'Location',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Statut')
                    ->options([
                        PropertyStatus::Brouillon->value => 'Brouillon',
                        PropertyStatus::EnAttenteValidation->value => 'En attente de validation',
                        PropertyStatus::Publie->value => 'Publié',
                        PropertyStatus::Refuse->value => 'Refusé',
                        PropertyStatus::Vendu->value => 'Vendu',
                        PropertyStatus::Loue->value => 'Loué',
                    ])
                    ->required(),

                TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->prefix('€')
                    ->required(),

                Select::make('city_id')
                    ->label('Ville')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('property_type_id')
                    ->label('Type de bien')
                    ->relationship('propertyType', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('property_style_id')
                    ->label('Style')
                    ->relationship('propertyStyle', 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('address')
                    ->label('Adresse')
                    ->columnSpanFull(),

                TextInput::make('latitude')->label('Latitude')->numeric(),
                TextInput::make('longitude')->label('Longitude')->numeric(),
                TextInput::make('surface')->label('Surface (m²)')->numeric(),
                TextInput::make('bedrooms')->label('Chambres')->numeric(),
                TextInput::make('bathrooms')->label('Salles de bain')->numeric(),

                Toggle::make('featured')->label('À la une'),

                Select::make('assigned_agent_id')
                    ->label('Agent assigné')
                    ->relationship('assignedAgent', 'name', fn ($query) => $query->role('agent'))
                    ->searchable()
                    ->preload(),

                Textarea::make('rejection_reason')
                    ->label('Motif du refus')
                    ->columnSpanFull(),

                Repeater::make('points_of_interest')
                    ->label("Points d'intérêt (badges sur la photo)")
                    ->schema([
                        TextInput::make('label')->label('Texte du badge')->required(),
                        Select::make('position')->label('Position')->options([
                            'top-left' => 'Haut gauche',
                            'top-right' => 'Haut droite',
                            'bottom-left' => 'Bas gauche',
                            'bottom-right' => 'Bas droite',
                        ])->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->label('Photos')
                    ->columnSpanFull(),

                TextInput::make('meta_title')->label('Titre SEO (optionnel)'),
                TextInput::make('meta_description')->label('Description SEO (optionnel)'),
                DateTimePicker::make('published_at')->label('Date de publication'),
            ])
            ->columns(2);
    }
}
