<?php

use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('files')->truncate();

        // if developer doesnt have s3 setup,
        // use public driver so the files work on the site
        if (config('filesystems.default') === 'local') {
            config(['filesystems.default' => 'public']);
            \Artisan::call('storage:link');
        }

        function localToStorage()
        {
            return function ($filepath) {
                if (!Storage::exists('uploads/'.$filepath)) {
                    $r = Storage::put(
                        'uploads/'.$filepath,
                        Storage::disk('seeds')->get($filepath)
                    );
                }

                \App\File::createFromStoragePath('uploads/'.$filepath);
            };
        }

        collect(Storage::disk('seeds')->files())
            ->each(localToStorage());
    }
}
