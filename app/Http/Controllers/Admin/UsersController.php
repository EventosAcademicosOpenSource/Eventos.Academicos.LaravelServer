<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Administrator as User;
use Auth;
use Session;

class UsersController extends Controller
{
    public function __construct()
    {   //autentica para mexer no controller
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->email != "admin@admin.com")
            $users = User::where("email","!=","admin@admin.com")->orderBy('name')->paginate(20);
        else
            $users = User::orderBy('name')->paginate(20);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:administrators,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation'=> 'required|min:6'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        Session::flash('alert-success', 'Usuário criado com sucesso!!');
        
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user != null){
            return view('admin.users.edit',compact('user'));
        }
        Session::flash('alert-danger', 'Usuário não encontrado');
        return redirect()->route('admin.users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:administrators,email,'.$id,
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation'=> 'nullable|min:6',
        ],[
            'email.unique' => 'O e-mail "'.$request->email.'" já está sendo utilizado em outra conta'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != "")
        $user->password = $request->password;

        $user->save();

        Session::flash('alert-success', 'Usuário alterado com sucesso!!');
        
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user != null)
        {
            $user->delete();
            Session::flash('alert-success', 'Usuário excluído com sucesso!!');
        }else{
             Session::flash('alert-danger', 'Usuário não encontrado');
        }
       return redirect()->route('admin.users.index');
    }
}
