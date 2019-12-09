<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'image', 'link', 'description', 'local',
        'date_time_start', 'date_time_end',
        'publish', 'administrator_id', 'id',
    ];

    protected $hidden = ['administrator_id'];
    protected $appends = [
        'photo_full_url', 'photo_thumb', 'date_start',
        'hour_start', 'date_end', 'hour_end',
        'datetime_start_to_end', 'day_end', 'day_start',
        'year_start', 'year_end', 'month_end', 'month_start', 'date_time_event',
    ];
    protected function getPhotoFullUrlAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') . '/eventos/' . $this->attributes['image'] : null;
    }
    protected function getPhotoThumbAttribute()
    {
        return !empty($this->attributes['image']) ? 'https://s3.' . config('filesystems.disks.s3.region') . '.amazonaws.com/' . config('filesystems.disks.s3.bucket') . '/eventos/thumbs/' . $this->attributes['image'] : null;
    }
    public function getDatetimeStartToEndAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('d/m/Y H:i') . ' - ' . Carbon::parse($this->date_time_end)->format('d/m/Y H:i');
    }
    public function getDatetimeEventAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('d/m/Y H:i') . 'h - ' . Carbon::parse($this->date_time_end)->format('d/m/Y H:i') . 'h';
    }
    public function getDateStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('d/m/Y');
    }
    public function getHourStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('H:i');
    }
    public function getMonthStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->formatLocalized('%B');
    }
    public function getDayStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('d');
    }
    public function getYearStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('Y');
    }
    public function getDateEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->format('d/m/Y');
    }
    public function getHourEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->format('H:i');
    }
    public function getDayEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->format('d');
    }
    public function getYearEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->format('Y');
    }
    public function getMonthEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->formatLocalized('%B');
    }
    /**
     * Get the events children for the event.
     */
    public function eventChildrens()
    {
        return $this->hasMany('App\EventChildren');
    }
    /**
     * Get the notifications for the event.
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    /**
     * Get the sponsors for the event.
     */
    public function sponsors()
    {
        return $this->belongsToMany('App\Sponsor');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'notifications' => $this->notifications,
            'name' => $this->name,
            'photo' => $this->photo_full_url,
            'link' => $this->link,
            'description' => $this->description,
            'place' => $this->local,
            'month_start' => $this->month_start,
            'month_end' => $this->month_end,
            'day_start' => $this->day_start,
            'day_end' => $this->day_end,
            'year_start' => $this->year_start,
            'year_end' => $this->year_end,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
            'date_time_event' => $this->date_time_event,
            'like' => $this->users->contains('id', \Auth::user()->id)
        ];
    }
}
