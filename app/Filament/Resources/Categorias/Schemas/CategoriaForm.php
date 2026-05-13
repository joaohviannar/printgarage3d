<?php

namespace App\Filament\Resources\Categorias\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(120)
                    ->unique(ignoreRecord: true),

                Select::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'B2C' => 'B2C — Para Pessoas',
                        'B2B' => 'B2B — Para Empresas',
                    ])
                    ->required(),

                Textarea::make('descricao')
                    ->label('Descrição')
                    ->columnSpanFull()
                    ->rows(3),

                TextInput::make('ordem')
                    ->label('Ordem de exibição')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->default(0)
                    ->helperText('Menor = aparece primeiro'),

                Toggle::make('ativo')
                    ->label('Ativa')
                    ->default(true),
            ]);
    }
}
