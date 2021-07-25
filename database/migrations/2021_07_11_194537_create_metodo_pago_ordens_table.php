<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodoPagoOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodo_pago_ordens', function (Blueprint $table) {
            $table->id();
            $table->string('id_orden');
            $table->string('id_metodo_pago');
            $table->decimal('monto_pago_orden', 8, 2);
            $table->string('reference', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodo_pago_ordens');
    }
}
