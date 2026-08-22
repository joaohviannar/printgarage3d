<?php

namespace App\Filament\Resources\LinkBios\Schemas;

use App\Models\LinkBio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LinkBioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Botão')
                    ->description('Como o link aparece na página /links (bio do Instagram).')
                    ->columns(2)
                    ->schema([
                        TextInput::make('label')
                            ->label('Texto do botão')
                            ->required()
                            ->maxLength(40)
                            ->helperText('Curto e direto. Ex.: "Falar no WhatsApp"'),

                        Select::make('icone')
                            ->label('Ícone')
                            ->options(LinkBio::ICONES)
                            ->required()
                            ->default('URL')
                            ->native(false),

                        TextInput::make('url')
                            ->label('Link de destino')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Endereço completo (https://, mailto:, tel:) ou caminho interno começando com "/". Ex.: /catalogo?tipo=B2C')
                            // Aceita links externos e rotas internas do próprio site.
                            ->rule('regex:#^(https?://|mailto:|tel:|/)#i')
                            ->validationMessages([
                                'regex' => 'Use um endereço completo (https://, mailto:, tel:) ou um caminho interno começando com "/".',
                            ]),

                        TextInput::make('hint')
                            ->label('Descrição abaixo do botão')
                            ->maxLength(80)
                            ->columnSpanFull()
                            ->helperText('Linha pequena de apoio. Opcional.'),
                    ]),

                Section::make('Exibição')
                    ->columns(3)
                    ->schema([
                        TextInput::make('ordem')
                            ->label('Ordem')
                            ->numeric()
                            ->integer()
                            ->default(0)
                            ->helperText('Menor aparece primeiro. Também dá para arrastar na lista.'),

                        Toggle::make('ativo')
                            ->label('Visível na página')
                            ->default(true)
                            ->helperText('Desative para esconder sem apagar.'),

                        TextInput::make('cliques')
                            ->label('Cliques')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Contador automático.'),
                    ]),
            ]);
    }
}
