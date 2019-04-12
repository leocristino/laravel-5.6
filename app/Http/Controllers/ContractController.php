<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Car;
use App\Models\ContractService;
use App\Models\Helpers\CawPDF;
use App\Models\Imei;
use App\Models\PaymentType;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Contract;
use \DB;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $payment_type = PaymentType::all();
        return view('contract.index',
            [
                'data' => Contract::getList($request),
                'params' => $request->all(),
                'payment_type' => $payment_type,
            ]
        );
    }

    public function create()
    {
        $contract = new Contract();
        $date = date("Y-m-d");
        $contract->start_date = $date;

        $person = Person::all();
        $payment_type = PaymentType::get();
        $service = Service::all();
        $contract->active = 1;
        $current_account = BankAccount::bankAccountInCurrentAccount();


//        dd($current_account);
        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
                'service' => $service,
                'current_account' => $current_account,
            ]
        );
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        $person = Person::all();
        $payment_type = PaymentType::all();
        $service = Service::all();

        $current_account = BankAccount::bankAccountInCurrentAccount();
//        dd($current_account);

        return view('contract.form',
            [
                'data' => $contract,
                'person' => $person,
                'payment_type' => $payment_type,
                'name' => Person::select('name_social_name')->where('id', '=', $contract->id_person)->first(),
                'service' => $service,
                'current_account' => $current_account,
            ]
        );

    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $contract = new Contract();
        }else {
            $contract = Contract::find($request->get('id'));
        }

        $contract->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $contract->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'contract' => $contract];
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
            $res = Contract::activeDisabled($request->id, $request->type);

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

    /**
     * @param Request $request
     * @return $this
     */
    public function pdf(Request $request)
    {
        $pdf = new CawPDF(true, 'Relatório de Contratos');

        $header = function() use ($pdf){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(10,4,'Nº');
            $pdf->Cell(40,4,'Cliente');
            $pdf->Cell(39,4,'Tipo Pagamento');
            $pdf->Cell(39,4,'Data Inicial');
            $pdf->Cell(39,4,'Data Final');
            $pdf->Cell(39,4,'Valor Contrato');
            $pdf->Ln();
            $pdf->HrLine();
        };
        $pdf->setFnHeader($header);
        $pdf->setFilters($request->toArray());

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);

        $data = Contract::getList($request, false);

        foreach ($data as $item)
        {
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(10,4, str_pad($item->id, 5, '0', STR_PAD_LEFT));
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(40,4, $item->name_social_name);
            $pdf->Cell(39,4, $item->name);
            $pdf->Cell(39,4, date("d/m/Y", strtotime($item->start_date)));
            $pdf->Cell(39,4, $item->end_date != '' ? date("d/m/Y", strtotime($item->end_date)) : '');
            $pdf->Cell(39,4, "R$ " . ($item->valueContract != '' ? $item->valueContract : '0,00'));
            $pdf->Ln();

            if ($_GET['full'] == 'yes')
            {


                #------------------------ INICIO DA PARTE DOS SERVIÇOS DO RELATÓRIO -------------------------------------
                $contract_services = ContractService::getListReport($request, $item->id);

                $pdf->Cell(190, 4, 'Serviços do Contrato:', 1, 0, 'C');
                $pdf->Ln();
                if (count($contract_services) > 0) {

                    $pdf->Cell(70, 4, 'Nome');
                    $pdf->Cell(50, 4, 'Valor');
                    $pdf->Cell(50, 4, 'Acréscimo / Desconto');
                    $pdf->Cell(50, 4, 'Total Item');
                    $pdf->Ln();
                    foreach ($contract_services as $contract_service)
                    {
                        $pdf->Cell(70, 4, $contract_service->name);
                        $pdf->Cell(50, 4, "R$ " . ($contract_service->value != '' ? number_format($contract_service->value, 2, ',', ' ') : '0,00'));
                        $pdf->Cell(50, 4, "R$ " . number_format($contract_service->addition_discount, 2, ',', '.'));
                        $pdf->Cell(50, 4, "R$ " . number_format($contract_service->value + $contract_service->addition_discount, 2, ',', '.'));
                        $pdf->Ln();
                    }
                } else {
                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
                    $pdf->Ln();

                }

                #------------------------ FIM DA PARTE DOS SERVIÇOS DO RELATÓRIO -------------------------------------
                #------------------------ PARTE DOS CARROS DO RELATÓRIO--------------------------------------
                $cars = Car::query()->where('id_contract', '=', $item->id)->get();

                $pdf->Cell(190, 4, 'Carros:', 1, 0, 'C');
                $pdf->Ln();
                if (count($cars) > 0) {

                    $pdf->Cell(38, 4, 'Modelo');
                    $pdf->Cell(38, 4, 'Placa');
                    $pdf->Cell(38, 4, 'Cor');
                    $pdf->Cell(38, 4, 'Chassi');
                    $pdf->Cell(42, 4, 'CNH Motorista');
                    $pdf->Ln();
                    foreach ($cars as $car) {
                        $pdf->Cell(38, 4, $car->model);
                        $pdf->Cell(38, 4, $car->license_plate);
                        $pdf->Cell(38, 4, $car->color);
                        $pdf->Cell(38, 4, $car->chassis);
                        $pdf->Cell(42, 4, $car->driver_license);
                        $pdf->Ln();
                    }
                } else {
                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
                    $pdf->Ln();

                }
                #------------------------ FIM DA PARTE DOS CARROS DO RELATÓRIO -------------------------------------
                #------------------------ INICIO DA PARTE DOS IMEI DO RELATÓRIO -------------------------------------
                $imeis = Imei::query()->where('id_contract', '=', $item->id)->get();


                $pdf->Cell(190, 4, 'IMEIs:', 1, 0, 'C');
                $pdf->Ln();
                if (count($imeis) > 0) {

                    $pdf->Cell(95, 4, 'Nº');
                    $pdf->Cell(95, 4, 'Descrição');
                    $pdf->Ln();

                    foreach ($imeis as $imei) {
                        $pdf->Cell(95, 4, $imei->number);
                        $pdf->Cell(95, 4, $imei->description);
                        $pdf->Ln();
                    }
                } else {
                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
                    $pdf->Ln();

                }

                #------------------------ FIM DA PARTE DOS IMEIS DO RELATÓRIO -------------------------------------


                $pdf->Ln();
            }
        }

        return response()
            ->make($pdf->Output())
            ->header('Content-Type', 'application/pdf');
    }

    public function csv(Request $request){
        $csv = '';

        $csv .= 'Nº;';
        $csv .= 'Cliente;';
        $csv .= 'Tipo Pagamento;';
        $csv .= 'Data Inicial;';
        $csv .= 'Data Final;';
        $csv .= 'Valor Contrato;';

        $csv .= chr(13);

        $data = Contract::getList($request);
//        dd($data);
        foreach ($data as $item)
        {
            $start_date = date("d/m/Y", strtotime($item->start_date));
            $end_date = $item->end_date != '' ? date("d/m/Y", strtotime($item->end_date)) : '';
            $contract_value = "R$ " . ($item->valueContract != '' ? number_format($item->valueContract, 2, ',', '.') : '0,00');
            $csv .= "\"$item->id\";";
            $csv .= "\"$item->name_social_name\";";
            $csv .= "\"$item->name\";";
            $csv .= "\"$start_date\";";
            $csv .= "\"$end_date\";";
            $csv .= "\"$contract_value\";";

            if ($_GET['full'] == 'yes')
            {
                #------------------------ INICIO DA PARTE DOS SERVIÇOS DO RELATÓRIO -------------------------------------
                $contract_services = ContractService::getListReport($request, $item->id);

                $csv .= chr(13);
                $csv .= 'Serviços do Contrato:;';
                $csv .= chr(13);

//                if (count($contract_services) > 0) {
//
//                    $pdf->Cell(70, 4, 'Nome');
//                    $pdf->Cell(50, 4, 'Valor');
//                    $pdf->Cell(50, 4, 'Acréscimo / Desconto');
//                    $pdf->Cell(50, 4, 'Total Item');
//                    $pdf->Ln();
//                    foreach ($contract_services as $contract_service)
//                    {
//                        $pdf->Cell(70, 4, $contract_service->name);
//                        $pdf->Cell(50, 4, "R$ " . ($contract_service->value != '' ? number_format($contract_service->value, 2, ',', ' ') : '0,00'));
//                        $pdf->Cell(50, 4, "R$ " . number_format($contract_service->addition_discount, 2, ',', '.'));
//                        $pdf->Cell(50, 4, "R$ " . number_format($contract_service->value + $contract_service->addition_discount, 2, ',', '.'));
//                        $pdf->Ln();
//                    }
//                } else {
//                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
//                    $pdf->Ln();
//
//                }
//
//                #------------------------ FIM DA PARTE DOS SERVIÇOS DO RELATÓRIO -------------------------------------
//                #------------------------ PARTE DOS CARROS DO RELATÓRIO--------------------------------------
//                $cars = Car::query()->where('id_contract', '=', $item->id)->get();
//
//                $pdf->Cell(190, 4, 'Carros:', 1, 0, 'C');
//                $pdf->Ln();
//                if (count($cars) > 0) {
//
//                    $pdf->Cell(38, 4, 'Modelo');
//                    $pdf->Cell(38, 4, 'Placa');
//                    $pdf->Cell(38, 4, 'Cor');
//                    $pdf->Cell(38, 4, 'Chassi');
//                    $pdf->Cell(42, 4, 'CNH Motorista');
//                    $pdf->Ln();
//                    foreach ($cars as $car) {
//                        $pdf->Cell(38, 4, $car->model);
//                        $pdf->Cell(38, 4, $car->license_plate);
//                        $pdf->Cell(38, 4, $car->color);
//                        $pdf->Cell(38, 4, $car->chassis);
//                        $pdf->Cell(42, 4, $car->driver_license);
//                        $pdf->Ln();
//                    }
//                } else {
//                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
//                    $pdf->Ln();
//
//                }
//                #------------------------ FIM DA PARTE DOS CARROS DO RELATÓRIO -------------------------------------
//                #------------------------ INICIO DA PARTE DOS IMEI DO RELATÓRIO -------------------------------------
//                $imeis = Imei::query()->where('id_contract', '=', $item->id)->get();
//
//
//                $pdf->Cell(190, 4, 'IMEIs:', 1, 0, 'C');
//                $pdf->Ln();
//                if (count($imeis) > 0) {
//
//                    $pdf->Cell(95, 4, 'Nº');
//                    $pdf->Cell(95, 4, 'Descrição');
//                    $pdf->Ln();
//
//                    foreach ($imeis as $imei) {
//                        $pdf->Cell(95, 4, $imei->number);
//                        $pdf->Cell(95, 4, $imei->description);
//                        $pdf->Ln();
//                    }
//                } else {
//                    $pdf->Cell(190, 4, 'Nenhum item cadastrado.', 0, 0, 'C');
//                    $pdf->Ln();
//
//                }
//
//                #------------------------ FIM DA PARTE DOS IMEIS DO RELATÓRIO -------------------------------------
//
//
//                $pdf->Ln();
            }

            $csv .= chr(13);
        }

        $csv = utf8_decode($csv);

        return response()
            ->make($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=rel_histórico.csv');

    }
}
