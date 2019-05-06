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

        foreach ($payable_receivables as $payable_receivable)
        {
//            dd($payable_receivable['id_bank']);
            if ($payable_receivable['id_bank'] == 756)
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


            $boleto[] = new boleto\Boleto\Banco\Bancoob([
                'logo' => realpath(__DIR__ . '/../logos/') . DIRECTORY_SEPARATOR . '756.png',
                'dataVencimento' => new \Carbon\Carbon($payable_receivable['due_date']),
                'valor' => number_format($payable_receivable['value_bill'],2),
                'multa' => 2.00,
                'juros' => 0.33,
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
                    'instrucao 1' => $payable_receivable['instruction'],
                    'instrucao 2',
                    'instrucao 3'],
                    'aceite' => 'S',
                    'especieDoc' => 'DM',
                ]);

                $send = new boleto\Cnab\Remessa\Cnab240\Banco\Bancoob(
                    [
                        'agencia' => $payable_receivable['agency_company'],
                        'conta' => $payable_receivable['account_current_company'],
                        'carteira' => $payable_receivable['wallet'],
                        'convenio' => $payable_receivable['pact_company'],
                        'beneficiario' => $beneficiario,
                        'idremessa' => $payable_receivable['lot'],
                    ]
                );
//                dd($send);

                // Add multiples bill to a send object. Here need a array of instances of Boleto.
//                $send->addBoletos($boleto);

            }
            elseif ($payable_receivable['id_bank'] == 1)
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

                $boleto[] = new boleto\Boleto\Banco\Bb(
                    [
                        'logo'                   => realpath(__DIR__ . '/../logos/') . DIRECTORY_SEPARATOR . '001.png',
                        'dataVencimento' => new \Carbon\Carbon($payable_receivable['due_date']),
                        'valor' => number_format($payable_receivable['value_bill'],2),
                        'multa' => 2.00,
                        'juros' => 0.33,
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
                            'instrucao 1' => $payable_receivable['instruction'],
                            'instrucao 2',
                            'instrucao 3'],
                        'aceite' => 'S',
                        'especieDoc' => 'DM',
                    ]
                );
                $send = new boleto\Cnab\Remessa\Cnab240\Banco\Bb(
                    [
                        'agencia'      => $payable_receivable['agency_company'],
                        'carteira'     => $payable_receivable['wallet'],
                        'conta'        => $payable_receivable['account_current_company'],
                        'convenio'     => $payable_receivable['pact'],
                        'beneficiario' => $beneficiario,
                        'convenioLider' => 1,
                        'variacaoCarteira' => 1



                    ]
                );
            }

            $send->addBoletos($boleto);




        }
        $banco = $payable_receivables[0]['id_bank'] == 1 ? 'BB' : 'Sicoob';
//        dd($banco);
        $filename = 'remessa' . $payable_receivables[0]['lot'] . $banco . '.txt';
        $send->download($filename);
    }

}
