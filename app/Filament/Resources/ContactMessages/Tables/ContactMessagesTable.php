<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Enums\ContactMessageStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('message')->label('Message')->limit(50),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        ContactMessageStatus::NonLu => 'danger',
                        ContactMessageStatus::Lu => 'warning',
                        ContactMessageStatus::Traite => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')->label('Reçu le')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Statut')->options([
                    ContactMessageStatus::NonLu->value => 'Non lu',
                    ContactMessageStatus::Lu->value => 'Lu',
                    ContactMessageStatus::Traite->value => 'Traité',
                ]),
            ])
            ->recordActions([
                Action::make('marquerTraite')
                    ->label('Marquer traité')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== ContactMessageStatus::Traite)
                    ->action(fn ($record) => $record->update(['status' => ContactMessageStatus::Traite])),
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
