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
        $beneficiario = new boleto\Pessoa(
            [
                'nome'      => $payable_receivables[0]['name_company'],
                'endereco'  => $payable_receivables[0]['address_company'] . ', ' . $payable_receivables[0]['number_company'],
                'cep'       => $payable_receivables[0]['zip_company'],
                'uf'        => $payable_receivables[0]['state_company'],
                'cidade'    => $payable_receivables[0]['city_company'],
                'bairro'    => $payable_receivables[0]['district_company'],
                'documento' => '99.999.999/9999-99',
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
                'uf' => $payable_receivable['district_person'],
                'cidade' => $payable_receivable['city_person'],
                'documento' => $payable_receivable['cpf_cnpj_person'],]);

            $boleto[] = new boleto\Boleto\Banco\Bancoob([
                'logo' => realpath(__DIR__ . '/../logos/') . DIRECTORY_SEPARATOR . '756.png',
                'dataVencimento' => new \Carbon\Carbon(),
                'valor' => 100,
                'multa' => false,
                'juros' => false,
                'numero' => 1,
                'numeroDocumento' => 1,
                'pagador' => $pagador,
                'beneficiario' => $beneficiario,
                'carteira' => 1,
                'agencia' => 1111,
                'conta' => 22222,
                'convenio' => 123123,
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

            $send = new boleto\Cnab\Remessa\Cnab240\Banco\Bancoob([
                'agencia' => 1111,
                'conta' => 22222,
                'carteira' => 1,
                'convenio' => 123123,
                'beneficiario' => $beneficiario,]);

            // Add multiples bill to a send object. Here need a array of instances of Boleto.
            $send->addBoletos($boleto);

        }
        $send->download($filename = null);
    }

}
