<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $fillable = [
        'cliente_id', 'tasa_cambio', 'monto_orden'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class,'cliente_id');
    }
    public function tasa()
    {
        return $this->belongsTo(Exchangerate::class,'tasa_cambio');
    }
    public function products()
    {
        return $this->belongsToMany('App\Product','product_orders', 'order_id', 'product_id')
        ->withPivot('precio','quantity');
    }
    public function paymentMethods()
    {
        return $this->belongsToMany('App\Metodo_de_pago','metodo_pago_ordens', 'id_orden', 'id_metodo_pago')
        ->withPivot('monto_pago_orden');
    }
}
