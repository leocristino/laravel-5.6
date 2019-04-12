<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Helpers\CawHelpers;
use App\Models\Helpers\CawPDF;
use Illuminate\Http\Request;
use App\Models\Person;
use \DB;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        return view('bank_account.index',
            [
                'data' => BankAccount::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $bank_account = new BankAccount();
        $bank_account->priceOfSend = 0.00;
        $bank_account->currentBalance = 0.00;
        $bank_account->active = 1;

        return view('bank_account.form',
            [
                'data' => $bank_account,
                'banks' => Bank::getSelectBank(),
            ]
        );
    }

    public function edit($id)
    {
        $bank_account = BankAccount::find($id);


        return view('bank_account.form',
            [
                'data' => $bank_account,
                'banks' => Bank::getSelectBank(),
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $bank_account = new BankAccount();
        }else {
            $bank_account = BankAccount::find($request->get('id'));
        }

        $bank_account->fill($request->toArray());

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $bank_account->active = 0;
            }else{
                $bank_account->active = 1;
            }
            $res = $bank_account->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'bank' => $bank_account];
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
            $res = BankAccount::activeDisabled($request->id, $request->type);

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
