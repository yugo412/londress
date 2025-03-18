<?php

namespace App\Filament\Resources\CustomerResource\Enums;

enum CustomerPermission: string
{
    case Browse = 'BrowseCustomer';

    case Read = 'ReadCustomer';

    case Edit = 'EditCustomer';

    case Add = 'AddCustomer';
    case Delete = 'DeleteCustomer';
}
