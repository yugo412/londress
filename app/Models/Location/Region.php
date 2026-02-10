<?php

namespace App\Models\Location;

use App\Models\Traits\HasLocalTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\District> $districts
 * @property-read int|null $districts_count
 * @property-read \Carbon\Carbon $local_created_at
 * @property-read \Carbon\Carbon|null $local_deleted_at
 * @property-read \Carbon\Carbon $local_updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Region extends Model
{
    use HasFactory;
    use HasLocalTime;

    protected $fillable = [
        'country_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
