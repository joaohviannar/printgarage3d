<?php

namespace App\Filament\Resources\Configuracaos\Tables;

use App\Models\Configuracao;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConfiguracaosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Configuração')
                    ->weight('bold')
                    ->getStateUsing(fn ($record) => Configuracao::LABELS[$record->chave] ?? $record->chave),

                TextColumn::make('chave')
                    ->label('Chave técnica')
                    ->color('gray')
                    ->size('xs')
                    ->copyable()
                    ->copyMessage('Chave copiada')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('valor')
                    ->label('Valor atual')
                    ->limit(60)
                    ->wrap()
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('chave')
            ->recordActions([
                EditAction::make()->label('Editar'),
            ])
            ->toolbarActions([]);
    }
}
