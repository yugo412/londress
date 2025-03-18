<?php

namespace App\Filament\Resources\PackageResource\Enums;

enum PackagePermission: string
{

    case Browse = 'BrowsePackage';

    case Read = 'ReadPackage';

    case Edit = 'EditPackage';

    case Add = 'AddPackage';

    case Delete = 'DeletePackage';

    case Restore = 'RestorePackage';
}
