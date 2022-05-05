<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesChanneleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_channele_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channel');
            $table->foreign('sales_channel')->references('id')->on('sales_channels');
            //Customer Details
            $table->string('customer_name');
            $table->string('customer_phone1');
            $table->string('customer_phone2');
            $table->text('customer_notes')->nullable();
            $table->text('notes')->nullable();
            //Address Details
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->text('address')->nullable();
            //Status
            $table->smallInteger('status')->default(0);
            //Delivery Data
            $table->datetime('delivery_date');
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
        Schema::dropIfExists('sales_channele_orders');
    }
}
