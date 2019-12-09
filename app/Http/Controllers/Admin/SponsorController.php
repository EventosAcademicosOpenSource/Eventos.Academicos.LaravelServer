<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Sponsor;
use App\Http\Requests\SponsorRequest;
use Session;
use Image;
use Storage;

class SponsorController extends Controller
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
        $sponsors = Sponsor::orderBy('name')->paginate(12);
        return view('admin.sponsor.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sponsor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SponsorRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request)
    {
        $sponsor = new Sponsor();
        $sponsor->name = $request->name;
        $sponsor->email = $request->email;
        $sponsor->link = $request->link;
        $sponsor->administrator_id = Auth::id();
        $sponsor->save();

        Session::flash('alert-success', 'Patrocinador cadastrado com sucesso!!');

        return redirect()->route('admin.patrocinadores.index');
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
        $sponsor = Sponsor::find($id);
        if ($sponsor != null) {
            return view('admin.sponsor.edit', compact('sponsor'));
        }
        Session::flash('alert-danger', 'Patrocinador não encontrado!!');
        return redirect()->route('admin.patrocinadores.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SponsorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorRequest $request, $id)
    {
        $sponsor = Sponsor::findOrFail($id);
        if ($sponsor == null) {
            Session::flash('alert-danger', 'Erro ao alterar patrocinador!!');
            return redirect()->route('admin.patrocinadores.index');
        }
        $sponsor->name = $request->name;
        $sponsor->email = $request->email;
        $sponsor->link = $request->link;
        $sponsor->administrator_id = Auth::id();
        if ($request->image != null) {
            $sponsor->image= $request->file('image');
        }
        
        $sponsor->save();

        Session::flash('alert-success', 'Patrocinador alterado com sucesso!!');

        return redirect()->route('admin.patrocinadores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        if ($sponsor != null) {
            $sponsor->delete();
        }
        Session::flash('alert-success', 'Patrocinador deletado com sucesso!!');
        return redirect()->route('admin.patrocinadores.index');
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
			$sponsors = Sponsor::where('name', 'LIKE', '%' . $request->search . '%')->paginate(12);
			if($sponsors->count() > 0)
			{
                $sponsors->appends(['search' => $request->search]);
                $search = $request->search;
				return view('admin.sponsor.index', compact('sponsors', 'search'));
			}
		}
		catch (\Exception $e)
		{
			return redirect()->route('admin.patrocinadores.index');
        }
        Session::flash('alert-danger', 'Não foi encontrado patrocinadores com esse nome!');
		return redirect()->route('admin.patrocinadores.index');
	}
}
