<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ActiveScope
{
    public function scopeActive(Builder $builder, string $column = 'is_active'): Builder
    {
        return $builder->where($column, true);
    }
}
