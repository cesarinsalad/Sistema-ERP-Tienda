<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('type'); // 'same_item', 'money_back', 'different_item'
            $table->decimal('amount_refunded', 15, 2)->default(0);
            $table->decimal('amount_charged', 15, 2)->default(0);
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('metodo_de_pagos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_returns');
    }
}
