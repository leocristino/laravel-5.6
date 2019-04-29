<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Helpers\CawPDF;
use App\Models\PaymentType;
use App\Models\Person;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\PayableReceivable;
use \DB;
use Illuminate\Support\Facades\Redirect;

class PayableReceivableController extends Controller
{
    public function index(Request $request)
    {
        return view('payable_receivable.index',
            [
                'data' => PayableReceivable::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create(Request $request)
    {
        if ($_GET['ticket'] == 'R' || $_GET['ticket'] == 'D')
            $type = $_GET['ticket'];
        else
        {
            return Redirect::to('payable_receivable');
        }

        $account_receivable = new PayableReceivable();
        $person = Person::getSelect();
        $ticket = Ticket::getSelect($type);
        $payment_type = PaymentType::getSelect();
        $bank_account = BankAccount::getSelect();
        $account_receivable->value_bill = 0.00;
        $account_receivable->amount_paid = 0.00;
        $account_receivable->account_type = $type;


        return view('payable_receivable.form',
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
//        dd($id);
        $account_receivable = PayableReceivable::find($id);
        $account_receivable->value_bill = $account_receivable->value_bill == '' ? 0.00 : $account_receivable->value_bill;
        $account_receivable->amount_paid = $account_receivable->amount_paid == '' ? 0.00 : $account_receivable->amount_paid;
        $type = $account_receivable['account_type'];

        $person = Person::getSelect();
        $ticket = Ticket::getSelect($type);
        $payment_type = PaymentType::getSelect();
        $bank_account = BankAccount::getSelect();



        return view('payable_receivable.form',
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
            $account_recevaible = new PayableReceivable();
        }else {
            $account_recevaible = PayableReceivable::find($request->get('id'));
        }

        $account_recevaible->fill($request->toArray());

        try {
            DB::beginTransaction();
//            $account_recevaible->account_type = "R";
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

            $res = PayableReceivable::deleteLine($request->id);
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

    public function pdf(Request $request)
    {
        $pdf = new CawPDF(true, 'Relatório de Contas');

        $header = function() use ($pdf){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20, 4, 'Tipo');
            $pdf->Cell(37, 4, 'Pessoa');
            $pdf->Cell(35, 4, 'Tipo Despesa');
            $pdf->Cell(50, 4, 'Forma de Pagamento');
            $pdf->Cell(30, 4, 'Data Vencimento');
            $pdf->Cell(20, 4, 'Valor');
            $pdf->Ln();

            $pdf->HrLine();
        };
        $pdf->setFnHeader($header);
        $pdf->setFilters($request->toArray());

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);

        $data = PayableReceivable::getList($request, false);
//        dd($data);
        foreach ($data as $item)
        {
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(20,4, $item->account_type == "R" ? 'Receita' : 'Despesa');
            $pdf->Cell(37,4, $item->name_social_name);
            $pdf->Cell(35,4, $item->name_ticket);
            $pdf->Cell(50,4, $item->name_payment_type);
            $pdf->Cell(30,4, $item->due_date != '' ? date("d/m/Y", strtotime($item->due_date)) : '');
            $pdf->Cell(20,4, "R$ " . ($item->value_bill != '' ? $item->value_bill : '0,00'));
            $pdf->Ln();


//            $pdf->Ln();
        }

        return response()
            ->make($pdf->Output())
            ->header('Content-Type', 'application/pdf');
    }


    public function csv(Request $request)
    {
        $csv = '';

        $csv .= 'Tipo Despesa;';
        $csv .= 'Cliente;';
        $csv .= 'Plano de Conta;';
        $csv .= 'Forma de Pagamento;';
        $csv .= 'Conta Corrente;';
        $csv .= 'Descrição;';
        $csv .= 'Data de Vencimento;';
        $csv .= 'Valor a Pagar;';
        $csv .= 'Data do Pagamento;';
        $csv .= 'Valor Pago;';
        $csv .= 'Descrição do retorno;';

        $csv .= chr(13);

        $data = PayableReceivable::getList($request);
//        dd($data);
        foreach ($data as $item) {
            $account_type = $item->account_type == 'R' ? 'Receita' : 'Despesa';


            if ($item->value_bill)
                $value_bill = 'R$ ' . number_format($item->value_bill, 2, ',', '.');

            if ($item->amount_paid)
                $item->amount_paid = 'R$ ' . number_format($item->amount_paid, 2, ',', '.');

            $csv .= "\"$account_type\";";
            $csv .= "\"$item->name_social_name\";";
            $csv .= "\"$item->name_ticket\";";
            $csv .= "\"$item->name_payment_type\";";
            $csv .= "\"$item->name_bank_account\";";
            $csv .= "\"$item->description\";";
            $csv .= "\"$item->due_date\";";
            $csv .= "\"$value_bill\";";
            $csv .= "\"$item->payment_date\";";
            $csv .= "\"$item->amount_paid\";";
            $csv .= "\"$item->description_bank_return\";";

            $csv .= chr(13);
        }

        $csv = utf8_decode($csv);

        return response()
            ->make($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=rel_contas.csv');
    }
}
