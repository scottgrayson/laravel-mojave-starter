<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FileSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(NewsletterSeeder::class);

        // Miss Betty's Day Camp
        $this->call(CampDatesSeeder::class);
        $this->call(TentSeeder::class);
        $this->call(CamperSeeder::class);
        $this->call(ReservationSeeder::class);
    }
}
