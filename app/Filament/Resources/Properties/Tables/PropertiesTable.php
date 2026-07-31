<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Enums\PropertyStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titre')->searchable(),
                TextColumn::make('transaction_type')->label('Transaction')->badge(),
                TextColumn::make('propertyType.name')->label('Type'),
                TextColumn::make('price')->label('Prix')->money('EUR')->sortable(),
                TextColumn::make('city.name')->label('Ville'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        PropertyStatus::Publie => 'success',
                        PropertyStatus::EnAttenteValidation => 'warning',
                        PropertyStatus::Refuse => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('featured')->label('À la une')->boolean(),
                TextColumn::make('submittedBy.name')->label('Soumis par')->placeholder("Créé par l'admin"),
                TextColumn::make('assignedAgent.name')->label('Agent'),
                TextColumn::make('published_at')->label('Publié le')->dateTime()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->label('Statut')->options([
                    PropertyStatus::Brouillon->value => 'Brouillon',
                    PropertyStatus::EnAttenteValidation->value => 'En attente de validation',
                    PropertyStatus::Publie->value => 'Publié',
                    PropertyStatus::Refuse->value => 'Refusé',
                    PropertyStatus::Vendu->value => 'Vendu',
                    PropertyStatus::Loue->value => 'Loué',
                ]),
                SelectFilter::make('transaction_type')->label('Transaction')->options([
                    'vente' => 'Vente',
                    'location' => 'Location',
                ]),
            ])
            ->recordActions([
                Action::make('approuver')
                    ->label('Approuver')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === PropertyStatus::EnAttenteValidation)
                    ->schema([
                        Select::make('assigned_agent_id')
                            ->label('Assigner à un agent')
                            ->relationship('assignedAgent', 'name', fn ($query) => $query->role('agent'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => PropertyStatus::Publie,
                            'assigned_agent_id' => $data['assigned_agent_id'],
                            'published_at' => now(),
                        ]);
                    }),
                Action::make('refuser')
                    ->label('Refuser')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === PropertyStatus::EnAttenteValidation)
                    ->schema([
                        Textarea::make('rejection_reason')->label('Motif du refus')->required(),
                    ])
                    ->action(fn ($record, array $data) => $record->update([
                        'status' => PropertyStatus::Refuse,
                        'rejection_reason' => $data['rejection_reason'],
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
