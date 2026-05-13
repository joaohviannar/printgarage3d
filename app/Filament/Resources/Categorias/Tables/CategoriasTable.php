<?php

namespace App\Filament\Resources\Categorias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn($state) => $state === 'B2C' ? 'primary' : 'gray'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('produtos_count')
                    ->label('Produtos')
                    ->counts('produtos')
                    ->badge(),

                TextColumn::make('ordem')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('ativo')
                    ->label('Ativa')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('tipo')->options(['B2C' => 'B2C', 'B2B' => 'B2B']),
                TernaryFilter::make('ativo')->label('Status'),
            ])
            ->defaultSort('tipo')
            ->defaultSort('ordem')
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
