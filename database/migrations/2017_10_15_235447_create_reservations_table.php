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
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->index('user_id');

            $table->integer('camp_id')
                ->unsigned();
            $table->foreign('camp_id')
                ->references('id')
                ->on('camps')
                ->onDelete('restrict');
            $table->index('camp_id');

            $table->integer('camper_id')
                ->unsigned();
            $table->foreign('camper_id')
                ->references('id')
                ->on('campers')
                ->onDelete('restrict');
            $table->index('camper_id');

            $table->integer('tent_id')
                ->unsigned();
            $table->foreign('tent_id')
                ->references('id')
                ->on('tents')
                ->onDelete('restrict');
            $table->index('tent_id');

            $table->integer('payment_id')
            ->unsigned();
            $table->foreign('payment_id')
            ->references('id')
            ->on('payments')
            ->onDelete('restrict');
            $table->index('payment_id');

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
