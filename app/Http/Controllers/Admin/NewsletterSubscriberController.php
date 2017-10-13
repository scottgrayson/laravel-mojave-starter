<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\NewsletterSubscriber;

class NewsletterSubscriberController extends CrudController
{
    use SendsPasswordResetEmails;

    protected $model = \App\NewsletterSubscriber::class;
    protected $slug = 'users';
    protected $singular = 'user';
    protected $plural = 'users';
    protected $formRequest = \App\Http\Requests\NewsletterSubscriberRequest::class;
}
