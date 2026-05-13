<?php

namespace App\Filament\Resources\Despesas;

use App\Filament\Resources\Despesas\Pages\CreateDespesa;
use App\Filament\Resources\Despesas\Pages\EditDespesa;
use App\Filament\Resources\Despesas\Pages\ListDespesas;
use App\Filament\Resources\Despesas\Schemas\DespesaForm;
use App\Filament\Resources\Despesas\Tables\DespesasTable;
use App\Models\Despesa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DespesaResource extends Resource
{
    protected static ?string $model = Despesa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Despesas';

    protected static ?string $modelLabel = 'Despesa';

    protected static ?string $pluralModelLabel = 'Despesas';

    protected static string|\UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'descricao';

    public static function form(Schema $schema): Schema
    {
        return DespesaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DespesasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDespesas::route('/'),
            'create' => CreateDespesa::route('/create'),
            'edit' => EditDespesa::route('/{record}/edit'),
        ];
    }
}
