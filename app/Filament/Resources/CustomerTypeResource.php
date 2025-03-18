<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerTypeResource\Enums\CustomerTypePermission;
use App\Filament\Resources\CustomerTypeResource\Pages;
use App\Models\CustomerType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CustomerTypeResource extends Resource
{
    protected static ?string $model = CustomerType::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static bool $isScopedToTenant = false;

    public static function getNavigationLabel(): string
    {
        return __('navigation.customer_type');
    }

    public static function getLabel(): ?string
    {
        return __('customer.type');
    }

    public static function canAccess(): bool
    {
        return user_can(CustomerTypePermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->label(__('customer.type_name'))
                    ->required(),

                Select::make('branch_id')
                    ->relationship(
                        name: 'branch',
                        titleAttribute: 'name',
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder(__('branch.available_all'))
                    ->label(__('customer.type_branch'))
                    ->helperText(__('customer.type_branch_helper')),

                Textarea::make('description')
                    ->label(__('customer.type_description'))
                    ->columnSpanFull()
                    ->rows(5)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('customer.type_branch'))
                    ->searchable()
                    ->default(__('branch.available_all'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('customer.type_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('customer.type_description'))
                    ->default('-')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->since(get_timezone())
                    ->dateTimeTooltip(get_datetime_format(), get_timezone()),

                ToggleColumn::make('is_active')
                    ->label(__('customer.type_active'))
                    ->visible(user_can(CustomerTypePermission::Edit)),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->label(__('customer.type_branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(CustomerTypePermission::Edit)),

                DeleteAction::make()
                    ->visible(user_can(CustomerTypePermission::Delete)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(CustomerTypePermission::Delete)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomerTypes::route('/'),
        ];
    }
}
