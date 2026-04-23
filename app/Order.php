<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property-read \App\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Metodo_de_pago[] $paymentMethods
 * @property-read int|null $payment_methods_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Exchangerate $tasa
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $cliente_id
 * @property string $tasa_cambio
 * @property string $monto_orden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMontoOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTasaCambio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
class Order extends Model
{
    protected $fillable = [
        'cliente_id', 'user_id', 'tasa_cambio', 'monto_orden'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'Desconocido']);
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'cliente_id')->withTrashed();
    }
    public function tasa()
    {
        return $this->belongsTo(Exchangerate::class,'tasa_cambio');
    }
    public function products()
    {
        return $this->belongsToMany('App\Product','product_orders', 'order_id', 'product_id')
        ->withPivot('precio','quantity')->withTrashed();
    }
    public function paymentMethods()
    {
        return $this->belongsToMany('App\Metodo_de_pago','metodo_pago_ordens', 'id_orden', 'id_metodo_pago')
        ->withPivot('monto_pago_orden', 'reference');
    }
}
