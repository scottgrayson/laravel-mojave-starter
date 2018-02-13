<?php

namespace Tests\Feature\Reservations;

use Tests\TestCase;
use Carbon\Carbon;

use App\Camp;
use App\Camper;
use App\User;
use App\Tent;

use App\Mail\ReservationReminderMail as Reminder;
use App\Jobs\ReservationReminder;

use Illuminate\Support\Facades\Mail;

class ReservationReminderTest extends TestCase
{
    public function testSendingReservationReminder()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create([
            'camp_start' => Carbon::today()->addDays(60),
        ]);
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        ReservationReminder::dispatch();

        Mail::assertSent(Reminder::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
        Mail::assertSent(Reminder::class, 1);
    }
}