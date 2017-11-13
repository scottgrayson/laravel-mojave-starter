<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
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

            $table->string('transaction');
            $table->string('type');
            $table->decimal('amount');
            $table->timestamp('refunded')
                ->nullable();

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
        Schema::dropIfExists('payments');
    }
}
