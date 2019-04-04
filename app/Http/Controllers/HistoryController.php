<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $currentUser = auth()->user()->id;
        $user = new User();

        return view('history.form',
            [
                'data' => $history,
                'person' => $person,
                'currentUser' => $currentUser,
                'responsible' => $user,
            ]
        );
    }

    public function edit($id)
    {
        $history = History::find($id);
        $user = User::find($history->responsible);
        $person = Person::getSelect();
        $history->contact_time = date("Y-m-d", strtotime($history->contact_time));
        $currentUser = auth()->user()->id;

        return view('history.form',
            [
                'data' => $history,
                'person' => $person,
                'responsible' => $user,
                'currentUser' => $currentUser,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $history = new History();
            $history->responsible = auth()->user()->id;
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
