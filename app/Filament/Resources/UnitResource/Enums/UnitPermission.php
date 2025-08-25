<?php

namespace App\Filament\Resources\UnitResource\Enums;

enum UnitPermission: string
{
    case Browse = 'BrowseUnit';

    case Edit = 'EditUnit';

    case Delete = 'DeleteUnit';

    case Create = 'CreateUnit';
}
