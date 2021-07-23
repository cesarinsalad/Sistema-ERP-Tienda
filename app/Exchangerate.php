<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exchangerate
 *
 * @property int $id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereValue($value)
 * @mixin \Eloquent
 */
class Exchangerate extends Model
{
    protected $fillable = [
        'value'
    ];
}
