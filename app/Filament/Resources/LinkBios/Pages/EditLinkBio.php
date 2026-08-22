<?php

namespace App\Filament\Resources\LinkBios\Pages;

use App\Filament\Resources\LinkBios\LinkBioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLinkBio extends EditRecord
{
    protected static string $resource = LinkBioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
