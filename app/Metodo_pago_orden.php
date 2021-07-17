<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metodo_pago_orden extends Model
{
    protected $fillable = [
        'id_orden','id_metodo_pago', 'monto_pago_orden', 'created_at', 'updated_at',
    ];
}
