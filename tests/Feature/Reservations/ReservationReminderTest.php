<?php

namespace Tests\Feature\Reservations;

use Tests\TestCase;
use Carbon\Carbon;
use App\Camper;
use App\User;
use App\Tent;

use App\Mail\ReservationReminderMail as Reminder;
use App\Jobs\ReservationReminder;

use Illuminate\Support\Facades\Mail;

class ReservationReminderTest extends TestCase
{
    public function testSendingReminder()
    {

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        ReservationReminder::dispatch();

    }
}
