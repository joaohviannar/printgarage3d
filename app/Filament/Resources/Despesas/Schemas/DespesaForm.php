<?php

namespace App\Filament\Resources\Despesas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DespesaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados da Despesa')
                    ->columns(2)
                    ->schema([
                        Select::make('categoria_despesa_id')
                            ->label('Categoria')
                            ->relationship('categoria', 'nome')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('user_id')
                            ->label('Lançado por')
                            ->relationship('user', 'name')
                            ->default(fn() => auth()->id())
                            ->required(),

                        TextInput::make('descricao')
                            ->label('Descrição')
                            ->required()
                            ->maxLength(200)
                            ->columnSpanFull(),

                        TextInput::make('valor')
                            ->label('Valor (R$)')
                            ->required()
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0),

                        DatePicker::make('data_despesa')
                            ->label('Data da Despesa')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        Select::make('forma_pagamento')
                            ->label('Forma de Pagamento')
                            ->options([
                                'pix' => 'PIX',
                                'dinheiro' => 'Dinheiro',
                                'cartao_credito' => 'Cartão de Crédito',
                                'cartao_debito' => 'Cartão de Débito',
                                'boleto' => 'Boleto',
                                'outro' => 'Outro',
                            ]),

                        Toggle::make('recorrente')
                            ->label('Despesa recorrente')
                            ->helperText('Marque se é uma despesa fixa mensal'),
                    ]),

                Section::make('Anexos e Observações')
                    ->collapsed()
                    ->schema([
                        FileUpload::make('anexo')
                            ->label('Comprovante / Nota')
                            ->disk('public')
                            ->directory('despesas')
                            ->maxSize(10240)
                            ->helperText('PDF, JPG ou PNG. Máximo 10MB'),

                        Textarea::make('observacoes')
                            ->label('Observações')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
