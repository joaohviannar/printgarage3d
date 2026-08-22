<?php

namespace App\Filament\Resources\LinkBios;

use App\Filament\Resources\LinkBios\Pages\CreateLinkBio;
use App\Filament\Resources\LinkBios\Pages\EditLinkBio;
use App\Filament\Resources\LinkBios\Pages\ListLinkBios;
use App\Filament\Resources\LinkBios\Schemas\LinkBioForm;
use App\Filament\Resources\LinkBios\Tables\LinkBiosTable;
use App\Models\LinkBio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LinkBioResource extends Resource
{
    protected static ?string $model = LinkBio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?string $navigationLabel = 'Links da Bio';

    protected static ?string $modelLabel = 'Link da Bio';

    protected static ?string $pluralModelLabel = 'Links da Bio';

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return LinkBioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LinkBiosTable::configure($table);
    }

    /** Quantos links estão ativos na página pública. */
    public static function getNavigationBadge(): ?string
    {
        return (string) LinkBio::ativos()->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Links ativos na página /links';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLinkBios::route('/'),
            'create' => CreateLinkBio::route('/create'),
            'edit' => EditLinkBio::route('/{record}/edit'),
        ];
    }
}
