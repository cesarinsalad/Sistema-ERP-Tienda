<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $fillable = [
        'order_id', 'type', 'amount_refunded', 'amount_charged', 'payment_method_id', 'reason'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Metodo_de_pago::class, 'payment_method_id');
    }

    public function items()
    {
        return $this->hasMany(OrderReturnItem::class);
    }
}
