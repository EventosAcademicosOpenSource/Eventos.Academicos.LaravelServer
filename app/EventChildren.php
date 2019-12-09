<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class EventChildren extends Model
{
    protected $fillable = [
        'name','document','local','description',
        'date_time_start','date_time_end',
        'publish','event_id','speaker_id'
    ];
    protected $hidden = ['administrator_id'];
    protected $appends = ['date_start', 'hour_start','date_end','hour_end', 'datetime_start_to_end'];
    
    public function getDatetimeStartToEndAttribute()
    {    
        return Carbon::parse($this->date_time_start)->format('d/m/Y H:i') .' - '. Carbon::parse($this->date_time_end)->format('d/m/Y H:i');
    }
    public function getDateStartAttribute()
    {    
        return Carbon::parse($this->date_time_start)->format('d/m/Y');
    }
    public function getHourStartAttribute()
    {
        return Carbon::parse($this->date_time_start)->format('H:i');
    }
    public function getDateEndAttribute()
    {    
        return Carbon::parse($this->date_time_end)->format('d/m/Y');
    }
    public function getHourEndAttribute()
    {
        return Carbon::parse($this->date_time_end)->format('H:i');
    }
    /**
     * Get the event that owns the EventChildren.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function speaker()
    {
        return $this->belongsTo('App\Speaker');
    }

    public function toArray()
    {
        return [
            'date' => Carbon::parse($this->date_time_start)->format('d/m/Y'),
            'name' => $this->name,
            'description' => $this->description,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'hour_start' => $this->hourStart,
            'hour_end' => $this->hourEnd,
            'document' => $this->document,
            'place' => $this->local,
            'speaker' => $this->speaker
        ];
    }
}
