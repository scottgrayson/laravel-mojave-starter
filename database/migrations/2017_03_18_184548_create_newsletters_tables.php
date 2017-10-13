<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 124);
            $table->text('body');
            $table->datetime('sent_at')->nullable();
            $table->boolean('read_receipts')->default(1);
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newsletter_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('newsletter_id')
                ->unsigned()
                ->references('id')->on('newsletters')->index();
            $table->text('target');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newsletter_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newsletter_opens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newsletter_id')
                ->unsigned()
                ->references('id')->on('newsletters')->index();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });

        Schema::create('newsletter_clicks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newsletter_url_id')
                ->unsigned()
                ->references('id')->on('newsletter_urls')->index();
            $table->integer('newsletter_id')
                ->unsigned()
                ->references('id')->on('newsletters')->index();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('newsletter_urls');
        Schema::dropIfExists('newsletter_templates');
        Schema::dropIfExists('newsletter_opens');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('newsletter_clicks');

        Schema::enableForeignKeyConstraints();
    }
}
