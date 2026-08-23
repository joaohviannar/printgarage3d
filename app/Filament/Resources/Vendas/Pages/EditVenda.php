<?php

namespace App\Filament\Resources\Vendas\Pages;

use App\Exceptions\EstoqueInsuficienteException;
use App\Filament\Resources\Vendas\VendaResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

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
     * Mesma proteção do CreateVenda: aumentar a quantidade de um item pode
     * faltar estoque, e o erro precisa dizer qual produto travou.
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
        } catch (EstoqueInsuficienteException $e) {
            Notification::make()
                ->title('Alteração não salva: falta estoque')
                ->body($e->getMessage() . ' Se essa peça é impressa só depois da venda, marque o produto como "sob encomenda" no cadastro.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }
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
