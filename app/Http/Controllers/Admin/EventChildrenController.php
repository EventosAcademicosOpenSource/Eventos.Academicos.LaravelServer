<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventChildrenRequest;
use Illuminate\Support\Facades\File;
use App\Event;
use App\EventChildren;
use Session;

use Carbon\Carbon;
use Storage;
use App\Speaker;

class EventChildrenController extends Controller
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
            $childrenEvents = $event->eventChildrens()->whereNotNull('speaker_id')->orderBy('date_time_start', 'asc')->paginate(30);
            return view('admin.events.children_events.index', compact('event','childrenEvents'));
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
        $speakers = Speaker::all();
        $event = Event::find($id);
        return view('admin.events.children_events.create', compact('id', 'speakers', 'event'));
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\EventChildrenRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventChildrenRequest $request)
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
            $eventChildren->speaker_id = $request->palestrante;
            $eventChildren->document = $request->document;

            //salvando a palestra no evento
            $event->eventChildrens()->save($eventChildren);
            
            Session::flash('alert-success', 'Palestra cadastrada com sucesso!!');
            return redirect()->route('admin.eventChildren.index', $request->eventId);
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

        Session::flash('alert-success', 'Palestra deletada com sucesso!!');
        return redirect()->route('admin.eventChildren.index', $id);
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
        if ($event != null && $event->speaker_id != null) {
            $speakers = Speaker::all();
            return view('admin.events.children_events.edit', compact('event', 'id', 'speakers'));
        }

        Session::flash('alert-danger', 'Palestra não encontrada!!');

        return redirect()->route('admin.eventChildren.index', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EventRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventChildrenRequest $request, $id)
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
            $eventChildren->speaker_id = $request->palestrante;
            $eventChildren->document = $request->document;
            
            //salvando a palestra no evento
            $eventChildren->save();
            
            Session::flash('alert-success', 'Palestra atualizada com sucesso!!');
            return redirect()->route('admin.eventChildren.index', $request->eventId);
        }

        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }
}
