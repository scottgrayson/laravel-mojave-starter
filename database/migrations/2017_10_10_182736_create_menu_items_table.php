<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->string('link')->nullable();
            $table->integer('page_id')
                ->unsigned()
                ->nullable();
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('set null');
            $table->index('page_id');
            $table->integer('parent_id')
                ->unsigned()
                ->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('menu_items')
                ->onDelete('set null');
            $table->index('parent_id');
            $table->integer('order')->unsigned()->default(0);
            $table->boolean('target_blank')->default(0);
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
        Schema::dropIfExists('menu_items');
    }
}
