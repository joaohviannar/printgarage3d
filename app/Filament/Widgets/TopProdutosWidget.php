<?php

namespace App\Filament\Widgets;

use App\Models\ItemVenda;
use App\Models\Produto;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

/**
 * Top 5 produtos mais vendidos (por quantidade), considerando apenas vendas pagas.
 */
class TopProdutosWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getTableHeading(): string
    {
        return '🏆 Top 5 Produtos Mais Vendidos';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produto::query()
                    ->select([
                        'produtos.id',
                        'produtos.nome',
                        'produtos.imagem_principal',
                        'produtos.preco_venda',
                    ])
                    ->selectRaw('SUM(itens_venda.quantidade) as total_vendido')
                    ->selectRaw('SUM(itens_venda.subtotal) as receita_total')
                    ->join('itens_venda', 'itens_venda.produto_id', '=', 'produtos.id')
                    ->join('vendas', 'vendas.id', '=', 'itens_venda.venda_id')
                    ->where('vendas.status', 'pago')
                    ->groupBy('produtos.id', 'produtos.nome', 'produtos.imagem_principal', 'produtos.preco_venda')
                    ->orderByDesc('total_vendido')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('total_vendido')
                    ->label('Vendidos')
                    ->badge()
                    ->color('primary')
                    ->suffix(' un'),

                TextColumn::make('receita_total')
                    ->label('Receita')
                    ->money('BRL')
                    ->color('success'),
            ])
            ->paginated(false)
            ->emptyStateHeading('Sem vendas ainda')
            ->emptyStateDescription('Cadastre vendas para ver o ranking aqui.');
    }
}
