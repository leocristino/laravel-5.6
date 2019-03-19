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
        $person = Person::getSelect();

        return view('history.form',
            [
                'data' => $history,
                'person' => $person,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $history = new History();
        }else {
            $history = History::find($request->get('id'));
        }

        $history->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $history->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'history' => $history];
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
