<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

/**
 * Lista produtos com estoque atual <= estoque minimo, alertando o admin
 * para reposicao. Link direto para edicao do produto.
 */
class EstoqueBaixoWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 1;

    protected function getTableHeading(): string
    {
        return '⚠️ Alerta de Estoque Baixo';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produto::query()
                    ->ativos()
                    ->estoqueBaixo()
                    ->orderBy('estoque_atual')
            )
            ->columns([
                TextColumn::make('nome')
                    ->label('Produto')
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('estoque_atual')
                    ->label('Atual')
                    ->badge()
                    ->color(fn($state) => $state == 0 ? 'danger' : 'warning')
                    ->suffix(' un'),

                TextColumn::make('estoque_minimo')
                    ->label('Mínimo')
                    ->color('gray')
                    ->suffix(' un'),
            ])
            ->recordActions([
                Action::make('editar')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square')
                    ->size('xs')
                    ->url(fn (Produto $record) => "/admin/produtos/{$record->id}/edit"),
            ])
            ->paginated(false)
            ->emptyStateHeading('Estoque OK')
            ->emptyStateDescription('Todos os produtos estão acima do estoque mínimo.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
