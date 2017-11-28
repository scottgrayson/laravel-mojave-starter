<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use App\Payment;
use Cart;
use Carbon\Carbon;

class PayAndReserveTest extends TestCase
{
    public function testPayingAndReservingCamperDays()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class, 3)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        foreach ($camper as $c) {
            Cart::add($product, 1, [
                'camper_id' => $c->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $camp->camp_start->toDateString(),
            ]);
        }
        Cart::add($product, 1, [
            'camper_id' => $camper->first()->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'date' => $camp->camp_end->toDateString(),
        ]);

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $this->assertEquals($user->reservations->count(), 3);

        // Assert work party fee NOT paid
        $registrationPayment = Payment::where('user_id', $user->id)
            ->where('type', 'registration_fee')
            ->count();

        $this->assertEquals($registrationPayment, 0);
    }

    public function testRegistrationFee()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        foreach ($camp->openDays() as $key => $d) {
            if ($key > 5) {
                break;
            }

            Cart::add($product, 1, [
                'camper_id' => $camper->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $d->toDateString(),
            ]);
        }

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        // Assert work party fee paid
        $registrationPayment = Payment::where('user_id', $user->id)
            ->where('type', 'registration_fee')
            ->first();

        $this->assertEquals($registrationPayment->amount, $registrationFee->price);
    }

    public function testAlreadyPaidRegistrationFee()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        // Existing Payment
        $registrationPayment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'type' => 'work_party_fee',
            'amount' => $registrationFee->price,
        ]);

        $this->be($user);

        foreach ($camp->openDays() as $key => $d) {
            if ($key > 5) {
                break;
            }

            Cart::add($product, 1, [
                'camper_id' => $camper->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $d->toDateString(),
            ]);
        }

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        // Assert work party fee not paid twice
        $registrationPayments = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->count();

        $this->assertEquals($registrationPayments, 1);
    }

    public function testPaidRegistrationFeeForPreviousYear()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $lastJune = Carbon::parse('June')->subYears(2);
        $oldCamp = factory(Camp::class)->create([
            'camp_start' => $lastJune->toDateString(),
            'camp_end' => $lastJune->addDays(6 * 7)->toDateString(),
            'registration_end' => $lastJune->subMonths(1)->toDateString(),
        ]);
        // Last years payment
        $registrationPayment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $oldCamp->id,
            'type' => 'registration_fee',
            'amount' => $registrationFee->price,
            'created_at' => Carbon::now()->subYears(1),
        ]);

        // Assert work party fee paid for new year and old
        $registrationPayments = Payment::where('user_id', $user->id)
            ->where('type', 'registration_fee')
            ->count();

        $this->assertEquals($registrationPayments, 1);

        $this->be($user);

        foreach ($camp->openDays() as $key => $d) {
            if ($key > 5) {
                break;
            }

            Cart::add($product, 1, [
                'camper_id' => $camper->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $d->toDateString(),
            ]);
        }

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        // Assert work party fee paid for new year and old
        $registrationPayments = Payment::where('user_id', $user->id)
            ->where('type', 'registration_fee')
            ->count();

        $this->assertEquals($registrationPayments, 2);
    }
}
