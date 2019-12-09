<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'title','message','event_id'
    ];
    protected $appends = ['dateNotification'];

    public function getDateNotificationAttribute($value)
    {    
        return Carbon::parse($this->created_at)->format('d/m/Y H:i'). 'h';
    }
}
