<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->index('user_id');
            $table->integer('tent_id')
                ->unsigned();
            $table->foreign('tent_id')
                ->references('id')
                ->on('tents')
                ->onDelete('restrict');
            $table->index('tent_id');
            $table->string('name');

            /*
             * Nullable so they can be entered in steps
             */
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('township')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('shirt_size')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->string('physician_name')->nullable();
            $table->string('physician_phone')->nullable();
            $table->string('insurance_carrier')->nullable();
            $table->string('insurance_policy_number')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('guardian_city')->nullable();
            $table->string('guardian_township')->nullable();
            $table->string('guardian_state')->nullable();
            $table->string('guardian_zip')->nullable();
            $table->string('guardian_daytime_phone')->nullable();
            $table->string('guardian_evening_phone')->nullable();
            $table->string('guardian_work_phone')->nullable();
            $table->string('guardian_cell_phone')->nullable();
            $table->string('guardian_employer_name')->nullable();
            $table->string('guardian_employer_title')->nullable();
            $table->string('alternate_contact_name')->nullable();
            $table->string('alternate_contact_daytime_phone')->nullable();
            $table->string('alternate_contact_evening_phone')->nullable();
            $table->boolean('photo_consent')->default(0);
            $table->boolean('henna_consent')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campers');
    }
}
