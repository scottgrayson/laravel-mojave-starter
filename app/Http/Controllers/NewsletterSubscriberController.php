<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NewsletterSubscriberRequest;
use App\NewsletterSubscriber;
use SEO;

class NewsletterSubscriberController extends Controller
{
    protected $model = \App\NewsletterSubscriber::class;
    protected $slug = 'newsletter';

    public function create(Request $request)
    {
        SEO::setTitle('Subscribe to ' . config('app.name') . ' newsletter');
        SEO::setDescription('Subscribe to ' . config('app.name') . ' newsletter');

        $fields = $this->getFieldsFromRules(new NewsletterSubscriberRequest);

        return view(
            'newsletter.create', [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function store(NewsletterSubscriberRequest $request)
    {
        $email = request('email');
        $sub = NewsletterSubscriber::where('email', $email)->count();

        if ($sub) {
            flash('You are already subscribed to ' . config('app.name') . ' newsletter.');

            return redirect()->back();
        }

        $sub = NewsletterSubscriber::create(['email' => $email]);

        flash('Subscribed to ' . config('app.name') . ' newsletter.')->success();

        return redirect()->back();
    }

    public function unsubscribe(Request $request)
    {
        SEO::setTitle('Unsubscribe from ' . config('app.name') . ' newsletter');
        SEO::setDescription('Unsubscribe from ' . config('app.name') . ' newsletter');

        $fields = $this->getFieldsFromRules(new NewsletterSubscriberRequest);

        return view(
            'newsletter.unsubscribe', [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function destroy(NewsletterSubscriberRequest $request)
    {
        $email = request('email');
        $sub = NewsletterSubscriber::where('email', $email);

        if (!$sub) {
            flash("Could not find newsletter subscription for $email")->error();
            return redirect()->back();
        }

        $sub->delete();

        flash('Unsubscribed from ' . config('app.name') . ' newsletter.')->success();

        return redirect()->back();
    }
}
