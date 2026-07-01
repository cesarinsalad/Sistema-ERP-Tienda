<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteFacturaToStockPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_purchases', function (Blueprint $table) {
            $table->string('lote_factura', 100)->nullable()->after('fecha_compra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_purchases', function (Blueprint $table) {
            $table->dropColumn('lote_factura');
        });
    }
}
