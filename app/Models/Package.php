<?php

namespace App\Models;

use App\Models\Traits\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string|null $description
 * @property float $price
 * @property BelongsTo $unit
 */
class Package extends Model
{
    use ActiveScope;

    /** @use HasFactory<\Database\Factories\PackageFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'unit_id',
        'slug',
        'name',
        'description',
        'price',
        'duration',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
