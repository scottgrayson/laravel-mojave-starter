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
            'name' => 'full rate',
            'slug' => 'full',
            'price' => '40',
            'description' => '$1,200 for six weeks plus $100 registration fee. (Registration fee will be refunded if you attend a work party)',
        ]);

        \DB::table('products')->insert([
            'name' => 'week rate',
            'slug' => 'week',
            'price' => '45',
            'description' => '$225 per week plus $100 registration fee. (Registration fee will be refunded if you attend a work party)',
        ]);

        \DB::table('products')->insert([
            'name' => 'day',
            'slug' => 'day',
            'price' => '65',
            'description' => 'Daily rate for campers reserving less than 5 days.',
        ]);

        \DB::table('products')->insert([
            'name' => 'Registration Fee',
            'slug' => 'registration-fee',
            'price' => '100',
            'description' => 'If you attend the work party prior to the start of Camp, the registration fee will be refunded to you.',
        ]);
    }
}
