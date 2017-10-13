<?php

namespace App\Http\Controllers;

use App\NewsletterUrl;
use App\NewsletterClick;
use App\NewsletterOpen;
use App\Http\Requests\NewsletterRequest;

class NewsletterTrackingController extends Controller
{
    public function link($slug)
    {
        $trackable = NewsletterUrl::where('slug', $slug)->first();

        if (!$trackable) {
            return redirect('/');
        }

        $click = NewsletterClick::create([
            'newsletter_id' => $trackable->newsletter_id,
            'newsletter_url_id' => $trackable->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('user_agent')
        ]);

        return redirect()->away($trackable->target);
    }

    public function open($id)
    {
        \Log::error('open');
        try {
            NewsletterOpen::create([
                'newsletter_id' => $id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('user_agent')
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
        }

        if (config('app.env') === 'testing') {
            return response()
                ->file('public/img/tiny.png', ['cache-control' => 'no-cache']);
        }

        return response()
            ->file('img/tiny.png', ['cache-control' => 'no-cache']);
    }
}
