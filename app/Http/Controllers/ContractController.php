<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Contract;
use \DB;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        return view('contract.index',
            [
                'data' => Contract::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $contract = new Contract();
        $person = Person::getSelect();
        $payment_type = PaymentType::getSelect();

        $contract->active = 1;

        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
            ]
        );
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        $person = Person::getSelect();
        $payment_type = PaymentType::getSelect();

        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
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


}
