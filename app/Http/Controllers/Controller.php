<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Creates files and images for files in request.
     * Returns request data without files
     */
    protected function handleFileUploads()
    {
        collect(request()->files)->each(
            function ($file, $key) {
                $name = $file->getClientOriginalName();
                if ($key === 'file') {
                    // upload and set file relation
                    $path = request()->file($key)->store('uploads');
                    $fileModel = \App\File::createFromStoragePath($path, $name);

                    request()->merge(['file_id' => $fileModel->id]);
                } elseif ($key === 'image_file') {
                    // uploading image
                    $relation = str_replace('_file', '', $key);
                    $path = request()->file($key)->store('uploads');
                    $fileModel = \App\File::createFromStoragePath($path, $name);

                    $imageModel = \App\Image::create(
                        [
                        'name' => $name,
                        'file_id' => $fileModel->id,
                        'user_id' => auth()->check() ? request()->user()->id : null,
                        ]
                    );

                    request()->merge(['image_id' => $imageModel->id]);
                } else {
                    return abort(500, "Could not store file for $key");
                }
            }
        );

        return request()->except(
            request()->files->keys()
        );
    }

    protected function getFieldsFromRules($request)
    {
        $rules = collect(($request)->rules())
            ->mapWithKeys(
                function ($rules, $name) {
                    if (gettype($rules) === 'string') {
                        return [$name => explode('|', $rules)];
                    }
                    return [$name => $rules];
                }
            );

        return $rules;
    }

    public function getValidated()
    {
        $data = $this->handleFileUploads();

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        if (isset($data['image_id'])) {
            $fields = $fields->merge(['image_id' => []]);
        }

        if (isset($data['file_id'])) {
            $fields = $fields->merge(['file_id' => []]);
        }

        $data = array_intersect_key($data, $fields->toArray());

        return $data;
    }
}
