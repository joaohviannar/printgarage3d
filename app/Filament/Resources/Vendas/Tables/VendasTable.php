<?php

namespace App\Filament\Resources\Vendas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VendasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->prefix('#'),

                TextColumn::make('data_venda')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('cliente.nome')
                    ->label('Cliente')
                    ->searchable()
                    ->placeholder('— avulsa —'),

                TextColumn::make('itens_count')
                    ->label('Itens')
                    ->counts('itens')
                    ->badge(),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('canal')
                    ->label('Canal')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'whatsapp' => 'success',
                        'instagram' => 'info',
                        'presencial' => 'gray',
                        default => 'warning',
                    }),

                TextColumn::make('forma_pagamento')
                    ->label('Pagamento')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn($state) => match($state) {
                        'pix' => 'PIX',
                        'dinheiro' => 'Dinheiro',
                        'cartao_credito' => 'Crédito',
                        'cartao_debito' => 'Débito',
                        'transferencia' => 'Transf.',
                        default => ucfirst($state),
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pago' => 'success',
                        'pendente' => 'warning',
                        'cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'pago' => 'Pago',
                        'cancelado' => 'Cancelado',
                    ]),

                SelectFilter::make('canal')
                    ->options([
                        'whatsapp' => 'WhatsApp',
                        'instagram' => 'Instagram',
                        'presencial' => 'Presencial',
                        'outro' => 'Outro',
                    ]),

                Filter::make('mes_atual')
                    ->label('📅 Mês atual')
                    ->query(fn(Builder $query) => $query
                        ->whereYear('data_venda', now()->year)
                        ->whereMonth('data_venda', now()->month))
                    ->toggle(),
            ])
            ->defaultSort('data_venda', 'desc')
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
