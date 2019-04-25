<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Contract;
use App\Models\Helpers\CawHelpers;
use App\Models\PayableReceivable;
use App\Models\Ticket;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use OpenBoleto\Banco\BancoDoBrasil;
use OpenBoleto\Agente;

class BillController extends Controller
{
    /**
     * @param $id
     */
    public function index($id)
    {
        $contract = Contract::printingTicket($id);
//        dd($contract[0]);
        $cpf = CawHelpers::mask($contract[0]['cpf_cnpj'],'###.###.###-##');
        $adress = $contract[0]['street'].' '.$contract[0]['street_number'];
        $zip = $contract[0]['zip'];
        $city = $contract[0]['city'];
        $state = $contract[0]['state'];


        $sacado = new Agente($contract[0]['name_social_name'], $cpf, $adress, $zip, $city, $state);
        $cedente = new Agente('Empresa de cosméticos LTDA', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Brasília', 'DF');

        $boleto = new BancoDoBrasil(array(
            // Parâmetros obrigatórios
            'dataVencimento' => new DateTime('2013-01-24'),
            'valor' => 23.00,
            'sequencial' => 1234567, // Para gerar o nosso número
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => 1724, // Até 4 dígitos
            'carteira' => 18,
            'conta' => 10403005, // Até 8 dígitos
            'convenio' => 1234, // 4, 6 ou 7 dígitos
        ));

        echo $boleto->getOutput();
//        return view('billing.index',
//            [
//                'ticket' => Ticket::selectTicketTypeR(),
//            ]
//        );
    }
}
