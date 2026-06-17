<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'user_id', 'document', 'phone', 'position', 'salary', 'is_active', 'commission_percent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pagoempleados::class, 'empleado_id');
    }

    public function sales()
    {
        return $this->hasMany(Order::class, 'vendedor_id');
    }

    public function getUnpaidCommissionAttribute()
    {
        $unpaidSales = $this->sales()->where('commission_paid', false)->get();
        $totalCommission = 0;
        foreach ($unpaidSales as $sale) {
            $totalCommission += $sale->monto_orden * ($this->commission_percent / 100);
        }
        return round($totalCommission, 2);
    }
}
