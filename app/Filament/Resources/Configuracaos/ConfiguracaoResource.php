<?php

namespace App\Filament\Resources\Configuracaos;

use App\Filament\Resources\Configuracaos\Pages\EditConfiguracao;
use App\Filament\Resources\Configuracaos\Pages\ListConfiguracaos;
use App\Filament\Resources\Configuracaos\Schemas\ConfiguracaoForm;
use App\Filament\Resources\Configuracaos\Tables\ConfiguracaosTable;
use App\Models\Configuracao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConfiguracaoResource extends Resource
{
    protected static ?string $model = Configuracao::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Configurações';

    protected static ?string $modelLabel = 'Configuração';

    protected static ?string $pluralModelLabel = 'Configurações';

    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 99;

    public static function form(Schema $schema): Schema
    {
        return ConfiguracaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfiguracaosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConfiguracaos::route('/'),
            'edit' => EditConfiguracao::route('/{record}/edit'),
        ];
    }

    /**
     * Bloqueia criacao - chaves de configuracao sao predefinidas no seeder.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * Bloqueia exclusao - todas as chaves sao necessarias pelo sistema.
     */
    public static function canDelete($record): bool
    {
        return false;
    }
}
