<?php

namespace App\Drivers\Filament\Laundry\ServiceResource\Pages;

use App\Drivers\Filament\Laundry\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageServices extends ManageRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
