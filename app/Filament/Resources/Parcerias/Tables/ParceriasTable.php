<?php

namespace App\Filament\Resources\Parcerias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ParceriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square()
                    ->size(50),

                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('contato')
                    ->label('Contato')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('descricao_curta')
                    ->label('Descrição')
                    ->limit(50)
                    ->color('gray')
                    ->toggleable(),

                IconColumn::make('ativo')
                    ->label('Ativa')
                    ->boolean(),

                TextColumn::make('ordem')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('ordem')
            ->reorderable('ordem')
            ->filters([
                TernaryFilter::make('ativo')->label('Status'),
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
