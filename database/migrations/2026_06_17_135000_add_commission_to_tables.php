<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->decimal('commission_percent', 5, 2)->default(5.00)->after('salary');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('vendedor_id')->nullable()->after('user_id');
            $table->boolean('commission_paid')->default(false)->after('vendedor_id');

            $table->foreign('vendedor_id')->references('id')->on('empleados')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['vendedor_id']);
            $table->dropColumn(['vendedor_id', 'commission_paid']);
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->dropColumn('commission_percent');
        });
    }
}
