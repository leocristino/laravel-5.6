<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Contract;
use App\Models\PayableReceivable;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function index(Request $request)
    {
//        dd(Ticket::selectTicketTypeR);
        return view('billing.index',
            [
                'ticket' => Ticket::selectTicketTypeR(),
            ]
        );
    }

    public function store(Request $request)
    {
        $contracts = Contract::billing($request);
        $referenceDate = explode('/',$request['referenceDate']);


        try {
            DB::beginTransaction();
            $qtd = 0;

            $lot = PayableReceivable::max('lot');
            $lot = $lot + 1;
            $triggerLot = false;
//            dd($contracts);
            foreach ($contracts as $contract)
            {
                $account_receivable = new PayableReceivable();
                $account_receivable->account_type = "R";

                $account_receivable->id_person = $contract['id_person'];
                $account_receivable->id_ticket = $request['id_ticket'];
                $account_receivable->id_payment_type = $contract['id_payment_type'];
                $account_receivable->id_bank_account = $contract['id_bank_account'];
                $account_receivable->due_date = $referenceDate[1].'-'.$referenceDate[0].'-'.$contract['due_day'];
                $account_receivable->value_bill = $contract['valueContract'];
                $account_receivable->contract_number = $contract['id'];

                $billing = PayableReceivable::selectToBill($contract['id_person'], $account_receivable->due_date, $account_receivable->contract_number);

                if (count($billing) == 0)
                {
                    $triggerLot = true;

                    $account_receivable->lot = $lot;
                    $qtd ++;
                    $account_receivable->saveBilling();
                }
            }

            DB::commit();
            return ['result' => 'true', 'msg' => '', 'account_receivable' => '', 'lot' => $triggerLot != true ? '' : $lot, 'qtd' => $qtd];

        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }





//        if(empty($request->get('id'))){
//            $account_recevaible = new PayableReceivable();
//        }else {
//            $account_recevaible = PayableReceivable::find($request->get('id'));
//        }
//
//        $account_recevaible->fill($request->toArray());

    }
}
