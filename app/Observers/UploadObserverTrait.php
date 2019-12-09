<?php

namespace App\Observers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

trait UploadObserverTrait
{
    protected function sendFile($model)
    {
        $field = $this->field;
        if (is_a($model->$field, UploadedFile::class) and $model->$field->isValid()) {
            $this->upload($model);
        }
    }
    protected function updateFile($model)
    {
        $field = $this->field;
        if (is_a($model->$field, UploadedFile::class) and $model->$field->isValid()) {
            $previous_image = $model->getOriginal($field);
            $this->upload($model);
            Storage::cloud()->delete($this->path2 . $previous_image);
            Storage::cloud()->delete($this->path . $previous_image);
        }
    }

    protected function removeFile($model)
    {
        $field = $this->field;
        Storage::cloud()->delete($this->path2 . $model->$field);
        Storage::cloud()->delete($this->path . $model->$field);
    }
    protected function upload($model)
    {
        $image = $this->field;

        $extension = $model->$image->extension();
        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name . '.' . $extension;

        if ($this->crop) {
            $img = Image::make($model->$image)->resize($this->resize_width, $this->resize_height, function ($constraint) {
                $constraint->aspectRatio();
            })->crop($this->crop_width,$this->crop_height);

            Storage::cloud()->put($this->path2.$name, (string)$img->encode());
        }
        if ($this->resize) {
            $img = Image::make($model->$image)->resize($this->resize_width, $this->resize_height, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::cloud()->put($this->path . $name, (string)$img->encode());
        } else {
            $model->$image->storeAs($this->path, $name);
        }
        $model->$image = $name;
    }
}
