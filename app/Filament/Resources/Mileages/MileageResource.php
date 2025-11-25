<?php

namespace App\Filament\Resources\Mileages;

use App\Filament\Resources\Mileages\Pages\CreateMileage;
use App\Filament\Resources\Mileages\Pages\EditMileage;
use App\Filament\Resources\Mileages\Pages\ListMileages;
use App\Filament\Resources\Mileages\Schemas\MileageForm;
use App\Filament\Resources\Mileages\Tables\MileagesTable;
use App\Models\Mileage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MileageResource extends Resource
{
    protected static ?string $model = Mileage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string|null|\UnitEnum $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'start_location';

    public static function form(Schema $schema): Schema
    {
        return MileageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MileagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMileages::route('/'),
            'create' => CreateMileage::route('/create'),
            'edit' => EditMileage::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
