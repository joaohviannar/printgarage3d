<?php

namespace App\Filament\Resources\Vendas\Schemas;

use App\Models\Produto;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados da Venda')
                    ->columns(2)
                    ->schema([
                        Select::make('cliente_id')
                            ->label('Cliente')
                            ->relationship('cliente', 'nome')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nome')->label('Nome')->required(),
                                Select::make('tipo')
                                    ->label('Tipo')
                                    ->options(['PF' => 'Pessoa Física', 'PJ' => 'Pessoa Jurídica'])
                                    ->default('PF')->required(),
                                TextInput::make('telefone')->label('Telefone'),
                                TextInput::make('email')->label('Email')->email(),
                            ])
                            ->helperText('Opcional - deixe em branco para venda avulsa'),

                        Select::make('user_id')
                            ->label('Vendedor')
                            ->relationship('user', 'name')
                            ->default(fn() => auth()->id())
                            ->required(),

                        DatePicker::make('data_venda')
                            ->label('Data da Venda')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        Select::make('canal')
                            ->label('Canal')
                            ->options([
                                'whatsapp' => 'WhatsApp',
                                'instagram' => 'Instagram',
                                'presencial' => 'Presencial',
                                'outro' => 'Outro',
                            ])
                            ->default('whatsapp')
                            ->required(),

                        Select::make('forma_pagamento')
                            ->label('Forma de Pagamento')
                            ->options([
                                'pix' => 'PIX',
                                'dinheiro' => 'Dinheiro',
                                'cartao_credito' => 'Cartão de Crédito',
                                'cartao_debito' => 'Cartão de Débito',
                                'transferencia' => 'Transferência',
                                'outro' => 'Outro',
                            ])
                            ->default('pix')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'pago' => 'Pago',
                                'cancelado' => 'Cancelado',
                            ])
                            ->default('pago')
                            ->required()
                            ->helperText('⚠️ Mudar para "Cancelado" devolve o estoque automaticamente'),
                    ]),

                Section::make('Itens da Venda')
                    ->description('Adicione os produtos vendidos. O estoque é atualizado automaticamente ao salvar.')
                    ->schema([
                        Repeater::make('itens')
                            ->relationship()
                            ->label('')
                            ->minItems(1)
                            ->reorderable(false)
                            ->columns(12)
                            ->live()
                            ->schema([
                                Select::make('produto_id')
                                    ->label('Produto')
                                    ->options(
                                        fn() => Produto::ativos()
                                            ->orderBy('nome')
                                            ->pluck('nome', 'id')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(6)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $produto = Produto::find($state);
                                            if ($produto) {
                                                $set('preco_unitario', (float) $produto->preco_venda);
                                            }
                                        }
                                    }),

                                TextInput::make('quantidade')
                                    ->label('Qtd')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(1)
                                    ->default(1)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->columnSpan(2),

                                TextInput::make('preco_unitario')
                                    ->label('Preço Unit. (R$)')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->minValue(0)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->columnSpan(2),

                                Placeholder::make('subtotal_display')
                                    ->label('Subtotal')
                                    ->columnSpan(2)
                                    ->content(function ($get) {
                                        $qtd = (float) ($get('quantidade') ?? 0);
                                        $preco = (float) ($get('preco_unitario') ?? 0);
                                        return 'R$ ' . number_format($qtd * $preco, 2, ',', '.');
                                    }),
                            ])
                            ->itemLabel(fn (array $state) => isset($state['produto_id']) ? (Produto::find($state['produto_id'])?->nome ?? 'Item') : 'Novo item')
                            ->addActionLabel('+ Adicionar Item')
                            ->deleteAction(fn ($action) => $action->requiresConfirmation()),
                    ]),

                Section::make('Totais e Observações')
                    ->columns(3)
                    ->schema([
                        Placeholder::make('subtotal_calculado')
                            ->label('Subtotal Calculado')
                            ->content(function ($get) {
                                return 'R$ ' . number_format(self::calcularSubtotal($get('itens') ?? []), 2, ',', '.');
                            }),

                        TextInput::make('desconto')
                            ->label('Desconto (R$)')
                            ->numeric()
                            ->prefix('R$')
                            ->minValue(0)
                            ->default(0)
                            ->live(onBlur: true),

                        Placeholder::make('total_calculado')
                            ->label('Total Final')
                            ->content(function ($get) {
                                $subtotal = self::calcularSubtotal($get('itens') ?? []);
                                $desconto = (float) ($get('desconto') ?? 0);
                                return 'R$ ' . number_format(max(0, $subtotal - $desconto), 2, ',', '.');
                            }),

                        Textarea::make('observacoes')
                            ->label('Observações')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /**
     * Soma os subtotais dos itens da venda (quantidade * preco_unitario).
     */
    private static function calcularSubtotal(array $itens): float
    {
        $total = 0;
        foreach ($itens as $item) {
            $qtd = (float) ($item['quantidade'] ?? 0);
            $preco = (float) ($item['preco_unitario'] ?? 0);
            $total += $qtd * $preco;
        }
        return $total;
    }
}
