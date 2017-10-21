<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->nullable()
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->integer('file_id')
                ->unsigned();
            $table->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');
            $table->index('file_id');
            $table->string('name');
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
        Schema::dropIfExists('images');
    }
}
