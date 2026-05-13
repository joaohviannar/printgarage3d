<?php

namespace App\Filament\Resources\Configuracaos\Pages;

use App\Filament\Resources\Configuracaos\ConfiguracaoResource;
use Filament\Resources\Pages\EditRecord;

class EditConfiguracao extends EditRecord
{
    protected static string $resource = ConfiguracaoResource::class;

    /**
     * Remove botao Delete - chaves de configuracao sao predefinidas.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Configuração atualizada com sucesso';
    }
}
