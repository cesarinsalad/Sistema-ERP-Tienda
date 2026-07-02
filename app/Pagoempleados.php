<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagoempleados extends Model
{
    protected $table = 'pagoempleados';

    protected $fillable = [
        'empleado_id',
        'amount',
        'tasa_cambio',
        'reference',
        'payment_method',
        'payment_date'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'empleado_id');
    }
}