<?php

namespace App\Http\Controllers;

use App\Models\Helpers\CawPDF;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\History;
use \DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        return view('history.index',
            [
                'data' => History::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $history = new History();
        $person = Person::getSelect();
        $currentUser = auth()->user()->id;
        $user = new User();

        return view('history.form',
            [
                'data' => $history,
                'person' => $person,
                'currentUser' => $currentUser,
                'responsible' => $user,
            ]
        );
    }

    public function edit($id)
    {
        $history = History::find($id);
        $user = User::find($history->responsible);
        $person = Person::all();
        $history->contact_time = date("Y-m-d", strtotime($history->contact_time));
        $currentUser = auth()->user()->id;

        return view('history.form',
            [
                'data' => $history,
                'person' => $person,
                'responsible' => $user,
                'currentUser' => $currentUser,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $history = new History();
            $history->responsible = auth()->user()->id;
        }else {
            $history = History::find($request->get('id'));
        }

        $history->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $history->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'history' => $history];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : ""];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }

    public function pdf(Request $request){

        $pdf = new CawPDF(true, 'Relatório do Histórico de Pessoas');

        $header = function() use ($pdf){
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,4,'Cliente');
            $pdf->Cell(28,4,'Criado em');
            $pdf->Cell(28,4,'Data do Contato');
            $pdf->Cell(95,4,'Observação');
            $pdf->Ln();
            $pdf->HrLine();
        };
        $pdf->setFnHeader($header);
        $filters = [
            'Cliente' =>utf8_encode($request['name_social_name']),
            'Data Contato Inicial' => !empty($request['bigger_than']) ? date('d/m/Y', strtotime($request['bigger_than'])) : '',
            'Data Contato Final' => !empty($request['less_than']) ? date('d/m/Y', strtotime($request['less_than'])) : '',
        ];
        $pdf->setFilters($filters);

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);

        $data = History::getList($request, false);
        foreach ($data as $item) {
            $contact_time = date('d/m/Y', strtotime($item->contact_time));
            $contact_time = $contact_time . " " . $item->contact_time_hour;

            $pdf->Cell(40,4, $item->name_social_name);
            $pdf->Cell(28,4, $item->created_at);
            $pdf->Cell(28,4, $contact_time);
            $pdf->MultiCell(95,4, utf8_encode($item->description));
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
        $csv .= 'Criado em;';
        $csv .= 'Data do Contato;';
        $csv .= 'Observação;';

        $csv .= chr(13);

        $data = History::getList($request);
        foreach ($data as $item) {
            $contact_time = date('d/m/Y', strtotime($item->contact_time));
            $contact_time = $contact_time . " " . $item->contact_time_hour;
            $csv .= "\"$item->id\";";
            $csv .= "\"$item->name_social_name\";";
            $csv .= "\"$item->created_at\";";
            $csv .= "\"$contact_time\";";
            $csv .= "\"$item->description\";";

            $csv .= chr(13);
        }

        $csv = utf8_decode($csv);

        return response()
            ->make($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=rel_histórico.csv');

    }
}
