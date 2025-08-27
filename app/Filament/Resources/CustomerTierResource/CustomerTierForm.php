<?php

namespace App\Filament\Resources\CustomerTierResource;

use App\Filament\Resources\BranchResource\Forms\BranchForm;
use Filament\Forms\Components\TextInput;

class CustomerTierForm
{
    public static function schema(): array
    {
        return [
            BranchForm::multiSelect(),

            TextInput::make('name')
                ->label(__('customer.tier_name'))
                ->required()
                ->maxLength(255),
        ];
    }
}