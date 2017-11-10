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
        $workPartyFee = factory(Product::class)->create(['slug' => 'work_party_fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        Cart::add($product, 1, [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'date' => $camp->camp_start->toDateString(),
        ]);

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $this->assertEquals($user->reservations->count(), 1);

        // Assert work party fee NOT paid
        $workPartyPayment = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->count();

        $this->assertEquals($workPartyPayment, 0);
    }

    public function testWorkPartyFee()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $workPartyFee = factory(Product::class)->create(['slug' => 'work_party_fee']);
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
        $workPartyPayment = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->first();

        $this->assertEquals($workPartyPayment->amount, $workPartyFee->price);
    }

    public function testAlreadyPaidWorkPartyFee()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $workPartyFee = factory(Product::class)->create(['slug' => 'work_party_fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        // Existing Payment
        $workPartyPayment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'type' => 'work_party_fee',
            'amount' => $workPartyFee->price,
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
        $workPartyPayments = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->count();

        $this->assertEquals($workPartyPayments, 1);
    }

    public function testPaidWorkPartyFeeForPreviousYear()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $workPartyFee = factory(Product::class)->create(['slug' => 'work_party_fee']);
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
        $workPartyPayment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $oldCamp->id,
            'type' => 'work_party_fee',
            'amount' => $workPartyFee->price,
            'created_at' => Carbon::now()->subYears(1),
        ]);

        // Assert work party fee paid for new year and old
        $workPartyPayments = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->count();

        $this->assertEquals($workPartyPayments, 1);

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
        $workPartyPayments = Payment::where('user_id', $user->id)
            ->where('type', 'work_party_fee')
            ->count();

        $this->assertEquals($workPartyPayments, 2);
    }
}
