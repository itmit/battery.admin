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
            $table->string('SSCC')->nullable();
            $table->string('ARTICLE')->nullable();
            $table->string('SERIAL')->nullable();
            $table->string('SSCC_QUANTITY')->nullable();
            $table->string('BATCH')->nullable();
            $table->string('DESCRIPTION')->nullable();
            $table->date('PACKING_DATE')->nullable();
            $table->date('DISPATCH_DATE')->nullable();
            $table->string('Description_2')->nullable();
            $table->string('PAYER_CODE')->nullable();
            $table->string('PAYER_DESCRIPTION')->nullable();
            $table->string('RECEIVER_CODE')->nullable();
            $table->string('RECEIVER_DESCRIPTION')->nullable();
            $table->string('NETO_WEIGHT')->nullable();
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
