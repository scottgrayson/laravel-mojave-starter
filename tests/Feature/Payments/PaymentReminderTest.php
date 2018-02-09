<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use App\Camper;
use App\User;
use App\Tent;

use App\Mail\PaymentReminderMail as Reminder;
use App\Jobs\PaymentReminder;
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

        PaymentReminder::dispatch();

        Mail::assertSent(Reminder::class, function($mail) use ($user) {
            return $mail->user->id === $user->id;
        });

        Mail::assertSent(Reminder::class, 1);
    }
}
