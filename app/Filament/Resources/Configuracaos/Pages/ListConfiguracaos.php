<?php

namespace App\Filament\Resources\Configuracaos\Pages;

use App\Filament\Resources\Configuracaos\ConfiguracaoResource;
use Filament\Resources\Pages\ListRecords;

class ListConfiguracaos extends ListRecords
{
    protected static string $resource = ConfiguracaoResource::class;

    /**
     * Remove botao "Criar" - chaves sao predefinidas.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
