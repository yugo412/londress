<?php

namespace App\Drivers\Filament\Laundry\ServiceResource\Forms;

use App\Domains\Laundry\Services\Enums\ServiceUnit;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Utilities\Get;

class ServiceForm
{
    public static function schema(): array
    {
        return [
            Toggle::make('is_active')
                ->label(__('laundry.service.is_active'))
                ->default(true),

            TextInput::make('name')
                ->label(__('laundry.service.name'))
                ->required()
                ->maxLength(100),

            FusedGroup::make([
                Select::make('unit')
                    ->label(__('laundry.service.unit'))
                    ->options(ServiceUnit::class)
                    ->live()
                    ->required(),

                TextInput::make('price')
                    ->label(__('laundry.service.price'))
                    ->numeric()
                    ->minValue(0)
                    ->prefix(config('app.currency_symbol'))
                    ->disabled(fn (Get $get): bool => empty($get('unit')))
                    ->suffix(function (Get $get): ?string {
                        if (empty($get('unit'))) {
                            return null;
                        }

                        return sprintf('/%s', $get('unit')->getLabel());
                    })
                    ->required(),
            ])->label(__('laundry.service.price_unit')),

            TextInput::make('estimated_days')
                ->label(__('laundry.service.estimated_days'))
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(30)
                ->default(1),
        ];
    }
}
