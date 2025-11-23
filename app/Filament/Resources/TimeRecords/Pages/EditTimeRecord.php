<?php

namespace App\Filament\Resources\TimeRecords\Pages;

use App\Filament\Resources\TimeRecords\TimeRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTimeRecord extends EditRecord
{
    protected static string $resource = TimeRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
