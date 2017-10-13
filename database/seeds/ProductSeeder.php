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
            'price' => '50',
            'desc' => 'day rate',
        ]);

        $full = \DB::table('products')->insert([
            'name' => 'full',
            'price' => '1200',
            'desc' => 'full rate',
        ]);
    }
}
