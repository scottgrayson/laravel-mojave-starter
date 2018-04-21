<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Camp;
use App\Reservation;
use Carbon\Carbon;

class AddCampIdColumnToReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('camp_id')->unsigned()->after('camper_id')->nullable();
        });

        $thisYear = Carbon::now()->format('Y');
        $currentCamp = Camp::whereYear('camp_start', $thisYear)->first();
        if ($currentCamp) {
            Reservation::whereYear('date', $thisYear)
                ->update(['camp_id' => $currentCamp->id]);
        }

        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('camp_id')->unsigned()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('camp_id');
        });
    }
}
