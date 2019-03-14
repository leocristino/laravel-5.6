<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Cep;
use \DB;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        return view('person.index',
            [
                'data' => Person::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $pessoa = new Person();

        $pessoa->active = 1;
        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
            ]
        );
    }

    public function edit($id)
    {
        $pessoa = Person::find($id);


        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
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

    public function activeDisabled(Request $request)
    {
        try {
            $res = Person::activeDisabled($request->id, $request->type);

            if($request->type == 1){
                $msn = "Registro foi desativado com sucesso.";
                $type = 0;
            }else{
                $type = 1;
                $msn = "Registro foi ativado com sucesso.";
            }

            if ($res === true) {
                DB::commit();
                return ['result' => true, 'msg' => $msn, 'id' => $request->id, 'type' => $type];
            } else {
                DB::rollBack();
                return ['result' => false, 'msg' => 'Ocorreu um erro, por favor entrar em contato com o Administrador.'];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => false, 'msg' => $e->getMessage()];
        }
    }
}
