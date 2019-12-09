<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Administrator as User;
use Auth;
use Session;

class UsersPreferenceController extends Controller
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
        $user = User::find(Auth::id());
        return view('admin.users.preference', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:administrators,email,'.Auth::id(),
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation'=> 'nullable|min:6',
        ],[
            'email.unique' => 'O e-mail "'.$request->email.'" já está sendo utilizado em outra conta'
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != ""){
            $user->password = $request->password;
        }
        $user->save();

        Session::flash('alert-success', 'Sua conta foi alterada com sucesso!!');
        
        return redirect()->route('home');
    }
}
