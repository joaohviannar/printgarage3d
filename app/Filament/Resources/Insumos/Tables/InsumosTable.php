<?php

namespace App\Filament\Resources\Insumos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InsumosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->badge(),
                TextColumn::make('cor')
                    ->searchable(),
                TextColumn::make('marca')
                    ->searchable(),
                TextColumn::make('unidade')
                    ->badge(),
                TextColumn::make('quantidade_atual')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantidade_minima')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('custo_unitario')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fornecedor')
                    ->searchable(),
                IconColumn::make('ativo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
