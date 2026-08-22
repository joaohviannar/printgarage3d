<?php

namespace App\Filament\Resources\LinkBios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class LinkBiosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icone')
                    ->label('Ícone')
                    ->badge()
                    ->color('danger'),

                TextColumn::make('label')
                    ->label('Botão')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->hint),

                TextColumn::make('url')
                    ->label('Destino')
                    ->limit(40)
                    ->color('gray')
                    ->url(fn ($record) => $record->isExterno() ? $record->url : null)
                    ->openUrlInNewTab()
                    ->toggleable(),

                TextColumn::make('cliques')
                    ->label('Cliques')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),

                // Liga/desliga direto na lista, sem abrir o formulário.
                ToggleColumn::make('ativo')
                    ->label('Visível'),

                TextColumn::make('ordem')
                    ->label('Ordem')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->emptyStateHeading('Nenhum link ainda')
            ->emptyStateDescription('Adicione o primeiro link que vai aparecer na sua bio do Instagram.');
    }
}
