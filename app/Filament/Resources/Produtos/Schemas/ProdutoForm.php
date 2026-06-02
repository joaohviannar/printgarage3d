<?php

namespace App\Filament\Resources\Produtos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProdutoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Básicas')
                    ->description('Dados principais do produto')
                    ->columns(2)
                    ->schema([
                        Select::make('categoria_id')
                            ->label('Categoria')
                            ->relationship('categoria', 'nome')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('sku')
                            ->label('SKU (código interno)')
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        TextInput::make('nome')
                            ->label('Nome do Produto')
                            ->required()
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug (URL amigável)')
                            ->required()
                            ->maxLength(200)
                            ->unique(ignoreRecord: true)
                            ->helperText('Gerado automaticamente a partir do nome'),

                        Textarea::make('descricao_curta')
                            ->label('Descrição Curta')
                            ->maxLength(255)
                            ->rows(2)
                            ->columnSpanFull()
                            ->helperText('Aparece nos cards do catálogo'),

                        Textarea::make('descricao')
                            ->label('Descrição Completa')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Section::make('Mídia')
                    ->description('Imagem e vídeo exibidos na página do produto')
                    ->schema([
                        FileUpload::make('imagem_principal')
                            ->label('Imagem Principal')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('produtos')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->helperText('Tamanho máximo: 5MB. Formatos: JPG, PNG, WebP'),

                        FileUpload::make('video')
                            ->label('Vídeo do Produto')
                            ->disk('public')
                            ->directory('produtos/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(204800)
                            ->helperText('Opcional. Máx 200MB. Formatos: MP4, WebM, MOV. Dica: vídeos curtos e comprimidos carregam mais rápido para o cliente.'),

                        Repeater::make('imagens')
                            ->relationship()
                            ->label('Galeria de Fotos (máximo 5)')
                            ->maxItems(5)
                            ->reorderableWithButtons()
                            ->grid(2)
                            ->collapsible()
                            ->itemLabel(fn () => 'Foto')
                            ->addActionLabel('+ Adicionar foto')
                            ->schema([
                                FileUpload::make('caminho')
                                    ->label('Foto')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('produtos/galeria')
                                    ->visibility('public')
                                    ->maxSize(5120)
                                    ->required(),
                            ])
                            ->helperText('Fotos adicionais que aparecem como miniaturas na página do produto. Limite: 5.'),
                    ]),

                Section::make('Preços e Estoque')
                    ->columns(2)
                    ->schema([
                        TextInput::make('preco_venda')
                            ->label('Preço de Venda (R$)')
                            ->required()
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0),

                        TextInput::make('preco_custo')
                            ->label('Preço de Custo (R$)')
                            ->numeric()
                            ->prefix('R$')
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Para calcular margem de lucro'),

                        TextInput::make('estoque_atual')
                            ->label('Estoque Atual')
                            ->required()
                            ->numeric()
                            ->integer()
                            ->default(0)
                            ->minValue(0),

                        TextInput::make('estoque_minimo')
                            ->label('Estoque Mínimo (alerta)')
                            ->required()
                            ->numeric()
                            ->integer()
                            ->default(1)
                            ->minValue(0)
                            ->helperText('Avisa quando atingir esse valor'),
                    ]),

                Section::make('Visibilidade e Destaque')
                    ->columns(3)
                    ->schema([
                        Toggle::make('ativo')
                            ->label('Ativo')
                            ->default(true)
                            ->helperText('Produto operacional'),

                        Toggle::make('visivel_site')
                            ->label('Visível no site')
                            ->default(true)
                            ->helperText('Aparece no catálogo público'),

                        Toggle::make('destaque')
                            ->label('Em destaque')
                            ->helperText('Aparece na home'),
                    ]),
            ]);
    }
}
