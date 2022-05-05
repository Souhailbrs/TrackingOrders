<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_channels', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->string('shop_url');
            $table->string('owner_email');
            $table->string('owner_password');
            $table->string('owner_phone');
            $table->string('country_id');
            $table->string('city_id');
            $table->smallInteger('status');
            $table->unsignedBigInteger('sales_channel_type_id');
            $table->foreign('sales_channel_type_id')->references('id')->on('sales_channels_types');

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
        Schema::dropIfExists('sales_channels');
    }
}
