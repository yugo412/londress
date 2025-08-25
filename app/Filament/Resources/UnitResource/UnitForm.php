<?php

namespace App\Filament\Resources\UnitResource;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class UnitForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('unit.name'))
                ->required(),

            TextInput::make('abbr')
                ->label(__('unit.abbr'))
                ->unique(ignoreRecord: true)
                ->required(),

            Textarea::make('description')
                ->columnSpanFull()
                ->label(__('unit.description'))
                ->nullable(),
        ];
    }
}
