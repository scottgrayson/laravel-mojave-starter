<?php

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('truncate images cascade');

        $imageFiles = \App\File::where('mimetype', 'like', 'image%')->get();
        $userCount = \App\User::count();

        $imageFiles->each(function ($f) use ($userCount) {
            factory(\App\Image::class)->create([
                'user_id' => rand(1, $userCount),
                'file_id' => $f->id,
                'name' => $f->name,
            ]);
        });
    }
}
