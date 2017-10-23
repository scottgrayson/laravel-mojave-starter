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

    public function index()
    {
        SEO::setTitle('My Campers');
        SEO::setDescription('My Campers');

        // Include the request variables in the pagination links
        $items = request()->user()->campers;

        return view(
            'campers.index',
            [
                'slug' => $this->slug,
                'model' => $this->model,
                'items' => $items,
            ]
        );
    }

    public function create()
    {
        SEO::setTitle('Create Camper');
        SEO::setDescription('Create Camper');

        $fields = $this->getFieldsFromRules(new CamperRequest);

        return view(
            'campers.create',
            [
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

    public function edit(Request $request, $id)
    {
        $camper = Camper::findOrFail($id);

        if (request()->user()->id != $camper->user_id) {
            abort(403);
        }

        $requestedStep = request('step');
        $currentStep = 1;

        $camperRequest = new CamperRequest;

        foreach ($camperRequest->steps() as $index => $stepFields) {
            $unfinished = collect($stepFields)
                ->contains(function ($rules, $field) use ($camper) {
                    return strpos($rules, 'required') !== false && !$camper->$field;
                });

            $currentStep = $index + 1;
            if ($unfinished) {
                break;
            }
        }

        if (!$requestedStep || $currentStep < $requestedStep) {
            return redirect(route('campers.edit', ['camper' => $camper->id, 'step' => $currentStep]));
        } else {
            $currentStep = $requestedStep;
        }

        SEO::setTitle('Camper Registration for ' . $camper->label);
        SEO::setDescription('Camper Registration for ' . $camper->label);

        $fields = $this->getFieldsFromRules($camperRequest);

        // PREFILL
        $doNotPrefill = [
            'name',
            'tent_id',
            'birthdate',
            'allergies',
            'medical_conditions',
        ];

        $fieldNames = array_diff(
            $fields->keys()->toArray(),
            $doNotPrefill
        );

        $otherCamper = auth()->user()->campers()
            ->where('id', '!=', $camper->id)
            ->where(function ($q) use ($fieldNames) {
                foreach ($fieldNames as $col) {
                    $q->orWhereNotNull($col);
                }
            })
            ->first();

        // prefill guardian info with campers info
        if (in_array('guardian_address', $fieldNames)) {
            foreach ($fieldNames as $guardianField) {
                $camperField = str_replace('guardian_', '', $guardianField);
                if (!$camper->$guardianField) {
                    $camper->$guardianField = $camper->$camperField;
                }
            }
        }

        // prefill camper 2 with some of camper 1's info
        if ($otherCamper) {
            foreach ($fieldNames as $field) {
                if (!$camper->$field) {
                    $camper->$field = $otherCamper->$field;
                }
            }
        }

        return view(
            'campers.edit',
            [
                'currentStep' => $currentStep,
                'item' => $camper,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    public function update(CamperRequest $request, $id)
    {
        $item = Camper::findOrFail($id);

        if (request()->user()->id != $item->user_id) {
            abort(403);
        }

        $item->fill($request->validated());

        $changed = $item->isDirty();

        $item->save();

        if ($changed) {
            flash('Registration updated.')->success();
        }

        $currentStep = request('step') ? request('step') : 1;

        if ($currentStep == 4) {
            return redirect(route('campers.index'));
        } else {
            return redirect(route('campers.edit', [
                'camper' => $item->id,
                'step' => $currentStep + 1,
            ]));
        }
    }

    public function destroy($id)
    {
        $item = Camper::findOrFail($id);

        if (request()->user()->id != $item->user_id) {
            abort(403);
        }

        $item->delete();

        flash('Camper deleted.')->success();

        return redirect(route("campers.index"));
    }
}
