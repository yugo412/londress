<?php

namespace App\Filament\Resources\CustomerTierResource\Pages;

use App\Filament\Resources\CustomerTierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerTier extends EditRecord
{
    protected static string $resource = CustomerTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
