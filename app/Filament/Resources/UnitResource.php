<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Enums\UnitPermission;
use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static bool $isScopedToTenant = false;

    /**
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.system');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.unit');
    }

    public static function canAccess(): bool
    {
        return user_can(UnitPermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function getLabel(): ?string
    {
        return __('unit.unit');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('unit.name'))
                    ->maxLength(100)
                    ->required(),

                TextInput::make('alias')
                    ->label(__('unit.alias'))
                    ->maxLength(50)
                    ->required(),

                TextInput::make('multiplier')
                    ->label(__('unit.multiplier'))
                    ->numeric()
                    ->columnSpanFull()
                    ->required()
                    ->helperText(__('unit.multiplier_helper')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('alias')
                    ->label(__('unit.alias'))
                    ->badge(),

                TextColumn::make('name')
                    ->label(__('unit.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('multiplier')
                    ->label(__('unit.multiplier'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->since(get_timezone())
                    ->dateTimeTooltip(get_datetime_format(), get_timezone())
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(UnitPermission::Edit)),

                ActionGroup::make([
                    DeleteAction::make()
                        ->visible(user_can(UnitPermission::Delete)),

                    ForceDeleteAction::make()
                        ->visible(user_can(UnitPermission::Delete)),

                    RestoreAction::make()
                        ->visible(user_can(UnitPermission::Restore)),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(UnitPermission::Delete)),

                    ForceDeleteBulkAction::make()
                        ->visible(user_can(UnitPermission::Delete)),

                    RestoreBulkAction::make()
                        ->visible(user_can(UnitPermission::Restore)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnits::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
