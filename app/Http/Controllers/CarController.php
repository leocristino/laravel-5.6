<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use \DB;

class CarController extends Controller
{
    public function index(Request $request)
    {
        return view('car.index',
            [
                'data' => Car::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $car = new Car();
        $car->active = 1;

        return view('car.form',
            [
                'data' => $car,
            ]
        );
    }

    public function edit($id)
    {
        $car = Car::find($id);

        return view('car.form',
            [
                'data' => $car,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $car = new Car();
        }else {
            $car = Car::find($request->get('id'));
        }

        $car->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $car->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'history' => $car];
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
            $res = Car::activeDisabled($request->id, $request->type);

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
