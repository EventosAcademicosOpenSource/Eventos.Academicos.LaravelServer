<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventChildrenNoSpeakerRequest;
use Illuminate\Support\Facades\File;
use App\Event;
use App\EventChildren;
use Session;

use Carbon\Carbon;
use Storage;
use App\Speaker;

class EventChildrenNoSpeakerController extends Controller
{
    public function __construct()
    {   //autentica para mexer no controller de eventos
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $event = Event::find($id);
        if ($event != null) {
            $childrenEvents = $event->eventChildrens()->whereNull('speaker_id')->orderBy('date_time_start', 'asc')->paginate(30);
            return view('admin.events.children_events_no_speakers.index', compact('event','childrenEvents'));
        }
        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $event = Event::find($id);
        return view('admin.events.children_events_no_speakers.create', compact('id', 'event'));
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\EventChildrenNoSpeakerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventChildrenNoSpeakerRequest $request)
    {
        $event = Event::find($request->eventId);
        if ($event != null) {
            $dataHoraInicialFinal = explode(" ",$request->date_time);
        
            $eventChildren = new EventChildren();
            //campos para cadastro
            $eventChildren->name = $request->name;
            $eventChildren->description = $request->description;
            $eventChildren->date_time_start = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[0] . ' '. $dataHoraInicialFinal[1].':00');
            $eventChildren->date_time_end = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[3] . ' '. $dataHoraInicialFinal[4].':00');
            $eventChildren->publish = $request->publish == 0 ? false : true;
            $eventChildren->event_id = $request->eventId;
            $eventChildren->local = $request->local;
            $eventChildren->speaker_id = null;
            $eventChildren->document = null;

            //salvando a palestra no evento
            $event->eventChildrens()->save($eventChildren);
            
            Session::flash('alert-success', 'Evento Integrante cadastrado com sucesso!!');
            return redirect()->route('admin.eventChildrenNoSpeaker.index', $request->eventId);
        }

        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = EventChildren::find($id);
        if($event != null)
        {
            $id = $event->event->id;
            $event->delete();        
        }

        Session::flash('alert-success', 'Evento Integrante deletado com sucesso!!');
        return redirect()->route('admin.eventChildrenNoSpeaker.index', $id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$idEvent)
    {
        $event = EventChildren::find($idEvent);
        if ($event != null && $event->speaker_id == null) {
            return view('admin.events.children_events_no_speakers.edit', compact('event', 'id'));
        }

        Session::flash('alert-danger', 'Evento Integrante não encontrado!!');

        return redirect()->route('admin.eventChildrenNoSpeaker.index', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EventChildrenNoSpeakerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventChildrenNoSpeakerRequest $request, $id)
    {
        $event = Event::find($request->eventId);
        if ($event != null) {
            $dataHoraInicialFinal = explode(" ",$request->date_time);
        
            $eventChildren = EventChildren::find($id);
            //campos para cadastro
            $eventChildren->name = $request->name;
            $eventChildren->description = $request->description;
            $eventChildren->date_time_start = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[0] . ' '. $dataHoraInicialFinal[1].':00');
            $eventChildren->date_time_end = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[3] . ' '. $dataHoraInicialFinal[4].':00');
            $eventChildren->publish = $request->publish == 0 ? false : true;
            $eventChildren->event_id = $request->eventId;
            $eventChildren->local = $request->local;

            //salvando a palestra no evento
            $eventChildren->save();
            
            Session::flash('alert-success', 'Evento Integrante atualizado com sucesso!!');
            return redirect()->route('admin.eventChildrenNoSpeaker.index', $request->eventId);
        }

        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }
}
