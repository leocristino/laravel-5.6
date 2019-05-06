<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Contract;
use App\Models\Helpers\CawHelpers;
use App\Models\Helpers\CawPDF;
use App\Models\PayableReceivable;
use App\Models\Ticket;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use OpenBoleto\Banco\BancoDoBrasil;
use OpenBoleto\Agente;
use OpenBoleto\Banco\Sicoob;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;

class BillController extends Controller
{
    /**
     * @param $id
     */
    public function index($id)
    {
        if (empty($id))
            return abort(404);


        $contract = PayableReceivable::printingTicket($id);
        if(count($contract) == 0)
            return abort(404);
        elseif ($contract[0]['payment_date'] != '')
            return 'Este Boleto já foi pago!';


        $name = $contract[0]['name_social_name'];
        $cpf = CawHelpers::mask($contract[0]['cpf_cnpj'],'###.###.###-##');
        $adress = $contract[0]['street'].', '.$contract[0]['street_number'];
        $zip = $contract[0]['zip'];
        $city = $contract[0]['city'];
        $state = $contract[0]['state'];

        $name_company = $contract[0]['name_company'];
        $address_company = $contract[0]['street'] . ', ' . $contract[0]['street_number'];
        $cpf_cnpj_company = $contract[0]['cpf_cnpj_company'];
        $zip_company = $contract[0]['zip_company'];
        $city_company = $contract[0]['city_company'];
        $state_company = $contract[0]['state_company'];

        // Parâmetros obrigatórios
        $due_date = $contract[0]['due_date'];
        $value_bill = $contract[0]['value_bill'];
        $sequencial = str_pad($contract[0]['id_financial_launch'], 5, 0, STR_PAD_LEFT);
        $agency_bank_account = $contract[0]['agency_bank_account'];
        $wallet = $contract[0]['wallet'];
        $account_current = str_replace('-', '', $contract[0]['account_current']);
        $pact = $contract[0]['pact'];
        $instruction = ['Pagar até a data do vencimento', $contract[0]['instruction']];
//        dd($instruction);


        if ($contract[0]['id_bank'] == '1') {
//            dd($contract[0]['id_bank'],$sequencial);


            $sacado = new Agente(
                $name,
                $cpf,
                $adress,
                $zip,
                $city,
                $state
            );
            $cedente = new Agente(
                $name_company,
                $cpf_cnpj_company,
                $address_company,
                $zip_company,
                $city_company,
                $state_company
            );

            $boleto = new BancoDoBrasil(array(
                // Parâmetros obrigatórios
                'dataVencimento' => new DateTime($due_date),
                'valor' => $value_bill,
                'sequencial' => $sequencial, // Para gerar o nosso número
                'sacado' => $sacado,
                'cedente' => $cedente,
                'agencia' => $agency_bank_account, // Até 4 dígitos
                'carteira' => $wallet,
                'conta' => $account_current, // Até 8 dígitos
                'convenio' => $pact, // 4, 6 ou 7 dígitos
                'instrucoes' => $instruction,
            ));

        }
        elseif ($contract[0]['id_bank'] == '756')
        {
            $sacado = new Agente(
                $name,
                $cpf,
                $adress,
                $zip,
                $city,
                $state
            );
            $cedente = new Agente(
                $name_company,
                $cpf_cnpj_company,
                $address_company,
                $zip_company,
                $city_company,
                $state_company
            );

            $boleto = new Sicoob(array(
                // Parâmetros obrigatórios
                'dataVencimento' => new DateTime($due_date),
                'valor' => $value_bill,
                'sequencial' => $sequencial, // Para gerar o nosso número
                'sacado' => $sacado,
                'cedente' => $cedente,
                'agencia' => $agency_bank_account, // Até 4 dígitos
                'carteira' => $wallet,
                'conta' => $account_current, // Até 8 dígitos
                'convenio' => $pact, // 4, 6 ou 7 dígitos
                'instrucoes' => $instruction,
            ));


        }
        echo $boleto->getOutput();
    }

    public function print_check($id)
    {
        if (empty($id))
            return abort(404);

        $pdf = new CawPDF(false, '');

        $contract = PayableReceivable::printingTicket($id);

//        $header = function() use ($pdf){
//            $pdf->SetFont('Arial','B',8);
//            $pdf->Cell(20, 4, 'Tipo');
//            $pdf->Cell(37, 4, 'Pessoa');
//            $pdf->Cell(35, 4, 'Tipo Despesa');
//            $pdf->Cell(50, 4, 'Forma de Pagamento');
//            $pdf->Cell(30, 4, 'Data Vencimento');
//            $pdf->Cell(20, 4, 'Valor');
//            $pdf->Ln();
//
//            $pdf->HrLine();
//        };
//        $pdf->setFnHeader($header);
//        $pdf->setFilters($request->toArray());

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);
//        dd($pdf);

        $number = new NumeroPorExtenso();

        foreach ($contract as $item)
        {
//            dd($item);
            $pdf->Cell(170,6, 'R$ ' . number_format($item->value_bill, 2, ',', '.'),1,0,'R');
            $pdf->Ln();
//            $pdf->getLMargin(120);
            $extenso = $number->converter($item->value_bill);
            $pdf->Cell(170,6, ucfirst($extenso),'1');
//            $pdf->Cell(35,4, $item->name_ticket);
//            $pdf->Cell(50,4, $item->name_payment_type);
//            $pdf->Cell(30,4, $item->due_date != '' ? date("d/m/Y", strtotime($item->due_date)) : '');
//            $pdf->Cell(20,4, "R$ " . ($item->value_bill != '' ? $item->value_bill : '0,00'));
//            $pdf->Ln();


//            $pdf->Ln();
        }

        return response()
            ->make($pdf->Output())
            ->header('Content-Type', 'application/pdf');



        dd($id);

//        $contract = PayableReceivable::printingTicket($id);
//        if(count($contract) == 0)
//            return abort(404);
//        elseif ($contract[0]['payment_date'] != '')
//            return 'Este Boleto já foi pago!';
//
//
//        $name = $contract[0]['name_social_name'];
//        $cpf = CawHelpers::mask($contract[0]['cpf_cnpj'],'###.###.###-##');
//        $adress = $contract[0]['street'].', '.$contract[0]['street_number'];
//        $zip = $contract[0]['zip'];
//        $city = $contract[0]['city'];
//        $state = $contract[0]['state'];
//
//        $name_company = $contract[0]['name_company'];
//        $address_company = $contract[0]['street'] . ', ' . $contract[0]['street_number'];
//        $cpf_cnpj_company = $contract[0]['cpf_cnpj_company'];
//        $zip_company = $contract[0]['zip_company'];
//        $city_company = $contract[0]['city_company'];
//        $state_company = $contract[0]['state_company'];
//
//        // Parâmetros obrigatórios
//        $due_date = $contract[0]['due_date'];
//        $value_bill = $contract[0]['value_bill'];
//        $sequencial = str_pad($contract[0]['id_financial_launch'], 5, 0, STR_PAD_LEFT);
//        $agency_bank_account = $contract[0]['agency_bank_account'];
//        $wallet = $contract[0]['wallet'];
//        $account_current = str_replace('-', '', $contract[0]['account_current']);
//        $pact = $contract[0]['pact'];
//        $instruction = ['Pagar até a data do vencimento', $contract[0]['instruction']];
////        dd($instruction);
//
//
//        if ($contract[0]['id_bank'] == '1') {
////            dd($contract[0]['id_bank'],$sequencial);
//
//
//            $sacado = new Agente(
//                $name,
//                $cpf,
//                $adress,
//                $zip,
//                $city,
//                $state
//            );
//            $cedente = new Agente(
//                $name_company,
//                $cpf_cnpj_company,
//                $address_company,
//                $zip_company,
//                $city_company,
//                $state_company
//            );
//
//            $boleto = new BancoDoBrasil(array(
//                // Parâmetros obrigatórios
//                'dataVencimento' => new DateTime($due_date),
//                'valor' => $value_bill,
//                'sequencial' => $sequencial, // Para gerar o nosso número
//                'sacado' => $sacado,
//                'cedente' => $cedente,
//                'agencia' => $agency_bank_account, // Até 4 dígitos
//                'carteira' => $wallet,
//                'conta' => $account_current, // Até 8 dígitos
//                'convenio' => $pact, // 4, 6 ou 7 dígitos
//                'instrucoes' => $instruction,
//            ));
//
//        }
//        elseif ($contract[0]['id_bank'] == '756')
//        {
//            $sacado = new Agente(
//                $name,
//                $cpf,
//                $adress,
//                $zip,
//                $city,
//                $state
//            );
//            $cedente = new Agente(
//                $name_company,
//                $cpf_cnpj_company,
//                $address_company,
//                $zip_company,
//                $city_company,
//                $state_company
//            );
//
//            $boleto = new Sicoob(array(
//                // Parâmetros obrigatórios
//                'dataVencimento' => new DateTime($due_date),
//                'valor' => $value_bill,
//                'sequencial' => $sequencial, // Para gerar o nosso número
//                'sacado' => $sacado,
//                'cedente' => $cedente,
//                'agencia' => $agency_bank_account, // Até 4 dígitos
//                'carteira' => $wallet,
//                'conta' => $account_current, // Até 8 dígitos
//                'convenio' => $pact, // 4, 6 ou 7 dígitos
//                'instrucoes' => $instruction,
//            ));
//
//
//        }
//        echo $boleto->getOutput();

    }
}
