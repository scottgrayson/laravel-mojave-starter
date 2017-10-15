<?php

namespace Tests\Feature\Campers;

use Tests\TestCase;
use App\Camper;
use App\User;
use App\Tent;

class EditCamperTest extends TestCase
{
    public function testEditingCamper()
    {
        $user = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);
        $camper->name = 'Updated Name';

        $r = $this->get(route('campers.edit', $camper->id));
        $r->assertStatus(200);

        $r = $this->put(route('campers.update', $camper->id), $camper->toArray());

        $this->assertEquals($user->campers()->first()->name, $camper->name);
    }

    public function testCannotEditOtherParentsCampers()
    {
        $user = factory(User::class)->create();
        $otheruser = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $otheruser->id,
        ]);

        $r = $this->get(route('campers.edit', $camper->id));
        $r->assertStatus(403);
        $r = $this->put(route('campers.update', $camper->id), $camper->toArray());
        $r->assertStatus(403);
    }
}
