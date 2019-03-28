<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Imei;
use \DB;

class ImeiController extends Controller
{


    public function index($id)
    {
        $data = Contract::find($id);

        $imei = $data->getImei();

        return view('imei.index',
            [
                'name' => Person::select('name_social_name')->where('id', '=', $data->id_person)->first(),
                'data' => $data,
                'values' => $imei,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            return ['result' => 'false', 'msg' => 'Dados Inválidos'];
        }

        $res = Imei::updateArray($request->get('id'), $request->get('valores'));

        if($res === true) {
            return ['result' => 'true', 'msg' => ''];
        }else {
            return ['result' => 'false', 'msg' => 'Ocorreu um erro inesperado. Entre em contato com o Administrador.'];
//            return ['result' => 'false', 'msg' => $res->getMessage()];
        }
    }

}
