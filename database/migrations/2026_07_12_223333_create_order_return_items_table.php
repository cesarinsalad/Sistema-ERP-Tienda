<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_return_id');
            $table->unsignedBigInteger('returned_product_id');
            $table->integer('quantity');
            $table->boolean('returned_to_stock')->default(false);
            $table->unsignedBigInteger('exchanged_for_product_id')->nullable();
            $table->timestamps();

            $table->foreign('order_return_id')->references('id')->on('order_returns')->onDelete('cascade');
            $table->foreign('returned_product_id')->references('id')->on('products');
            $table->foreign('exchanged_for_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_return_items');
    }
}
