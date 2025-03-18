<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    /** @use HasFactory<\Database\Factories\PackageFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'unit_id',
        'name',
        'description',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'is_active' => 'boolean'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customerTypes(): BelongsToMany
    {
        return $this->belongsToMany(CustomerType::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
