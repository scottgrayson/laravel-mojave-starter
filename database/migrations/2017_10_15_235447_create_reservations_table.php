<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->unsigned()
                ->references('id')
                ->on('users');
            $table->integer('camper_id')
                ->unsigned()
                ->references('id')
                ->on('campers');
            $table->integer('tent_id')
                ->unsigned()
                ->references('id')
                ->on('tents');
            //$table->integer('payment_id')
                //->unsigned()
                //->references('id')
                //->on('payments');
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
        Schema::dropIfExists('reservations');
    }
}
