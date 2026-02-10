<?php

namespace App\Domains\Laundry\Services\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ServiceUnit: string implements HasLabel
{
    case Kilogram = 'kg';

    case Piece = 'pcs';

    public function getLabel(): string|Htmlable|null
    {
        return __('laundry.service.unit_'.$this->value);
    }
}
