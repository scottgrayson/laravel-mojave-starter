<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')
                ->unsigned()
                ->nullable();
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('set null');
            $table->integer('reservation_id')
                ->unsigned()
                ->nullable();
            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('set null');
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
        Schema::dropIfExists('invoice_reservations');
    }
}
