<?php

namespace App\Models;

use App\Models\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string|null $description
 * @property HasMany $packages
 */
class Unit extends Model
{
    use ActiveScope;

    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'abbr',
        'description',
        'is_active',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
