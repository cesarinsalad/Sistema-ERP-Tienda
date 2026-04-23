<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('precio');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
