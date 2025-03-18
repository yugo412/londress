<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerTypeFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getOptions(): array
    {
        return self::query()
            ->orderBy('name')
            ->whereIsActive(true)
            ->whereNull('branch_id')
            ->orWhereBelongsTo(Filament::getTenant())
            ->with('branch')
            ->orderBy('customer_type_id')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function (self $type): array {
                return [
                    $type->id => sprintf('%s (%s)', $type->name, $type->branch?->name ?? __('branch.available_all')),
                ];
            })
            ->toArray();
    }

    public static function getDescriptions(): array
    {
        return self::query()
            ->pluck('description', 'id')
            ->toArray();
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }
}
