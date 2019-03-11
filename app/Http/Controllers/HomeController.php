<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        return view('home');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
