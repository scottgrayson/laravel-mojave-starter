<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;;
use App\Reservation;
use App\Camper;
use App\User;
use App\Tent;

use App\Mail\PaymentReminderMail as Reminder;
use App\Jobs\ReservationReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Carbon\Carbon;

class PaymentReminderTest extends TestCase
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

        $this->be($user);

        ReservationReminder::dispatch();

        Mail::assertSent(Reminder::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });

        Mail::assertSent(Reminder::class, 1);
    }
}
