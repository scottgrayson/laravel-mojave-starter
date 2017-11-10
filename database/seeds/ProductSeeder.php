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
        \DB::statement('truncate products cascade');

        \DB::table('products')->insert([
            'name' => 'day',
            'slug' => 'day',
            'price' => '65',
            'description' => 'Rate for campers reserving less than 5 days',
        ]);

        \DB::table('products')->insert([
            'name' => 'week rate',
            'slug' => 'week',
            'price' => '45',
            'description' => '$225 - per week',
        ]);

        \DB::table('products')->insert([
            'name' => 'full rate',
            'slug' => 'full',
            'price' => '40',
            'description' => '$1,200 - six weeks',
        ]);

        \DB::table('products')->insert([
            'name' => 'Work Party Fee',
            'slug' => 'work-party-fee',
            'price' => '100',
            'description' => 'If you attend the work party prior to the start of Camp, the registration fee will be refunded to you.',
        ]);
    }
}
