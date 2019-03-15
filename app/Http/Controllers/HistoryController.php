<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\History;
use \DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        return view('history.index',
            [
                'data' => History::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $history = new History();
        $person = Person::getSelect();

        return view('history.form',
            [
                'data' => $history,
                'person' => $person
            ]
        );
    }

    public function edit($id)
    {
        $history = History::find($id);


        return view('history.form',
            [
                'data' => $history,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $pessoa = new Person();
        }else {
            $pessoa = Person::find($request->get('id'));
        }

        $pessoa->fill($request->toArray());

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $pessoa->active = 0;
            }else{
                $pessoa->active = 1;
            }
            $res = $pessoa->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'pessoa' => $pessoa];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : ""];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }


}
