<?php

namespace App\Drivers\Filament\Laundry;

use App\Domains\Laundry\Services\Models\Service;
use App\Drivers\Filament\Laundry\ServiceResource\Forms\ServiceForm;
use App\Drivers\Filament\Laundry\ServiceResource\Pages;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getLabel(): string
    {
        return __('laundry.service.label');
    }

    public static function getNavigationLabel(): string
    {
        return __('laundry.service.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('laundry.parent');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(ServiceForm::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name')
            ->columns([
                ToggleColumn::make('is_active')
                    ->label(__('laundry.service.is_active')),

                TextColumn::make('name')
                    ->label(__('laundry.service.name'))
                    ->searchable(),

                TextColumn::make('price')
                    ->label(__('laundry.service.price'))
                    ->formatStateUsing(fn (Service $record): string => Number::money($record->price))
                    ->description(fn (Service $record): string => $record->unit->getLabel())
                    ->sortable(),

                TextColumn::make('estimated_days')
                    ->label(__('laundry.service.estimated_days'))
                    ->description(__('app.days'))
                    ->sortable(),

                TextColumn::makeSinceDate('updated_at', __('ui.updated_at'), true),

                TextColumn::makeSinceDate('created_at', __('ui.created_at'), true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('laundry.service.is_active')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];
    }
}
