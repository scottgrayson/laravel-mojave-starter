<?php

use Illuminate\Database\Seeder;

class CounselorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('truncate counselors cascade');

        $userCount = \App\User::count();
        $tentCount = \App\Tent::count();

        $counselors = factory(\App\Counselor::class, 15)->make()
            ->each(function ($i, $key) use ($userCount, $tentCount) {
                $i->user_id = rand(1, $userCount);
                $i->tent_id = rand(1, $tentCount);
                $i->year = \Carbon\Carbon::now()->year;
            })->toArray();

        \DB::table('counselors')->insert($counselors);
    }
}
