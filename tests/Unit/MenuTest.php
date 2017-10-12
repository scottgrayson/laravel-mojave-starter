<?php

namespace Tests\Unit;

use App\MenuItem;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function testRelations()
    {
        $parent = factory(MenuItem::class)->create();

        $child1 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
        ]);

        $child2 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
        ]);

        $this->assertEquals(
            $parent->children->pluck('id')->toArray(),
            [$child1->id, $child2->id]
        );
    }

    public function testOrdering()
    {
        $parent = factory(MenuItem::class)->create();

        $child1 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
            'order' => 4,
        ]);

        $child2 = factory(MenuItem::class)->create([
            'parent_id' => $parent->id,
            'order' => 1,
        ]);

        $this->assertEquals(
            $parent->children->pluck('id')->toArray(),
            [$child2->id, $child1->id]
        );
    }
}
