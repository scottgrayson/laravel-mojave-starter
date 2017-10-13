<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use SEO;

class UserController extends Controller
{
    protected $model = \App\User::class;
    protected $slug = 'users';

    public function settings(Request $request)
    {
        $id = request()->user()->id;
        $item = User::findOrFail($id);

        SEO::setTitle('Settings for ' . $item->label);
        SEO::setDescription('Settings for ' . $item->label);

        $fields = $this->getFieldsFromRules(new UserRequest);

        return view(
            'users.settings', [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function update(UserRequest $request, $id)
    {
        $item = User::findOrFail($id);

        if (request()->user()->id != $id) {
            abort(404);
        }

        $item->update($request->validated());

        flash('Settings updated.');

        return redirect(route("settings"));
    }
}
