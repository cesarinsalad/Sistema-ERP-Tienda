<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoempleadosTable extends Migration
{
    public function up()
    {
        Schema::create('pagoempleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->decimal('amount', 10, 2);
            $table->string('reference')->nullable();
            $table->date('payment_date');
            $table->timestamps();
            
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagoempleados');
    }
}
