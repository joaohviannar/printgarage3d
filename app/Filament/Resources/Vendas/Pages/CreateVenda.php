<?php

namespace App\Filament\Resources\Vendas\Pages;

use App\Exceptions\EstoqueInsuficienteException;
use App\Filament\Resources\Vendas\VendaResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateVenda extends CreateRecord
{
    protected static string $resource = VendaResource::class;

    /**
     * Sem isto, faltar estoque estoura como erro 500 e o painel mostra apenas
     * "Erro ao carregar a página" — o usuário não descobre qual produto travou
     * a venda nem o que fazer. A exceção já traz produto e quantidades.
     */
    protected function handleRecordCreation(array $data): Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (EstoqueInsuficienteException $e) {
            Notification::make()
                ->title('Venda não registrada: falta estoque')
                ->body($e->getMessage() . ' Se essa peça é impressa só depois da venda, marque o produto como "sob encomenda" no cadastro.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    /**
     * Apos criar a venda (e seus itens via Repeater), recalcula subtotal/total
     * com base nos itens reais salvos no banco.
     */
    protected function afterCreate(): void
    {
        $this->record->refresh();
        $this->record->recalcular();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Venda registrada! Estoque atualizado automaticamente.';
    }
}
