<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Car;
use \DB;

class CarController extends Controller
{


    public function index($id)
    {
        $data = Contract::find($id);

        $car = $data->getCar();

        return view('car.index',
            [
                'name' => Person::select('name_social_name')->where('id', '=', $data->id_person)->first(),
                'data' => $data,
                'values' => $car,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            return ['result' => 'false', 'msg' => 'Dados Inválidos'];
        }

        $res = Car::updateArray($request->get('id'), $request->get('valores'));
//        dd($res);
        if($res === true) {
            return ['result' => 'true', 'msg' => ''];
        }else {
//            return ['result' => 'false', 'msg' => 'Cidade já existe.'];
            return ['result' => 'false', 'msg' => $res->getMessage()];
        }
    }

}
