<?php

namespace App\Filament\Resources\LinkBios\Pages;

use App\Filament\Resources\LinkBios\LinkBioResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLinkBios extends ListRecords
{
    protected static string $resource = LinkBioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verPagina')
                ->label('Ver página ↗')
                ->color('gray')
                ->url(fn () => route('site.links'))
                ->openUrlInNewTab(),

            CreateAction::make()->label('Novo link'),
        ];
    }
}
