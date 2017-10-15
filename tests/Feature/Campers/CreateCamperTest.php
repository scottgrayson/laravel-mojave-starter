<?php

namespace Tests\Feature\Campers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camper;
use App\User;
use App\Tent;

class CreateCamperTest extends TestCase
{
    public function testRegisteringCamper()
    {
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->make(['tent_id' => $tent->id]);
        $user = factory(User::class)->create();

        $r = $this->get(route('campers.create'));
        $r->assertStatus(200);

        $r = $this->get(route('campers.store'), $camper->toArray());

        $this->assertEquals($user->campers()->first()->id, $camper->id);
        $this->assertEquals($camper->tent()->count(), 1);
    }
}
