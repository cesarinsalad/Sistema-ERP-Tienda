<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturnItem extends Model
{
    protected $fillable = [
        'order_return_id', 'returned_product_id', 'quantity', 'returned_to_stock', 'exchanged_for_product_id'
    ];

    public function orderReturn()
    {
        return $this->belongsTo(OrderReturn::class);
    }

    public function returnedProduct()
    {
        return $this->belongsTo(Product::class, 'returned_product_id')->withTrashed();
    }

    public function exchangedProduct()
    {
        return $this->belongsTo(Product::class, 'exchanged_for_product_id')->withTrashed();
    }
}
