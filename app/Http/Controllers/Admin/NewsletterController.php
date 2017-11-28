<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Newsletter;
use App\Jobs\SendNewsletter;
use SEO;

class NewsletterController extends CrudController
{
    use SendsPasswordResetEmails;

    protected $model = \App\Newsletter::class;
    protected $slug = 'newsletters';
    protected $singular = 'newsletter';
    protected $plural = 'newsletters';
    protected $formRequest = \App\Http\Requests\NewsletterRequest::class;

    public function edit($id)
    {
        $item = $this->model::findOrFail($id);

        SEO::setTitle('Edit Newsletter: ' . $item->label);
        SEO::setDescription('Edit Newsletter: ' . $item->label);

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        return view(
            'admin.newsletter.edit', [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function send($id)
    {
        try {
            $newsletter = \App\Newsletter::find($id);
            dispatch(new SendNewsletter($newsletter))->onQueue('newsletter');
        } catch (\Exception $e) {
            \Log::error($e);
            flash('Failed to send newsletter.')->error();

            return redirect()->back();
        }

        flash('Newsletter sent')->success();

        return redirect()->back();
    }

    public function preview($id)
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            flash('Invalid email.')->error();

            return redirect()->back();
        }

        try {
            $newsletter = \App\Newsletter::find($id);
            dispatch(new SendNewsletter($newsletter, request('email')));
        } catch (\Exception $e) {
            \Log::error($e);
            flash('Failed to send newsletter preview.')->error();

            return redirect()->back();
        }

        flash('Newsletter preview sent')->success();

        return redirect()->back();
    }

    public function show($id)
    {
        $item = \App\Newsletter::with('links')->findOrFail($id);

        $openCount = $item->opens()->count();
        $openCountUnique = $item->opens()->distinct('ip_address')->count();
        $subscriberCount = \App\NewsletterSubscriber::count();

        return view('admin.newsletter.statistics', [
            'item' => $item,
            'opens' => $openCount,
            'uniqueOpens' => $openCountUnique,
            'subscriberCount' => $subscriberCount,
        ]);
    }
}
