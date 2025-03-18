<?php

namespace App\Filament\Resources\CustomerTypeResource\Enums;

enum CustomerTypePermission: string
{
    case Browse = 'BrowseCustomerType';

    case Read = 'ReadCustomerType';

    case Edit = 'EditCustomerType';

    case Add = 'AddCustomerType';

    case Delete = 'DeleteCustomerType';
}
