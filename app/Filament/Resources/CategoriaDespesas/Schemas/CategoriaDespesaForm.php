<?php

namespace App\Filament\Resources\CategoriaDespesas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoriaDespesaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('cor')
                    ->required()
                    ->default('#888888'),
                Toggle::make('ativo')
                    ->required(),
            ]);
    }
}
