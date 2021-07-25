<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Metodo_pago_orden
 *
 * @property int $id
 * @property string $id_orden
 * @property string $id_metodo_pago
 * @property string $monto_pago_orden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereIdMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereIdOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereMontoPagoOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metodo_pago_orden whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Metodo_pago_orden extends Model
{
    protected $fillable = [
        'id_orden','id_metodo_pago', 'monto_pago_orden', 'reference', 'created_at', 'updated_at',
    ];
}
