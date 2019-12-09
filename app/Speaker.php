<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'image','link','description','administrator_id'
    ];
    protected $hidden = ['administrator_id'];
    protected $appends = ['photo_full_url', 'photo_thumb'];

    protected function getPhotoFullUrlAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') .'/speakers/'.$this->attributes['image'] : null;
    }
    protected function getPhotoThumbAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') .'/speakers/thumbs/'.$this->attributes['image'] : null;
    }
    public function eventChildrens()
    {
        return $this->hasMany('App\EventChildren');
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo_full_url,
            'description' => $this->description,
            'link' => $this->link,
            'email' => $this->email,
        ];
    }
}
