<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function updateFile($model, $request, $type, $folder)
    {
        if(!empty($model->file)) {
            Storage::delete('public/images/' . $model->file);
        }

        $file_name = uniqid() . '_' . $request->file('file')->getClientOriginalName();

        $request->file('file')->storeAs($folder, $file_name, 'public');

        $model->file = $file_name;

        return $model;
    }
}
