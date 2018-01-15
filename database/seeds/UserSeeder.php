<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dev testing accounts
        $exist = \App\User::where('email', 'admin@dev.com')->first();

        if (!$exist) {
            $admin = factory(\App\User::class)->create([
                'name' => 'admin',
                'email' => 'admin@dev.com',
                'password' => bcrypt('secret'),
            ]);

            $admin->assignRole('admin');

            $user = factory(\App\User::class)->create([
                'name' => 'user',
                'email' => 'user@dev.com',
                'password' => bcrypt('secret'),
            ]);
        }

        // Seed 50 more users
        factory(\App\User::class, 50)->create()
            ->each(function ($u) {
                $u->save();
            });
    }
}
