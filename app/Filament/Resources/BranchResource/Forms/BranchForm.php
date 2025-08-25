<?php

namespace App\Filament\Resources\BranchResource\Forms;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Get;

class BranchForm
{
    public static function multiSelect(bool $required = true): Fieldset
    {
        return Fieldset::make(__('branch.name'))
            ->hiddenLabel()
            ->columns(1)
            ->schema([
                CheckboxList::make('branches')
                    ->label(__('branch.name'))
                    ->relationship('branches', 'name')
                    ->bulkToggleable()
                    ->required($required)
                    ->disabled(fn (Get $get) => $get('all_branch')),
            ]);
    }
}
