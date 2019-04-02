<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Contract;
use \DB;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $payment_type = PaymentType::all();

        return view('contract.index',
            [
                'data' => Contract::getList($request),
                'params' => $request->all(),
                'payment_type' => $payment_type,
            ]
        );
    }

    public function create()
    {
        $contract = new Contract();
        $date = date("Y-m-d");
        $contract->start_date = $date;

        $person = Person::all();
        $payment_type = PaymentType::all();
        $service = Service::all();
        $contract->active = 1;

        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
                'service' => $service
            ]
        );
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        $person = Person::all();
        $payment_type = PaymentType::all();
        $service = Service::all();

        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
                'name' => Person::select('name_social_name')->where('id', '=', $contract->id_person)->first(),
                'service' => $service,
            ]
        );

    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $contract = new Contract();
        }else {
            $contract = Contract::find($request->get('id'));
        }

        $contract->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $contract->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'contract' => $contract];
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
            $res = Contract::activeDisabled($request->id, $request->type);

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
