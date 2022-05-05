<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWorkDayOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_work_day_orders', function (Blueprint $table) {
            $table->id();
            //Work Day
            $table->unsignedBigInteger('user_user_work_day');
            $table->foreign('user_user_work_day')->references('id')->on('user_work_day');
            //Order Id
            $table->unsignedBigInteger('user_sales_channele_orders');
            $table->foreign('user_sales_channele_orders')->references('id')->on('sales_channele_orders');
            //User Type
            $table->string('userType');
            //USer ID
            $table->string('userID');
            $table->integer('status');
            $table->string('order_status_from');
            $table->string('order_status_to');
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
        Schema::dropIfExists('user_work_day_orders');
    }
}
