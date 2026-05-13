<?php

namespace App\Filament\Resources\CategoriaDespesas;

use App\Filament\Resources\CategoriaDespesas\Pages\CreateCategoriaDespesa;
use App\Filament\Resources\CategoriaDespesas\Pages\EditCategoriaDespesa;
use App\Filament\Resources\CategoriaDespesas\Pages\ListCategoriaDespesas;
use App\Filament\Resources\CategoriaDespesas\Schemas\CategoriaDespesaForm;
use App\Filament\Resources\CategoriaDespesas\Tables\CategoriaDespesasTable;
use App\Models\CategoriaDespesa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoriaDespesaResource extends Resource
{
    protected static ?string $model = CategoriaDespesa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Categorias de Despesa';

    protected static ?string $modelLabel = 'Categoria de Despesa';

    protected static ?string $pluralModelLabel = 'Categorias de Despesa';

    protected static string|\UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return CategoriaDespesaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriaDespesasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategoriaDespesas::route('/'),
            'create' => CreateCategoriaDespesa::route('/create'),
            'edit' => EditCategoriaDespesa::route('/{record}/edit'),
        ];
    }
}
