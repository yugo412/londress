<?php

namespace App\Filament\Resources\CustomerTierResource\Pages;

use App\Filament\Resources\CustomerTierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerTiers extends ListRecords
{
    protected static string $resource = CustomerTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(user_can(CustomerTierResource\Enums\CustomerTierPermission::Create)),
        ];
    }
}
