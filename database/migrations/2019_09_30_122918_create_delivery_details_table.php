<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('delivery_id')->unsigned();
            $table->string('serial_number');
            $table->string('delivery_note')->nullable();
            $table->string('SSCC')->nullable();
            $table->bigInteger('TAB_ID')->nullable();
            $table->date('production_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('TAB_description')->nullable();
            $table->string('CustomerOrderNumber')->nullable();
            $table->string('Customer_Buyer')->nullable();
            $table->bigInteger('Customer_buyer_ID')->nullable();
            $table->string('Customer_Receiver')->nullable();
            $table->bigInteger('Customer_Receiver_ID')->nullable();
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_details');
    }
}
