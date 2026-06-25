<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class IncreaseDecimalColumnsSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE metodo_pago_ordens MODIFY monto_pago_orden DECIMAL(15, 2)');
        DB::statement('ALTER TABLE orders MODIFY monto_orden DECIMAL(15, 2)');
        DB::statement('ALTER TABLE products MODIFY precio DECIMAL(15, 2)');
        DB::statement('ALTER TABLE product_orders MODIFY precio DECIMAL(15, 2)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE metodo_pago_ordens MODIFY monto_pago_orden DECIMAL(8, 2)');
        DB::statement('ALTER TABLE orders MODIFY monto_orden DECIMAL(8, 2)');
        DB::statement('ALTER TABLE products MODIFY precio DECIMAL(8, 2)');
        DB::statement('ALTER TABLE product_orders MODIFY precio DECIMAL(8, 2)');
    }
}
