<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrdersTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders_tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channele_order');
            $table->foreign('sales_channele_order')->references('id')->on('sales_channele_orders');

            $table->integer('old_status');
            $table->integer('last_status');
            $table->text('changes');

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
        Schema::dropIfExists('sales_orders_tracks');
    }
}
