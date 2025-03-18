<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'alias',
        'name',
        'multiplier',
    ];

    public function branch(): ?BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
