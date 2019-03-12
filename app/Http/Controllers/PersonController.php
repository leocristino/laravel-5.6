<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Cep;

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

        if ($pessoa->type === "J")
            $pessoa->type = "J";
        else
            $pessoa->type = "F";

        $pessoa->type = 'F';
        $pessoa->active = 'S';
        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
//                'cb_geral_tipo_pessoa' => CbGeralTipoPessoa::get(),
//                'cb_geral_instituicao' => null
            ]
        );
    }

    public function edit($id)
    {
        $pessoa = Person::find($id);
//        dd($pessoa);
        $pessoa['pessoa_tipo_pessoa'] = $pessoa->getTipoPessoa();
        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
//                'cb_geral_tipo_pessoa' => CbGeralTipoPessoa::get(),
//                'cb_geral_instituicao' => CbGeralInstituicao::find($pessoa->id_cb_geral_instituicao)
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $pessoa = new Person();
        }else {
            $pessoa = Pessoa::find($request->get('id'));
        }

        $pessoa->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $pessoa->save();
            $res2 = $pessoa->setTipoPessoa($request->get('pessoa_tipo_pessoa'));

            if ($res === true && $res2 === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'pessoa' => $pessoa];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : $res2->getMessage()];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }
}
