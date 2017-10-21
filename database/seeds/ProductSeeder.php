<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->truncate();

        \DB::table('products')->insert([
            'name' => 'day',
            'slug' => 'day',
            'price' => '50',
            'description' => 'Rate for campers reserving less than 5 days',
        ]);

        \DB::table('products')->insert([
            'name' => 'week rate',
            'slug' => 'week',
            'price' => '45',
            'description' => 'Rate for campers reserving 5 or more days',
        ]);

        \DB::table('products')->insert([
            'name' => 'full rate',
            'slug' => 'full',
            'price' => '40',
            'description' => 'Rate for campers reserving full camp',
        ]);

        \DB::table('products')->insert([
            'name' => 'Work Party Fee',
            'slug' => 'work-party-fee',
            'price' => '100',
            'description' => 'Waived if you agree to attend a work party during checkout',
        ]);
    }
}
