<?php

namespace Tests\Feature;

use App\MenuItem;
use Tests\TestCase;

class ReorderMenuTest extends TestCase
{
    public function testOrder()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\RoleMiddleware::class
        ]);

        $parent = factory(MenuItem::class)->create();

        $child1 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
        ]);

        $child2 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
        ]);

        $this->assertEquals(
            $parent->children->pluck('id')->toArray(),
            [ $child1->id, $child2->id ]
        );

        $res = $this->get(route('admin.menu-item-order.index'));
        $res->assertStatus(200);

        $res = $this->post(route('admin.menu-item-order.store'), [
            'order' => $parent->id . ',' . $child2->id . ',' . $child1->id
        ]);

        $res->assertRedirect(route('admin.menu-item-order.index'));

        $this->assertEquals(
            $parent->children()->pluck('id')->toArray(),
            [ $child2->id, $child1->id ]
        );
    }
}
