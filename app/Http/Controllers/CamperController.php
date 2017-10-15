<?php

namespace App\Http\Controllers;

use App\Camper;
use Illuminate\Http\Request;
use App\Http\Requests\CamperRequest;
use SEO;

class CamperController extends Controller
{
    protected $model = \App\Camper::class;
    protected $slug = 'campers';

    public function create()
    {
        SEO::setTitle('Create Camper');
        SEO::setDescription('Create Camper');

        $fields = $this->getFieldsFromRules(new CamperRequest);

        return view(
            'campers.create', [
                'slug' => $this->slug,
                'model' => $this->model,
                'fields' => $fields,
            ]
        );
    }

    public function store(CamperRequest $request)
    {
        $data = $request->validated();

        $data = array_merge($data, ['user_id' => request()->user()->id]);

        $item = $this->model::create($data);

        flash('Camper created.');

        return redirect(route("campers.edit", $item->id));
    }

    public function edit(Camper $item, Request $request)
    {
        if (request()->user()->id != $item->user_id) {
            abort(403);
        }

        SEO::setTitle('Camper Registration for ' . $item->label);
        SEO::setDescription('Camper Registration for ' . $item->label);

        $fields = $this->getFieldsFromRules(new CamperRequest);

        return view(
            'campers.edit', [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function update(Camper $item, CamperRequest $request)
    {
        if (request()->user()->id != $item->user_id) {
            abort(403);
        }

        $item->update($request->validated());

        flash('Settings updated.');

        return redirect(route("settings"));
    }
}
