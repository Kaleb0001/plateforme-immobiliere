<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Enums\ContactMessageStatus;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    /**
     * Ouvrir un message le marque automatiquement "lu" (comme une boîte de
     * réception classique), plutôt que d'exiger une action manuelle en plus
     * de "Marquer traité" pour ce premier changement de statut. On mute la
     * donnée affichée dans le formulaire (mutateFormDataBeforeFill) *et* on
     * persiste le changement (afterFill) pour que les deux restent cohérents
     * - sinon un enregistrement sans y toucher réécrirait "non lu".
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (($data['status'] ?? null) === ContactMessageStatus::NonLu->value) {
            $data['status'] = ContactMessageStatus::Lu->value;
        }

        return $data;
    }

    protected function afterFill(): void
    {
        if ($this->record->status === ContactMessageStatus::NonLu) {
            $this->record->update(['status' => ContactMessageStatus::Lu]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
