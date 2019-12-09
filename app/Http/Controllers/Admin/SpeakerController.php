<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Speaker;
use App\Http\Requests\SpeakerRequest;
use Session;
use Image;
use Storage;


class SpeakerController extends Controller
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
        $speakers = Speaker::orderBy('name')->paginate(12);
        return view('admin.speaker.index', compact('speakers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.speaker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SpeakerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpeakerRequest $request)
    {
        $speaker = new Speaker();
        $speaker->name = $request->name;
        $speaker->email = $request->email;
        $speaker->link = $request->link;
        $speaker->description = $request->description;
        $speaker->administrator_id = Auth::id();
        $speaker->image= $request->file('image');
        $speaker->save();

        Session::flash('alert-success', 'Palestrante cadastrado com sucesso!!');

        return redirect()->route('admin.palestrantes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $speak = Speaker::find($id);
        if ($speak != null) {
            return view('admin.speaker.edit', compact('speak'));
        }
        Session::flash('alert-danger', 'Palestrante não encontrado!!');
        return redirect()->route('admin.palestrantes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SpeakerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpeakerRequest $request, $id)
    {
        $speaker = Speaker::findOrFail($id);
        if ($speaker == null) {
            Session::flash('alert-danger', 'Erro ao alterar palestrante!!');
            return redirect()->route('admin.palestrantes.index');
        }
        $speaker->name = $request->name;
        $speaker->email = $request->email;
        $speaker->link = $request->link;
        $speaker->description = $request->description;
        $speaker->administrator_id = Auth::id();
        if ($request->image != null) {
            $speaker->image = $request->file('image');
        }
        $speaker->save();

        Session::flash('alert-success', 'Palestrante alterado com sucesso!!');

        return redirect()->route('admin.palestrantes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $speaker = Speaker::findOrFail($id);
        if ($speaker != null) {
            $speaker->delete();
        }
        Session::flash('alert-success', 'Palestrante deletado com sucesso!!');
        return redirect()->route('admin.palestrantes.index');
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
			$speakers = Speaker::where('name', 'LIKE', '%' . $request->search . '%')->paginate(12);
			if($speakers->count() > 0)
			{
                $speakers->appends(['search' => $request->search]);
                $search = $request->search;
				return view('admin.speaker.index', compact('speakers', 'search'));
			}
		}
		catch (\Exception $e)
		{
			return redirect()->route('admin.palestrantes.index');
        }
        Session::flash('alert-danger', 'Não foi encontrado palestrantes com esse nome!');
		return redirect()->route('admin.palestrantes.index');
	}
}
