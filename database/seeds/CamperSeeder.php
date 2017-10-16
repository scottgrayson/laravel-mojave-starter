<?php

use Illuminate\Database\Seeder;

class CamperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = \App\User::count();
        $tentCount = \App\Tent::count();

        $campers = factory(\App\Camper::class, 70)->make()
            ->each(function ($i, $key) use ($userCount, $tentCount) {
                $i->user_id = rand(1, $userCount);
                $i->tent_id = rand(1, $tentCount);
            })
            ->toArray();

        DB::table('campers')->insert($campers);

        // Make sure dev accounts have campers
        \App\User::where('id', '<', 2)->get()
            ->each(function ($u) use ($tentCount) {
                factory(\App\Camper::class, 2)->create([
                    'user_id' => $u->id,
                    'tent_id' => rand(1, $tentCount),
                ]);
            });
    }
}
