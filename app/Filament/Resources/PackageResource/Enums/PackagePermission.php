<?php

namespace App\Filament\Resources\PackageResource\Enums;

enum PackagePermission: string
{
    case Browse = 'BrowsePackage';

    case Edit = 'EditPackage';

    case Create = 'CreatePackage';

    case Delete = 'DeletePackage';
}
