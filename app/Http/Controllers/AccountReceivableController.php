<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\PaymentType;
use App\Models\Person;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\AccountReceivable;
use \DB;

class AccountReceivableController extends Controller
{
    public function index(Request $request)
    {
        return view('account_receivable.index',
            [
                'data' => AccountReceivable::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $account_receivable = new AccountReceivable();
        $person = Person::getSelect();
        $ticket = Ticket::getSelect();
        $payment_type = PaymentType::getSelect();
        $bank_account = BankAccount::getSelect();
        $account_receivable->value_bill = 0.00;
        $account_receivable->amount_paid = 0.00;
        $account_receivable->account_type = "R";


        return view('account_receivable.form',
            [
                'data' => $account_receivable,
                'person' => $person,
                'ticket' => $ticket,
                'payment_type' => $payment_type,
                'bank_account' => $bank_account,
            ]
        );
    }

    public function edit($id)
    {
        $account_receivable = AccountReceivable::find($id);
        $person = Person::getSelect();
        $ticket = Ticket::getSelect();
        $payment_type = PaymentType::getSelect();
        $bank_account = BankAccount::getSelect();



        return view('account_receivable.form',
            [
                'data' => $account_receivable,
                'person' => $person,
                'ticket' => $ticket,
                'payment_type' => $payment_type,
                'bank_account' => $bank_account,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $account_recevaible = new AccountReceivable();
        }else {
            $account_recevaible = AccountReceivable::find($request->get('id'));
        }

        $account_recevaible->fill($request->toArray());

        try {
            DB::beginTransaction();
            $account_recevaible->account_type = "R";
            $res = $account_recevaible->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'account_receivable' => $account_recevaible];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : ""];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }
    public function delete(Request $request){

        try {

            $res = AccountReceivable::deleteLine($request->id);
            if ($res === true) {
                DB::commit();
                return ['result' => true, 'msg' => 'Excluido com sucesso.'];
            } else {
                DB::rollBack();
                return ['result' => false, 'msg' => 'Registro não foi excluido.'];
            }

        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => false, 'msg' => $e->getMessage()];
        }


    }
}
