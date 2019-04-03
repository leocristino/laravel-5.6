<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractService;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Service;
use \DB;

class ContractServiceController extends Controller
{


    public function index($id)
    {
        $data = Contract::find($id);
        $contract_service = $data->getContractService();
        $service = Service::all();


        return view('contract_service.index',
            [
                'name' => Person::select('name_social_name')->where('id', '=', $data->id_person)->first(),
                'data' => $data,
                'values' => $contract_service,
                'service' => $service,
            ]
        );
    }

    public function store(Request $request)
    {

        if(empty($request->get('id'))){
            return ['result' => 'false', 'msg' => 'Dados Inválidos'];
        }
        $res = ContractService::updateArray($request->get('id'), $request->get('valores'));
        if($res === true) {
            return ['result' => 'true', 'msg' => ''];
        }else {
//            return ['result' => 'false', 'msg' => 'Cidade já existe.'];
            return ['result' => 'false', 'msg' => $res->getMessage()];
        }
    }

    public function findValue (Request $request){
        $service = $request->get('service');

        $value = Service::query()->where('id', '=', $service)->first();
        return $value;
    }

}
