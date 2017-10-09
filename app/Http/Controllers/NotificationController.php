<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index')
            ->with('notifications', auth()->user()->notifications()->paginate(config('settings.paginate')));
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications()
            ->where('id', $id)
            ->first();

        if (!$notification) {
            abort(404);
        }

        if (!$notification->read_at) {
            \DB::table('notifications')->where('id', $id)->update(['read_at' => Carbon::now()]);
        }

        return redirect($notification->data['url']);
    }

    // mark all read
    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => Carbon::now()]);

        flash('All notifications marked as read.')->success();

        return redirect(route('notifications.index'));
    }
}
