<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batteries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->integer('tab_id');
            $table->integer('neutral_id')->nullable();
            $table->string('din_marking')->nullable();
            $table->string('old_jis_marking')->nullable();
            $table->string('new_jis_marking')->nullable();
            $table->string('short_code')->nullable();
            $table->string('ah')->nullable();
            $table->string('rc')->nullable();
            $table->string('box')->nullable();
            $table->string('en')->nullable();
            $table->string('l_w_h')->nullable();
            $table->string('bhd')->nullable();
            $table->string('layout')->nullable();
            $table->float('weight_wt', 5, 1)->nullable();
            $table->string('pcs_pallet')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('batteries');
    }
}
