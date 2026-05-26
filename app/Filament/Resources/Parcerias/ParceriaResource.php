<?php

namespace App\Filament\Resources\Parcerias;

use App\Filament\Resources\Parcerias\Pages\CreateParceria;
use App\Filament\Resources\Parcerias\Pages\EditParceria;
use App\Filament\Resources\Parcerias\Pages\ListParcerias;
use App\Filament\Resources\Parcerias\Schemas\ParceriaForm;
use App\Filament\Resources\Parcerias\Tables\ParceriasTable;
use App\Models\Parceria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParceriaResource extends Resource
{
    protected static ?string $model = Parceria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static ?string $navigationLabel = 'Parcerias';

    protected static ?string $modelLabel = 'Parceria';

    protected static ?string $pluralModelLabel = 'Parcerias';

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return ParceriaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParceriasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParcerias::route('/'),
            'create' => CreateParceria::route('/create'),
            'edit' => EditParceria::route('/{record}/edit'),
        ];
    }
}
