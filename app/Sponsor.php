<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'image','link','administrator_id'
    ];

    protected $hidden = ['administrator_id'];

    protected $appends = ['photo', 'photo_thumb'];

    protected function getPhotoAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') .'/sponsors/'.$this->attributes['image'] : null;
    }
    protected function getPhotoThumbAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') .'/sponsors/thumbs/'.$this->attributes['image'] : null;
    }
}
