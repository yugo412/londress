<?php

namespace App\Models;

use App\Models\Traits\HasLocalTime;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\TranslationLoader\LanguageLine;

/**
 * @property int $id
 * @property string $group
 * @property string $key
 * @property array<array-key, mixed> $text
 * @property bool $is_system
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Carbon\Carbon $local_created_at
 * @property-read \Carbon\Carbon|null $local_deleted_at
 * @property-read \Carbon\Carbon $local_updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereIsSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Translation extends LanguageLine
{
    use HasLocalTime;

    public $table = 'language_lines';

    protected $casts = [
        'text' => 'array',
        'is_system' => 'boolean',
    ];

    public function group(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => strtolower($value),
        );
    }

    public function key(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => strtolower($value),
        );
    }

    public static function getFormattedTranslation(string $locale, ?array $groups = null, bool $isSystem = false): ?array
    {
        return Translation::orderBy('group')
            ->orderBy('key')
            ->when(! empty($groups), fn (Builder $builder): Builder => $builder->whereIn('group', $groups))
            ->when($isSystem, fn (Builder $builder): Builder => $builder->where('is_system', true))
            ->get()
            ->mapWithKeys(function ($line) use ($locale): array {
                $key = sprintf('%s.%s', $line->group, $line->key);
                $text = data_get($line->text, $locale);

                return [$key => [
                    'text' => $text,
                    'is_system' => $line->is_system,
                ]];
            })
            ->toArray();
    }
}
