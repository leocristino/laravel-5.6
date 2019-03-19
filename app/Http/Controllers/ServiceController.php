<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Service;
use \DB;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        return view('service.index',
            [
                'data' => Service::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $service = new Service();

        $service->active = 1;

        return view('service.form',
            [
                'data' => $service,
            ]
        );
    }

    public function edit($id)
    {
        $service = Service::find($id);

        return view('service.form',
            [
                'data' => $service,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $service = new Service();
        }else {
            $service = Service::find($request->get('id'));
        }
        $service->fill($request->toArray());

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $service->active = 0;
            }else{
                $service->active = 1;
            }
            $res = $service->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => ''];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => $res->getMessage()];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }
    public function activeDisabled(Request $request)
    {
        try {
            $res = Service::activeDisabled($request->id, $request->type);

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
