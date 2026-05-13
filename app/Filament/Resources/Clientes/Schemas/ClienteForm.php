<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                Select::make('tipo')
                    ->options(['PF' => 'P f', 'PJ' => 'P j'])
                    ->default('PF')
                    ->required(),
                TextInput::make('documento'),
                TextInput::make('telefone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('instagram'),
                Textarea::make('observacoes')
                    ->columnSpanFull(),
            ]);
    }
}
