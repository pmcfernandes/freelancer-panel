<?php

namespace App\Filament\Resources\Mileages\Pages;

use App\Filament\Resources\Mileages\MileageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMileage extends EditRecord
{
    protected static string $resource = MileageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
