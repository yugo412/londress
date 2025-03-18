<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Enums\CustomerPermission;
use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\CustomerType;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static bool $isScopedToTenant = false;

    public static function getLabel(): ?string
    {
        return __('customer.customer');
    }

    public static function canAccess(): bool
    {
        return user_can(CustomerPermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.customer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Radio::make('customer_type_id')
                    ->label(__('customer.type'))
                    ->columnSpanFull()
                    ->required()
                    ->options(CustomerType::getOptions())
                    ->descriptions(CustomerType::getDescriptions()),

                TextInput::make('name')
                    ->label(__('customer.name'))
                    ->maxLength(100)
                    ->required(),

                TextInput::make('email')
                    ->label(__('customer.email'))
                    ->nullable()
                    ->maxLength(100)
                    ->email(),

                TextInput::make('phone')
                    ->label(__('customer.phone'))
                    ->nullable()
                    ->maxLength(20),

                Textarea::make('address')
                    ->label(__('customer.address'))
                    ->rows(5)
                    ->nullable()
                    ->maxLength(150)
                    ->columnSpanFull(),

                Select::make('district_id')
                    ->label(__('customer.district'))
                    ->relationship('district', 'name')
                    ->searchable()
                    ->columnSpanFull()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type.branch.name')
                    ->label(__('customer.branch'))
                    ->searchable()
                    ->sortable()
                    ->default(__('branch.available_all')),

                TextColumn::make('name')
                    ->label(__('customer.name'))
                    ->weight(FontWeight::Bold)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type.name')
                    ->label(__('customer.type'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label(__('customer.phone'))
                    ->default('-')
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('customer.email'))
                    ->default('-')
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->label(__('ui.updated_at'))
                    ->sortable()
                    ->since(get_timezone())
                    ->dateTimeTooltip(get_datetime_format(), get_timezone()),
            ])
            ->filters([
                SelectFilter::make('customer_type_id')
                    ->label(__('customer.type'))
                    ->relationship('type', 'name')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(function (CustomerType $record) {
                        return sprintf('%s (%s)', $record->name, $record->branch->name ?? __('branch.available_all'));
                    })
                    ->multiple(),
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(CustomerPermission::Edit)),

                DeleteAction::make()
                    ->visible(user_can(CustomerPermission::Delete)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(user_can(CustomerPermission::Delete)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
