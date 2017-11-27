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
        $camper->first_name = 'Updated';
        $camper->last_name = 'Name';
        $camper->address = 'Updated Address';
        $camper->city = 'city';
        $camper->state = 'state';
        $camper->zip = 'zip';
        $camper->school_name = 'school';
        $camper->township = 'township';
        $camper->phone = '18003334444';
        $camper->birthdate = '2017-10-10';
        $camper->shirt_size = 'M';
        $camper->save();

        $this->be($user);
        $r = $this->get(route('campers.edit', $camper->id));
        $r->assertStatus(302);

        $r = $this->put(route('campers.update', $camper->id), $camper->toArray());

        $this->assertEquals($user->campers()->first()->shirt_size, $camper->shirt_size);
        $this->assertEquals($user->campers()->first()->first_name, $camper->first_name);
        $this->assertEquals($user->campers()->first()->last_name, $camper->last_name);
        $this->assertEquals($user->campers()->first()->address, $camper->address);
    }

    public function testLastStepRedirect()
    {
        $user = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        $r = $this->put(route('campers.update', ['camper' => $camper->id, 'step' => 4]), $camper->toArray());

        $r->assertRedirect(route('campers.index'));
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
        $camper->first_name = 'Updated';
        $camper->last_name = 'Name';
        $camper->address = 'Updated Address';
        $camper->city = 'city';
        $camper->state = 'state';
        $camper->zip = 'zip';
        $camper->township = 'township';
        $camper->school_name = 'school';
        $camper->phone = '18003334444';
        $camper->birthdate = '2017-10-10';
        $camper->shirt_size = 'M';

        $this->be($user);
        $r = $this->get(route('campers.edit', $camper->id));
        $r->assertStatus(403);

        $r = $this->put(route('campers.update', $camper->id), $camper->toArray());
        $r->assertStatus(403);

        $this->assertNotEquals($otheruser->campers()->first()->first_name, $camper->first_name);
        $this->assertNotEquals($otheruser->campers()->first()->last_name, $camper->last_name);
        $this->assertNotEquals($otheruser->campers()->first()->shirt_size, $camper->shirt_size);
    }
}
