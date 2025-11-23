<?php

namespace App\Filament\Resources\Mileages\Pages;

use App\Filament\Resources\Mileages\MileageResource;
use App\Filament\Resources\Mileages\Widgets\MileageWidgets;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMileages extends ListRecords
{
    protected static string $resource = MileageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MileageWidgets::class
        ];
    }
}
