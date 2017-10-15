<?php

namespace Tests\Feature\Campers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camper;
use App\User;

class CreateCamperTest extends TestCase
{
    public function testRegisteringCamper()
    {
        $camper = factory(Camper::class)->make();
        $user = factory(User::class)->create();

        $r = $this->get(route('campers.create'));
        $r->assertStatus(200);

        $r = $this->get(route('campers.store'), $camper->toArray());

        $this->assertEquals($user->campers()->first()->id, $camper->id);
    }
}
