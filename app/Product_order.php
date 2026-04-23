<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product_order
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $precio
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_order whereQuantity($value)
 * @mixin \Eloquent
 */
class Product_order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id','product_id', 'precio', 'quantity',
    ];
}
