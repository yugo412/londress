<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerTierResource\CustomerTierForm;
use App\Filament\Resources\CustomerTierResource\Enums\CustomerTierPermission;
use App\Filament\Resources\CustomerTierResource\Pages;
use App\Filament\Resources\CustomerTierResource\RelationManagers;
use App\Models\CustomerTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerTierResource extends Resource
{
    protected static ?string $model = CustomerTier::class;

    protected static ?string $tenantOwnershipRelationshipName = 'branches';

    public static function getLabel(): ?string
    {
        return __('customer.tier_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.transaction');
    }

    public static function canAccess(): bool
    {
        return user_can(CustomerTierPermission::Browse);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema(CustomerTierForm::schema()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('customer.tier_name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('branches.name')
                    ->label(__('branch.label'))
                    ->searchable(),

                TextColumn::makeDate('updated_at', __('ui.updated_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->visible(user_can(CustomerTierResource\Enums\CustomerTierPermission::Edit)),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerTiers::route('/'),
            'create' => Pages\CreateCustomerTier::route('/create'),
            'edit' => Pages\EditCustomerTier::route('/{record}/edit'),
        ];
    }
}
