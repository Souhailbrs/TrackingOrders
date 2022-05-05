<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_contact', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_channele_order_id');
            $table->foreign('sale_channele_order_id')->references('id')->on('sales_channele_orders');

            $table->string('userType');
            $table->string('user_id');


            $table->integer('times');
            $table->integer('status');

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
        Schema::dropIfExists('orders_contact');
    }
}
