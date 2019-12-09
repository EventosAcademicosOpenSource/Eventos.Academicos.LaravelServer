<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\EventRequests\EventEventRequest;
use App\Event;

use Carbon\Carbon;
use Session;

class EventController extends Controller
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
    public function index()
    {
        $events = Event::orderBy('updated_at', 'desc')->paginate(12);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dateStart = Carbon::now()->format('d/m/Y');   
        return view('admin.events.create',compact('dateStart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\EventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = new Event();

        $dataHoraInicialFinal = explode(" ",$request->date_time);
        
        $event->name = $request->name;
        $event->link = $request->link;
        $event->description = $request->description;
        $event->date_time_start = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[0] . ' '. $dataHoraInicialFinal[1].':00');
        $event->date_time_end = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[3] . ' '. $dataHoraInicialFinal[4].':00');
        $event->publish = $request->publish == 0 ? false : true;
        $event->image= $request->file('image');
        $event->administrator_id = Auth::id();
        $event->local = $request->local;
        
        
        $event->save();

        Session::flash('alert-success', 'Evento cadastrado com sucesso!!');

        return redirect()->route('admin.eventos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        if ($event != null) {
            return view('admin.events.edit', compact('event'));
        }

        Session::flash('alert-danger', 'Evento não encontrado!!');

        return redirect()->route('admin.eventos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EventRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::find($id);
        if ($event == null) {
            Session::flash('alert-danger', 'Erro ao alterar evento!!');
            return redirect()->route('admin.eventos.index');
        }

        $dataHoraInicialFinal = explode(" ",$request->date_time);
        $event->name = $request->name;
        $event->link = $request->link;
        $event->description = $request->description;
        $event->date_time_start = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[0] . ' '. $dataHoraInicialFinal[1].':00');
        $event->date_time_end = Carbon::createFromFormat('d/m/Y H:i:s', $dataHoraInicialFinal[3] . ' '. $dataHoraInicialFinal[4].':00');
        $event->publish = $request->publish == 0 ? false : true;
        $event->administrator_id = Auth::id();
        $event->local = $request->local;
        if ($request->image != null) {
            $event->image = $request->file('image');
        }
        
        $event->save();

        Session::flash('alert-success', 'Evento alterado com sucesso!!');

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
        $event = Event::find($id);
        if($event != null)
        {
            if ($event->eventChildrens->count() > 0) {
                foreach ($event->eventChildrens as $eventChildren) 
                {
                    $eventChildren->delete();    
                }
            }
            if ($event->notifications->count() > 0) {
                $event->notifications()->delete();
            }
            if ($event->sponsors->count() > 0) {
                $event->sponsors()->detach();
            }
            $event->delete();   
            Session::flash('alert-success', 'Evento deletado com sucesso!!');
        }else{
            Session::flash('alert-danger', 'Evento não encontrado!!');
        }

        return redirect()->route('admin.eventos.index');
    }

    /**
	* Show search blog.
	* @param Request $request
	* @return \Illuminate\Http\Response
	*/
	public function search(Request $request)
	{
		try
		{
			$events = Event::where('name', 'LIKE', '%' . $request->search . '%')->paginate(12);
			if($events->count() > 0)
			{
                $events->appends(['search' => $request->search]);
                $search = $request->search;
				return view('admin.events.index', compact('events', 'search'));
			}
		}
		catch (\Exception $e)
		{
			return redirect()->route('admin.eventos.index');
        }
        Session::flash('alert-danger', 'Não foi encontrado eventos com esse nome!');
		return redirect()->route('admin.eventos.index');
	}
}
