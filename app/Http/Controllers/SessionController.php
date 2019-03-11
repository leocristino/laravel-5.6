<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request){
        if(auth()->check()){
            return app('App\Http\Controllers\HomeController')->index($request);
        }else{
            return view('/login');
        }
    }

    public function create(){
        $this->validate(request(), [
            'email' => 'required|max:20',
            'password' => 'required'
        ]);

        auth()->logout();

        $user = User::login(\request('email'), \request('password'));

        return $user;

    }

    public function destroy(){
        auth()->logout();
        return redirect('/');
    }
}
