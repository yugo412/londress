<?php

namespace App\Filament\Resources\PackageResource;

use App\Filament\Resources\BranchResource\Forms\BranchForm;
use App\Filament\Resources\UnitResource\Enums\UnitPermission;
use App\Filament\Resources\UnitResource\UnitForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PackageForm
{
    public static function schema(): array
    {
        return [
            BranchForm::multiSelect(),

            TextInput::make('name')
                ->label(__('package.name'))
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, Set $set): void {
                    $set('slug', Str::slug($state));
                })
                ->required(),

            TextInput::make('slug')
                ->label(__('ui.slug'))
                ->unique(ignoreRecord: true)
                ->required(),

            Select::make('unit_id')
                ->label(__('unit.label'))
                ->relationship(
                    name: 'unit',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query): Builder => $query->active(),
                )
                ->createOptionForm(user_can(UnitPermission::Create) ? UnitForm::schema() : null)
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('price')
                ->label(__('package.price_per_unit'))
                ->prefix(fn (): ?string => ! config('app.number_symbol_suffix') ? config('app.currency_symbol') : null)
                ->suffix(fn (): ?string => config('app.number_symbol_suffix') ? config('app.currency_symbol') : null)
                ->numeric(),

            Textarea::make('description')
                ->columnSpanFull()
                ->label(__('package.description'))
                ->rows(5)
                ->nullable(),

            TextInput::make('duration')
                ->label(__('package.duration'))
                ->placeholder(__('package.duration_hours'))
                ->required()
                ->numeric(),
        ];
    }
}
