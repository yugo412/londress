<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Enums\PackagePermission;
use App\Filament\Resources\UnitResource\Enums\UnitPermission;
use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\UnitForm;
use App\Models\Unit;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-variable';

    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(UnitForm::schema());
    }

    public static function canAccess(): bool
    {
        return user_can(PackagePermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function getLabel(): ?string
    {
        return __('unit.label');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('unit.name'))
                    ->searchable()
                    ->sortable()
                    ->description(fn (Unit $record): ?string => $record->description),

                ToggleColumn::make('is_active')
                    ->label(__('unit.is_active')),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->since()
                    ->dateTimeTooltip(get_datetime_format(), get_timezone()),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(UnitPermission::Edit)),

                DeleteAction::make()
                    ->disabled(fn (Unit $record): bool => $record->packages->count() >= 1)
                    ->visible(user_can(UnitPermission::Delete)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(UnitPermission::Delete)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnits::route('/'),
        ];
    }
}
