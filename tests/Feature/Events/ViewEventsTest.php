<?php

namespace Tests\Feature\Events;

use Tests\TestCase;
use App\Event;
use App\EventType;

class ViewEvents extends TestCase
{
    public function testViewingEvents()
    {
        $eventType = factory(EventType::class)->create();
        $event = factory(Event::class)->create([
            'event_type_id' => $eventType->id,
        ]);

        $r = $this->get(route('api.events.index'));
        $r->assertStatus(200)
            ->assertJsonFragment([
                'name' => $eventType->name,
            ]);
    }
}
