<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_seller', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('received');
            $table->integer('amount');
            $table->integer('sold');
            $table->integer('status');


            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('sales_channels');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers');
            //Order Id

            $table->text('image')->nullable();

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
        Schema::dropIfExists('products_seller');
    }
}
