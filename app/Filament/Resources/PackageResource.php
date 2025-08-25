<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Enums\PackagePermission;
use App\Filament\Resources\PackageResource\PackageForm;
use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $tenantOwnershipRelationshipName = 'branches';

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
        return __('package.label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PackageForm::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branches.name')
                    ->bulleted()
                    ->label(__('branch.name')),

                TextColumn::make('slug')
                    ->label(__('ui.slug')),

                TextColumn::make('name')
                    ->label(__('package.name'))
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Package $record): ?string => $record->description),

                TextColumn::make('price')
                    ->label(__('package.price_unit'))
                    ->formatStateUsing(fn (Package $record): string => Number::money($record->price))
                    ->sortable()
                    ->alignEnd()
                    ->description(fn (Package $record): string => '/'.$record->unit->abbr),

                TextColumn::make('duration')
                    ->label(__('package.duration'))
                    ->description(__('package.duration_hours')),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->sortable()
                    ->since()
                    ->dateTimeTooltip(get_datetime_format(), get_timezone()),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(PackagePermission::Edit)),

                DeleteAction::make()
                    ->visible(user_can(PackagePermission::Delete)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(PackagePermission::Delete)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePackages::route('/'),
        ];
    }
}
