<?php

namespace App\Http\Controllers;

use App\Models\PayableReceivable;
use DateTime;
use Illuminate\Http\Request;

use App\Services\EmailService;
use View;

class InvoicesNFSController extends Controller
{
    public function index(Request $request){
        $data = PayableReceivable::invoicesNFS($request);
//        dd($data);
        return view('invoices_nfs.index',
            [
                'data' => $data,
            ]);
    }

    public function bill($lot, $id_bank_account)
    {
        $payable_receivables = PayableReceivable::selectedSendForEmail($lot, $id_bank_account);
        foreach ($payable_receivables as $payable_receivable)
        {
            $path = InvoicesNFSController::searchBill($payable_receivable['id_financial_launch']);
            $path = md5($path['contract_number']);
            $path = config('app.url').'bill/download/'.$path;

            $_email = [
                'title' => 'Boleto - Tatical Monitoramento',
                'message1' => 'Prezado(a) Sr(a), '. $payable_receivable['name_social_name'],
                'message2' => 'Estamos encaminhando o boleto bancário referente ao contrato '.str_pad($payable_receivable['id'], 5, '0', STR_PAD_LEFT),
                'message3' => 'Vencimento: '. date("m/d/Y", strtotime($payable_receivable['due_date'])),
                'message4' => 'Valor: R$ '. number_format($payable_receivable['value_bill'], 2, ',', '.'),
                'message5' => 'Para fazer download do boleto, ',
                'message6' => 'clique aqui',
                'path' => $path,
                'bottom1' => 'Atenciosamente,',
                'bottom2' => 'Equipe Tatical Monitoramento.'
            ];

            $view = View::make('email_template.index', [
                'title' => 'Boleto - Tatical Monitoramento',
                'message1' => 'Prezado(a) Sr(a), '. $payable_receivable['name_social_name'],
                'message2' => 'Estamos encaminhando o boleto bancário referente ao contrato '.str_pad($payable_receivable['id'], 5, '0', STR_PAD_LEFT),
                'message3' => 'Vencimento: '. date("m/d/Y", strtotime($payable_receivable['due_date'])),
                'message4' => 'Valor: R$ '. number_format($payable_receivable['value_bill'], 2, ',', '.'),
                'message5' => 'Para fazer download do boleto, ',
                'message6' => 'clique aqui',
                'path' => $path,
                'bottom1' => 'Atenciosamente,',
                'bottom2' => 'Equipe Tatical Monitoramento.'
            ]);

            $_email['content'] = $view->render();

            (new EmailService)->enviar($payable_receivable['email'], $_email);
        }

    }
     public static function searchBill($id_bill)
     {
         $bill = PayableReceivable::find($id_bill);
        return $bill;
     }

}
