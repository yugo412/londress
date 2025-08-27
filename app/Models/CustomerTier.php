<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerTier extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerTierFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    protected $attributes = [
        'metadata' => '[]',
    ];

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }
}
