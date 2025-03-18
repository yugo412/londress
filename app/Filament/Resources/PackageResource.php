<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Enums\PackagePermission;
use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms\Components\Select;
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
use Illuminate\Support\Number;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static bool $isScopedToTenant = false;

    public static function canAccess(): bool
    {
        return user_can(PackagePermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.package');
    }

    public static function getLabel(): ?string
    {
        return __('package.package');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('branch_id')
                    ->label(__('package.branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('branch.all')),

                TextInput::make('name')
                    ->label(__('package.name'))
                    ->required(),

                Select::make('unit_id')
                    ->label(__('package.unit'))
                    ->relationship('unit', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),

                TextInput::make('price')
                    ->label(__('package.price'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('package.name'))
                    ->searchable()
                    ->sortable()
                    ->default(__('branch.available_all')),

                TextColumn::make('name')
                    ->label(__('package.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('unit.name')
                    ->label(__('package.unit'))
                    ->searchable(),

                TextColumn::make('price')
                    ->label(__('package.price'))
                    ->searchable()
                    ->sortable()
                    ->numeric(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('package.is_active'))
                    ->disabled(user_cannot(PackagePermission::Edit)),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->sortable()
                    ->since(get_timezone())
                    ->dateTimeTooltip(get_datetime_format(), get_timezone()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label(__('package.branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),

                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(PackagePermission::Edit)),

                ActionGroup::make([
                    DeleteAction::make()
                        ->visible(user_can(PackagePermission::Delete)),

                    ForceDeleteAction::make()
                        ->visible(user_can(PackagePermission::Delete)),

                    RestoreAction::make()
                        ->visible(user_can(PackagePermission::Restore)),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(PackagePermission::Delete)),

                    ForceDeleteBulkAction::make()
                        ->visible(user_can(PackagePermission::Delete)),

                    RestoreBulkAction::make()
                        ->visible(user_can(PackagePermission::Restore)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePackages::route('/'),
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
