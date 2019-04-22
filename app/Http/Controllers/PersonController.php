<?php

namespace App\Http\Controllers;

use App\Models\Helpers\CawHelpers;
use App\Models\Helpers\CawPDF;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Cep;
use \DB;
use Doctrine\DBAL\Query\QueryException;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        return view('person.index',
            [
                'data' => Person::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $pessoa = new Person();

        $pessoa->active = 1;

        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
            ]
        );
    }

    public function edit($id)
    {
        $pessoa = Person::find($id);


        return view('person.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $pessoa = new Person();
        }else {
            $pessoa = Person::find($request->get('id'));
        }

        $pessoa->fill($request->toArray());
//        dd($pessoa);

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $pessoa->active = 0;
            }else{
                $pessoa->active = 1;
            }
            $res = $pessoa->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'pessoa' => $pessoa];
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
            $res = Person::activeDisabled($request->id, $request->type);

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

    public function pdf(Request $request){

        $pdf = new CawPDF(true, 'Relatório de Pessoas');

        $header = function() use ($pdf){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,4,'Nome');
            $pdf->Cell(25,4,'Tipo de Pessoa');
            $pdf->Cell(50,4,'Email');
            $pdf->Cell(25,4,'CPF / CNPJ');
            $pdf->Cell(25,4,'Telefone Fixo');
            $pdf->Cell(25,4,'Celular');
            $pdf->Ln();
            $pdf->HrLine();
        };
        $pdf->setFnHeader($header);
        $pdf->setFilters($request->toArray());

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);

        $data = Person::getList($request, false);
        foreach ($data as $item) {

            if($item->type == "F")
                $type = 'Física';
            else
                $type = 'Jurídica';

            if (strlen($item->fixed_telephone) == 10)
                $item->fixed_telephone = CawHelpers::mask($item->cellphone, '(##)####-####');
            elseif (strlen($item->fixed_telephone) == 11)
                $item->fixed_telephone = CawHelpers::mask($item->cellphone, '(##)#####-####');

            if (strlen($item->cellphone) == 10)
                $item->cellphone = CawHelpers::mask($item->cellphone, '(##)####-####');
            elseif (strlen($item->cellphone) == 11)
                $item->cellphone = CawHelpers::mask($item->cellphone, '(##)#####-####');

            $pdf->Cell(40,4, $item->name_social_name);
            $pdf->Cell(25,4, $type);
            $pdf->Cell(50,4, $item->email);
            $pdf->Cell(25,4, $item->cpf_cnpj);
            $pdf->Cell(25,4, $item->fixed_telephone);
            $pdf->Cell(25,4, $item->cellphone);
            $pdf->Ln();
        }

        return response()
            ->make($pdf->Output())
            ->header('Content-Type', 'application/pdf');
    }

    public function csv(Request $request){

        $csv = '';

        $csv .= 'Cód.;';
        $csv .= 'Nome;';
        $csv .= 'Tipo de Pessoa;';
        $csv .= 'Nome Fantasia;';
        $csv .= 'Email;';
        $csv .= 'CPF / CNPJ;';
        $csv .= 'RG;';
        $csv .= 'Inscrição Estadual;';
        $csv .= 'Data de Nascimento;';
        $csv .= 'CEP;';
        $csv .= 'Logradouro;';
        $csv .= 'Nº;';
        $csv .= 'Complemento;';
        $csv .= 'Bairro;';
        $csv .= 'Cidade;';
        $csv .= 'Estado;';
        $csv .= 'Telefone Fixo;';
        $csv .= 'Celular;';
        $csv .= 'Observação;';
        $csv .= 'Ativo;';

        $csv .= chr(13);

        $data = Person::getList($request);
        foreach ($data as $item) {
            if($item->type == "F")
                $type = 'Física';
            else
                $type = 'Jurídica';

            if($item->active == 1)
                $active = 'SIM';
            else
                $active = 'NÃO';

            if (strlen($item->cellphone) == 10)
                $item->fixed_telephone = CawHelpers::mask($item->cellphone, '(##)####-####');
            elseif (strlen($item->cellphone) == 11)
                $item->fixed_telephone = CawHelpers::mask($item->cellphone, '(##)#####-####');

            if (strlen($item->fixed_telephone) == 10)
                $item->cellphone = CawHelpers::mask($item->cellphone, '(##)####-####');
            elseif (strlen($item->cellphone) == 11)
                $item->cellphone = CawHelpers::mask($item->cellphone, '(##)#####-####');

            if ($item->zip != '')
                $zip = CawHelpers::mask($item->zip, '##.###-###');

            $csv .= "\"$item->id\";";
            $csv .= "\"$item->name_social_name\";";
            $csv .= "\"$type\";";
            $csv .= "\"$item->fantasy_name\";";
            $csv .= "\"$item->email\";";
            $csv .= "\"$item->cpf_cnpj\";";
            $csv .= "\"$item->rg\";";
            $csv .= "\"$item->ie\";";
            $csv .= "\"$item->date_birth\";";
            $csv .= "\"$zip\";";
            $csv .= "\"$item->street\";";
            $csv .= "\"$item->street_number\";";
            $csv .= "\"$item->complement\";";
            $csv .= "\"$item->district\";";
            $csv .= "\"$item->city\";";
            $csv .= "\"$item->state\";";
            $csv .= "\"$item->fixed_telephone\";";
            $csv .= "\"$item->cellphone\";";
            $csv .= "\"$item->obs\";";
            $csv .= "\"$active\";";

            $csv .= chr(13);
        }

        $csv = utf8_decode($csv);

        return response()
            ->make($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=rel_pessoas.csv');

    }
}
