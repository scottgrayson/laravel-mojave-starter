<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTentLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tent_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tent_id')
                ->unsigned();
            $table->foreign('tent_id')
                ->references('id')->on('tents')
                ->onDelete('cascade');
            $table->integer('camper_limit');
            $table->date('date');
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
        Schema::dropIfExists('tent_limits');
    }
}
