<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Cep;
use \DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        return view('ticket.index',
            [
                'data' => Ticket::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $ticket = new Ticket();

        $ticket->active = 1;
        return view('ticket.form',
            [
                'data' => $ticket,
            ]
        );
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);


        return view('ticket.form',
            [
                'data' => $ticket,
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $ticket = new Ticket();
        }else {
            $ticket = Ticket::find($request->get('id'));
        }

        $ticket->fill($request->toArray());

        try {
            DB::beginTransaction();

            if($request->get('active') == null){
                $ticket->active = 0;
            }else{
                $ticket->active = 1;
            }
            $res = $ticket->save();

            if ($res === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'pessoa' => $ticket];
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
            $res = Ticket::activeDisabled($request->id, $request->type);

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
}
