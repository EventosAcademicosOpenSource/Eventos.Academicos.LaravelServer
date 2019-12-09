<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Speaker;
use App\Event;
class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        $minutes = Carbon::now()->addHours(24);
        $events = \Cache::remember('api::events', $minutes, function () {
            return Event::where('publish', '1')->orderBy('date_time_start', 'desc')->get();
        });
        
        $data = [];
        $data['events'] = $events->toArray();
        if ($events != null) 
            $data['status'] = true;
        else
            $data['status'] = false;
        return $data;
    }

    public function event($id)
    {
        $event = Event::find($id);
        $data = $event->toArray();
        $data['sponsors'] = $event->sponsors()->get();
        $data['event_childrens'] = $event->eventChildrens()->whereNull('speaker_id')->orderBy('date_time_start', 'asc')->get();
        $data['speeches'] = $event->eventChildrens()->whereNotNull('speaker_id')->where('publish', '1')->orderBy('date_time_start', 'asc')->get()->groupBy(function ($val) {
            return Carbon::parse($val->date_time_start)->format('d/m/Y');
        });
        $data['speakers'] = Speaker::whereHas('eventChildrens', function ($q) use ($id) {
            $q->where('event_id', $id);
        })->get();
        $data['notifications'] = $event->notifications()->orderBy('created_at', 'desc')->get();
        
        return $data;
    }
}
