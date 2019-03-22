<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentType;
use \DB;

class PaymentTypeController extends Controller
{
    public function index(Request $request)
    {

        return view('payment_type.index',
            [
                'data' => PaymentType::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $payment_type = new PaymentType();
        $payment_type->active = 1;

        return view('payment_type.form',
            [
                'data' => $payment_type,
            ]
        );
    }

    public function edit($id)
    {
        $payment_type = PaymentType::find($id);

        return view('payment_type.form',
            [
                'data' => $payment_type,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $payment_type = new PaymentType();
        }else {
            $payment_type = PaymentType::find($request->get('id'));
        }

        $payment_type->fill($request->toArray());

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $payment_type->active = 0;
            }else{
                $payment_type->active = 1;
            }
            $res = $payment_type->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'history' => $payment_type];
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
            $res = PaymentType::activeDisabled($request->id, $request->type);

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
