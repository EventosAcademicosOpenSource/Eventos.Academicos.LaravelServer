<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Event;
use App\Sponsor;
use Session;

class EventSponsorController extends Controller
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
            $sponsors = Sponsor::all();
            $eventSponsors = $event->sponsors()->orderBy('updated_at', 'desc')->get();
            return view('admin.events.sponsors.index', compact('eventSponsors','sponsors', 'event'));
        }
        Session::flash('alert-danger', 'Evento não encontrado!!');
        return redirect()->route('admin.eventos.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sponsor_id' => 'required|unique_with:event_sponsor,event_id',
        ],
        [
            'sponsor_id.required' => 'Está faltando selecionar um patrocinador.',
            'sponsor_id.unique_with' => 'Este patrocinador já está cadastrado neste evento.',
        ]);
        $event = Event::find($request->event_id);
        if ($event != null) {
            $sponsor = Sponsor::find($request->sponsor_id);

            $event->sponsors()->attach($sponsor);
            
            Session::flash('alert-success', 'Patrocinador cadastrado com sucesso!!');
            return redirect()->route('admin.eventSponsors.index', $request->event_id);
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
    public function destroy($id, $idPatrocinador)
    {
        $event = Event::find($id);
        if($event != null)
        {
            $sponsor = Sponsor::find($idPatrocinador);
            $event->sponsors()->detach($sponsor);    

            Session::flash('alert-success', 'Palestrante cadastrado com sucesso!!');
            return redirect()->route('admin.eventSponsors.index', $id);    
        }

        Session::flash('alert-danger', 'Evento não encontrado');
        return redirect()->route('admin.eventos.index');
    }
}
