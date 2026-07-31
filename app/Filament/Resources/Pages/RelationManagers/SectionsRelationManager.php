<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Type de section')
                    ->options([
                        'hero' => 'Hero',
                        'about' => 'À propos',
                        'featured_showcase' => 'Bien vedette',
                        'how_it_works' => 'Comment ça marche',
                        'property_grid' => 'Grille de biens',
                        'faq' => 'FAQ',
                        'contact' => 'Contact',
                        'footer' => 'Footer',
                    ])
                    ->required()
                    ->live()
                    ->disabledOn('edit'),

                TextInput::make('order')->label('Ordre')->numeric()->default(0)->required(),
                Toggle::make('visible')->label('Visible')->default(true),

                TextInput::make('config.headline_strong_1')->label('Titre (gras) - partie 1')
                    ->visible(fn ($get) => $get('type') === 'hero'),
                TextInput::make('config.headline_light_1')->label('Titre (atténué) - partie 1')
                    ->visible(fn ($get) => $get('type') === 'hero'),
                TextInput::make('config.headline_light_2')->label('Titre (atténué) - partie 2')
                    ->visible(fn ($get) => $get('type') === 'hero'),
                TextInput::make('config.headline_strong_2')->label('Titre (gras) - partie 2')
                    ->visible(fn ($get) => $get('type') === 'hero'),
                Textarea::make('config.subtitle')->label('Sous-titre')
                    ->visible(fn ($get) => in_array($get('type'), ['hero', 'contact'])),

                TextInput::make('config.eyebrow')->label('Étiquette (ex. A PROPOS)')
                    ->visible(fn ($get) => in_array($get('type'), ['about', 'how_it_works', 'property_grid', 'faq', 'contact'])),
                TextInput::make('config.title')->label('Titre de section')
                    ->visible(fn ($get) => in_array($get('type'), ['how_it_works', 'property_grid', 'faq', 'contact'])),
                Textarea::make('config.strong_text')->label('Texte (gras)')
                    ->visible(fn ($get) => $get('type') === 'about'),
                Textarea::make('config.light_text')->label('Texte (atténué)')
                    ->visible(fn ($get) => $get('type') === 'about'),

                Repeater::make('config.steps')->label('Étapes')
                    ->schema([
                        TextInput::make('title')->label("Titre de l'étape")->required(),
                        Textarea::make('text')->label('Texte')->required(),
                    ])
                    ->visible(fn ($get) => $get('type') === 'how_it_works'),

                Select::make('config.source')->label('Source des biens')
                    ->options(['latest' => 'Plus récents', 'rent' => 'À louer', 'featured' => 'À la une'])
                    ->visible(fn ($get) => $get('type') === 'property_grid'),
                TextInput::make('config.limit')->label('Nombre de biens')->numeric()
                    ->visible(fn ($get) => $get('type') === 'property_grid'),
                Toggle::make('config.show_intro_card')->label("Afficher la carte d'intro")
                    ->visible(fn ($get) => $get('type') === 'property_grid'),
                TextInput::make('config.intro_title')->label("Titre de la carte d'intro")
                    ->visible(fn ($get) => $get('type') === 'property_grid'),
                Textarea::make('config.intro_text')->label("Texte de la carte d'intro")
                    ->visible(fn ($get) => $get('type') === 'property_grid'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')->label('Type'),
                TextColumn::make('order')->label('Ordre'),
                IconColumn::make('visible')->label('Visible')->boolean(),
            ])
            ->reorderable('order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
