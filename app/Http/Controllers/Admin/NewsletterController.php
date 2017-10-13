<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Newsletter;
use App\Jobs\SendNewsletter;

class NewsletterController extends CrudController
{
    use SendsPasswordResetEmails;

    protected $model = \App\Newsletter::class;
    protected $slug = 'users';
    protected $singular = 'user';
    protected $plural = 'users';
    protected $formRequest = \App\Http\Requests\NewsletterRequest::class;

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

        return redirect('/admin/newletter');
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

    public function statistics($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Statistics '.$this->crud->entity_name;

        return view('admin.newsletter.statistics', $this->data);
    }
}
