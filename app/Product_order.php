<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_order extends Model
{
    protected $fillable = [
        'order_id','product_id', 'precio', 'quantity',
    ];
}
