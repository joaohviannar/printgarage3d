<?php

namespace App\Filament\Resources\Vendas\Pages;

use App\Filament\Resources\Vendas\VendaResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditVenda extends EditRecord
{
    protected static string $resource = VendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cancelar')
                ->label('Cancelar Venda')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => $this->record->status !== 'cancelado')
                ->requiresConfirmation()
                ->modalHeading('Cancelar esta venda?')
                ->modalDescription('Os itens serão devolvidos ao estoque automaticamente.')
                ->modalSubmitActionLabel('Sim, cancelar')
                ->action(function () {
                    $this->record->update(['status' => 'cancelado']);

                    Notification::make()
                        ->title('Venda cancelada e estoque restaurado')
                        ->success()
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            DeleteAction::make()
                ->before(function () {
                    // Antes de deletar a venda, devolve os itens ao estoque
                    if ($this->record->status !== 'cancelado') {
                        $this->record->update(['status' => 'cancelado']);
                    }
                }),
        ];
    }

    /**
     * Apos editar a venda, recalcula totais.
     */
    protected function afterSave(): void
    {
        $this->record->refresh();
        $this->record->recalcular();
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Venda atualizada!';
    }
}
