<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\CustomerResource\Enums\CustomerPermission;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageCustomers extends ManageRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(user_can(CustomerPermission::Add))
                ->mutateFormDataUsing(function (array $data): array {
                    $data['code'] = Str::uuid7()->toString();

                    return $data;
                }),
        ];
    }
}
