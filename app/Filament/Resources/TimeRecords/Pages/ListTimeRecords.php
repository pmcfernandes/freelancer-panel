<?php

namespace App\Filament\Resources\TimeRecords\Pages;

use App\Filament\Resources\TimeRecords\TimeRecordResource;
use App\Filament\Resources\TimeRecords\Widgets\TimeRecordWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTimeRecords extends ListRecords
{
    protected static string $resource = TimeRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TimeRecordWidget::class,
        ];
    }
}
