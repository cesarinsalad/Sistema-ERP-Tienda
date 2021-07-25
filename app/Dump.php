<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dump
 *
 * @property int $id
 * @property string $file
 * @property string $file_name
 * @property string|null $prefix
 * @property int $encrypted
 * @property int $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Dump newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dump newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dump query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dump whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dump whereEncrypted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dump whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dump whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dump whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dump wherePrefix($value)
 * @mixin \Eloquent
 */
class Dump extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'dumps';
    /**
     * @var array
     */
    protected $fillable = [
        'file', 'file_name', 'created_at'
    ];

}
