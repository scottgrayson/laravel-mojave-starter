<?php

namespace Tests\Feature\Reservations;

use Tests\TestCase;
use Carbon\Carbon;
use App\Camper;
use App\User;
use App\Tent;

use App\Mail\NewCamperReminderMail as Reminder;
use App\Jobs\NewCamperReminder;

use Illuminate\Support\Facades\Mail;

class NewCamperReminderTest extends TestCase
{
    public function testSendingReminder()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        NewCamperReminder::dispatch();

        Mail::assertSent(Reminder::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
        Mail::assertSent(Reminder::class, 1);
    }
}
