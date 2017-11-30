<?php

namespace Tests\Feature\Events;

use Tests\TestCase;
use App\Event;

class ViewEvents extends TestCase
{
    public function testViewingEvents()
    {
        $event = factory(Event::class)->create();

        $r = $this->get(route('api.events.index'));
        $r->assertStatus(200)
            ->assertJsonFragment([
                'name' => $event->name,
            ]);
    }
}
