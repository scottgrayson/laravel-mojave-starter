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
        $day = \DB::table('products')->insert([
            'name' => 'day',
            'slug' => 'day',
            'price' => '50',
            'description' => 'day rate',
        ]);

        $full = \DB::table('products')->insert([
            'name' => 'full',
            'slug' => 'full',
            'price' => '1200',
            'description' => 'full rate',
        ]);
    }
}
