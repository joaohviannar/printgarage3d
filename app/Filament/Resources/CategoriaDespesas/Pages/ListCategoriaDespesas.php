<?php

namespace App\Filament\Resources\CategoriaDespesas\Pages;

use App\Filament\Resources\CategoriaDespesas\CategoriaDespesaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoriaDespesas extends ListRecords
{
    protected static string $resource = CategoriaDespesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
