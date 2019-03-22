<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imei;
use \DB;

class ImeiController extends Controller
{
    public function index(Request $request)
    {
        return view('imei.index',
            [
                'data' => Imei::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $imei = new Imei();
        $imei->active = 1;

        return view('imei.form',
            [
                'data' => $imei,
            ]
        );
    }

    public function edit($id)
    {
        $imei = Imei::find($id);

        return view('imei.form',
            [
                'data' => $imei,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $imei = new Imei();
        }else {
            $imei = Imei::find($request->get('id'));
        }

        $imei->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $imei->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'history' => $imei];
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
            $res = Imei::activeDisabled($request->id, $request->type);

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
