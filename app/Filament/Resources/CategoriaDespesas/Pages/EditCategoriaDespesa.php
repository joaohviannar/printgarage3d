<?php

namespace App\Filament\Resources\CategoriaDespesas\Pages;

use App\Filament\Resources\CategoriaDespesas\CategoriaDespesaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoriaDespesa extends EditRecord
{
    protected static string $resource = CategoriaDespesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
