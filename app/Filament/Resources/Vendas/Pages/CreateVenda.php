<?php

namespace App\Filament\Resources\Vendas\Pages;

use App\Filament\Resources\Vendas\VendaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVenda extends CreateRecord
{
    protected static string $resource = VendaResource::class;

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
