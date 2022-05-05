<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrdersProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channele_order');
            $table->foreign('sales_channele_order')->references('id')->on('sales_channele_orders');

            $table->float('amount');
            $table->float('price');

            $table->unsignedBigInteger('products_seller_id');
            $table->foreign('products_seller_id')->references('id')->on('products_seller');


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
        Schema::dropIfExists('sales_orders_products');
    }
}
