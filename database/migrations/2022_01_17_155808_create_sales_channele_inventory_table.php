<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesChanneleInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_channele_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channel_id');
            $table->foreign('sales_channel_id')->references('id')->on('sales_channels');
            //Product or service
            $table->string('shop_category');
            $table->string('product_name');
            $table->string('company_name');
            $table->string('company_number');
            $table->string('country_sent');
            $table->string('delivery_type');
            $table->string('boxes_number');
            $table->string('product_amount');
            $table->string('Expected_time');
            $table->string('Actual_time');
            $table->integer('sold');
            $table->smallInteger('status');
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
        Schema::dropIfExists('sales_channele_inventory');
    }
}
