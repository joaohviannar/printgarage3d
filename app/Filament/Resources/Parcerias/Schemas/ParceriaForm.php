<?php

namespace App\Filament\Resources\Parcerias\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ParceriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados da Parceria')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nome')
                            ->label('Nome da Empresa')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('contato')
                            ->label('Contato')
                            ->maxLength(255)
                            ->helperText('Telefone, link, e-mail ou @ do Instagram'),

                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('parcerias')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->helperText('Logo da empresa parceira. Máx 5MB (JPG, PNG, WebP)'),

                        Textarea::make('descricao_curta')
                            ->label('Descrição Curta')
                            ->rows(2)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Aparece no card do parceiro na home'),

                        RichEditor::make('descricao_completa')
                            ->label('Descrição Completa')
                            ->columnSpanFull()
                            ->helperText('Aparece no modal ao clicar no card'),
                    ]),

                Section::make('Exibição')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ordem')
                            ->label('Ordem de exibição')
                            ->numeric()
                            ->integer()
                            ->default(0)
                            ->helperText('Menor número aparece primeiro'),

                        Toggle::make('ativo')
                            ->label('Ativa (visível no site)')
                            ->default(true),
                    ]),
            ]);
    }
}
