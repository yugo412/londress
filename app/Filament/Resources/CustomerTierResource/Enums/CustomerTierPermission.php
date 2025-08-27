<?php

namespace App\Filament\Resources\CustomerTierResource\Enums;

enum CustomerTierPermission: string
{
    case Browse = 'BrowseCustomerTier';

    case Edit = 'EditCustomerTier';

    case Delete = 'DeleteCustomerTier';

    case Create = 'CreateCustomerTier';
}