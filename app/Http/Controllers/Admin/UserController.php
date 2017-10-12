<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;

class UserController extends CrudController
{
    use SendsPasswordResetEmails;

    protected $model = \App\User::class;
    protected $slug = 'users';
    protected $singular = 'user';
    protected $plural = 'users';
    protected $formRequest = \App\Http\Requests\UserRequest::class;

    public function store(Request $request)
    {
        // manually invoke form request
        if ($this->formRequest) {
            app($this->formRequest);
        }

        $data = $this->handleFileUploads();

        $user = User::make(
            request()->only(
                [
                'name',
                'email',
                ]
            )
        );

        // random password
        $user->password = bcrypt(str_random(10));
        $user->invite_pending = true;
        $user->save();

        // send reset link
        $this->sendResetLinkEmail($request);

        return redirect(route("admin.$this->slug.edit", $user->id))
            ->with(
                [
                'success' => "$this->singular created"
                ]
            );
    }
}
