<?php

namespace App\Filament\Resources\Insumos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InsumoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                Select::make('tipo')
                    ->options(['filamento' => 'Filamento', 'resina' => 'Resina', 'outro' => 'Outro'])
                    ->default('filamento')
                    ->required(),
                TextInput::make('cor'),
                TextInput::make('marca'),
                Select::make('unidade')
                    ->options(['g' => 'G', 'kg' => 'Kg', 'ml' => 'Ml', 'L' => 'L', 'un' => 'Un'])
                    ->default('g')
                    ->required(),
                TextInput::make('quantidade_atual')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('quantidade_minima')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('custo_unitario')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('fornecedor'),
                Toggle::make('ativo')
                    ->required(),
            ]);
    }
}
