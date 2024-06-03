<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $extension
 * @property Carbon $created_at
 *
 * @method static count()
 */
class Database extends Model
{
    use HasFactory;
    use Sushi;

    protected array $schema = [
        'id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected function sushiShouldCache(): bool
    {
        return false;
    }

    public function getRows(): array
    {
        return collect(Storage::disk('local')->allFiles('database'))
            ->map(function ($file): array {
                [$name, $ext] = explode('.', basename($file), 2);

                $createdAt = Carbon::createFromTimestamp(intval($name));

                return [
                    'id' => $name,
                    'path' => $file,
                    'name' => sprintf('%s.%s', $createdAt->toDateTimeString(), $ext),
                    'extension' => $ext,
                    'created_at' => $createdAt,
                ];
            })
            ->toArray();
    }
}
