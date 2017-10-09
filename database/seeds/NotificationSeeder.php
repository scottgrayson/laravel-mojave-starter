<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Notifications\TestNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('notifications')->truncate();

        $users = \App\User::where('id', 1)->orWhere('id', 2)->get();

        foreach ($users as $u) {
            for ($i = 0; $i < 100; $i++) {
               $u->notify(new TestNotification());
            }
        }

        $notifications = \DB::table('notifications')->select('id')->whereIn('notifiable_id', [1,2])->get();

        foreach ($notifications as $n) {
            \DB::table('notifications')->where('id', $n->id)->update([
                'read_at' => rand(0,1) ? Carbon::now()->toDateTimeString() : null,
                'created_at' => Carbon::now()->subHours(rand(0,100))->toDateTimeString(),
            ]);
        }
    }
}
