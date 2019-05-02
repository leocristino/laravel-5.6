<?php

namespace App\Http\Controllers;

use App\Models\Helpers\CawHelpers;
use App\Models\PayableReceivable;
use DateTime;
use Illuminate\Http\Request;
use Eduardokum\LaravelBoleto as boleto;


class SendingController extends Controller
{
    public static function sendingFile($lot, $id_bank_account)
    {

        $payable_receivables = PayableReceivable::selectedSendForEmail($lot, $id_bank_account);
//        dd($payable_receivables[0]);
        $beneficiario = new boleto\Pessoa(
            [
                'nome'      => $payable_receivables[0]['name_company'],
                'endereco'  => $payable_receivables[0]['address_company'] . ', ' . $payable_receivables[0]['number_company'],
                'cep'       => $payable_receivables[0]['zip_company'],
                'uf'        => $payable_receivables[0]['state_company'],
                'cidade'    => $payable_receivables[0]['city_company'],
                'bairro'    => $payable_receivables[0]['district_company'],
                'documento' => $payable_receivables[0]['cpf_cnpj_company'],
            ]
        );
//        dd($beneficiario);

        $send = new boleto\Cnab\Remessa\Cnab240\Banco\Bancoob(
            [
                'agencia' => $payable_receivables[0]['agency_company'],
                'conta' => $payable_receivables[0]['account_current_company'],
                'carteira' => $payable_receivables[0]['wallet'],
                'convenio' => $payable_receivables[0]['pact_company'],
                'beneficiario' => $beneficiario,
                'idremessa' => $payable_receivables[0]['lot'],
            ]
        );
//        dd($beneficiario);
        foreach ($payable_receivables as $payable_receivable)
        {
            $pagador = new boleto\Pessoa([
                'nome' => $payable_receivable['name_social_name'],
                'endereco' => $payable_receivable['street_person'] . ', ' . $payable_receivable['street_number_person'],
                'bairro' => $payable_receivable['district_person'],
                'cep' => CawHelpers::mask($payable_receivable['zip_person'],'##.###-###'),
                'uf' => $payable_receivable['state_person'],
                'cidade' => $payable_receivable['city_person'],
                'documento' => $payable_receivable['cpf_cnpj_person'],]
            );

//            dd($pagador);

            $boleto[] = new boleto\Boleto\Banco\Bancoob([
                'logo' => realpath(__DIR__ . '/../logos/') . DIRECTORY_SEPARATOR . '756.png',
                'dataVencimento' => new \Carbon\Carbon($payable_receivable['due_date']),
                'valor' => number_format($payable_receivable['value_bill'],2),
                'multa' => false,
                'juros' => false,
                'numero' => str_pad($payable_receivable['id'], 15, '0', STR_PAD_LEFT),
                'numeroDocumento' => str_pad($payable_receivable['id'], 15, '0', STR_PAD_LEFT),
                'pagador' => $pagador,
                'beneficiario' => $beneficiario,
                'carteira' => $payable_receivable['wallet'],
                'agencia' => $payable_receivable['agency_company'],
                'conta' => $payable_receivable['account_current_company'],
                'convenio' => $payable_receivable['account_current_company'],
                'descricaoDemonstrativo' => [
                    'demonstrativo 1',
                    'demonstrativo 2',
                    'demonstrativo 3'
                ],

                'instrucoes' => [
                        'instrucao 1',
                        'instrucao 2',
                        'instrucao 3'],
                    'aceite' => 'S',
                    'especieDoc' => 'DM',
                ]);


//            dd($boleto[0]);
            // Add multiples bill to a send object. Here need a array of instances of Boleto.
            $send->addBoletos($boleto);

        }
        $send->download($filename = null);
    }

}
