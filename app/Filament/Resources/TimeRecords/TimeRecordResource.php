<?php

namespace App\Filament\Resources\TimeRecords;

use App\Filament\Resources\TimeRecords\Pages\CreateTimeRecord;
use App\Filament\Resources\TimeRecords\Pages\EditTimeRecord;
use App\Filament\Resources\TimeRecords\Pages\ListTimeRecords;
use App\Filament\Resources\TimeRecords\Schemas\TimeRecordForm;
use App\Filament\Resources\TimeRecords\Tables\TimeRecordsTable;
use App\Models\TimeRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TimeRecordResource extends Resource
{
    protected static ?string $model = TimeRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|null|\UnitEnum $navigationGroup = 'Projects';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return TimeRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TimeRecordsTable::configure($table);
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
            'index' => ListTimeRecords::route('/'),
            'create' => CreateTimeRecord::route('/create'),
            'edit' => EditTimeRecord::route('/{record}/edit'),
        ];
    }


}
