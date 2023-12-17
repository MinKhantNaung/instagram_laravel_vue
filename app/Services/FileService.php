<?php

namespace App\Services;
use Image;

class FileService
{
    public function updateFile($model, $request, $type)
    {
        if(!empty($model->file)) {
            $current_file = public_path() . $model->file;

            if(file_exists($current_file) && $current_file != public_path() .  '/user-placeholder.png') {
                unlink($current_file); // delete
            }
        }

        $file = null;
        if($type == 'user') {
            $file = Image::make($request->file('file'))->resize(400, 400);
        } else {
            $file = Image::make($request->file('file'));
        }

        $ext = $request->file('file');
        $extension = $ext->getClientOriginalExtension();
        $name = time() . '_' . $extension;
        $file->save(public_path() . '/file/' . $name);

        $model->file = '/file/' . $name;

        return $model;
    }
}
