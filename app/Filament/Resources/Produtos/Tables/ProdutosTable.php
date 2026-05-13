<?php

namespace App\Filament\Resources\Produtos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProdutosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagem_principal')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(50),

                TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn($record) => $record->sku ? "SKU: {$record->sku}" : null),

                TextColumn::make('categoria.nome')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn($record) => $record->categoria?->tipo === 'B2C' ? 'primary' : 'gray')
                    ->sortable(),

                TextColumn::make('preco_venda')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('estoque_atual')
                    ->label('Estoque')
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => $record->estoque_atual <= $record->estoque_minimo ? 'danger' : 'success'),

                IconColumn::make('destaque')
                    ->label('⭐')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('visivel_site')
                    ->label('Site')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->label('Categoria')
                    ->relationship('categoria', 'nome')
                    ->preload(),

                TernaryFilter::make('ativo')
                    ->label('Status')
                    ->placeholder('Todos')
                    ->trueLabel('Apenas ativos')
                    ->falseLabel('Apenas inativos'),

                TernaryFilter::make('visivel_site')
                    ->label('Visível no site'),

                TernaryFilter::make('destaque')
                    ->label('Em destaque'),

                Filter::make('estoque_baixo')
                    ->label('⚠️ Estoque baixo')
                    ->query(fn($query) => $query->whereColumn('estoque_atual', '<=', 'estoque_minimo'))
                    ->toggle(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
