<?php

namespace App\Filament\Resources\CustomerTierResource\Pages;

use App\Filament\Resources\CustomerTierResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerTier extends CreateRecord
{
    protected static string $resource = CustomerTierResource::class;
}
