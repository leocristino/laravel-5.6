<?php

namespace App\Http\Controllers;

use App\Models\CbGeralInstituicao;
use App\Models\CbGeralTipoPessoa;
use App\Models\Cep;
use App\Models\Helpers\CawHelpers;
use App\Models\Pessoa;
use App\Models\PersonTypePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;
use PhpParser\Builder;

class PessoaController extends Controller
{
    public function index(Request $request)
    {
        return view('pessoa.index',
            [
                'data' => Pessoa::getList($request),
                'params' => $request->all()
            ]
        );
    }

    public function create()
    {
        $pessoa = new Pessoa();
        $pessoa->tipo = 'F';
        $pessoa->active = 'S';
        $pessoa['pessoa_tipo_pessoa'] = [];
        return view('pessoa.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
                'cb_geral_tipo_pessoa' => CbGeralTipoPessoa::get(),
                'cb_geral_instituicao' => null
            ]
        );
    }

    public function edit($id)
    {
        $pessoa = Pessoa::find($id);
        $pessoa['pessoa_tipo_pessoa'] = $pessoa->getTipoPessoa();
        return view('pessoa.form',
            [
                'data' => $pessoa,
                'uf' => Cep::listaUFs(),
                'cb_geral_tipo_pessoa' => CbGeralTipoPessoa::get(),
                'cb_geral_instituicao' => CbGeralInstituicao::find($pessoa->id_cb_geral_instituicao)
            ]
        );
    }

    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $pessoa = new Pessoa();
        }else {
            $pessoa = Pessoa::find($request->get('id'));
        }

        $pessoa->fill($request->toArray());

        try {
            DB::beginTransaction();

            $res = $pessoa->save();
            $res2 = $pessoa->setTipoPessoa($request->get('pessoa_tipo_pessoa'));

            if ($res === true && $res2 === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => '', 'pessoa' => $pessoa];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : $res2->getMessage()];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }

    public function listPessoa(Request $request){

        $builder = Pessoa::select(["pessoa.id", "pessoa.nome", "pessoa.cpf_cnpj", "pessoa.rg_ie", "pessoa.telefone1"])
            ->distinct()
            ->join("pessoa_tipo_pessoa as ptp", "ptp.id_pessoa", "=", "pessoa.id")
            ->join("cb_geral_tipo_pessoa as cb_tp", "cb_tp.id", "=", "ptp.id_cb_geral_tipo_pessoa");

        if(!empty($request->get('query'))) {
            $q2 = CawHelpers::removeFormatting($request->get('query'));

            //se existirem apenas números na pesquisa, pesquisa apenas pelo inicio do cpf e rg
            if(!empty($q2)){
                $builder = $builder->orWhereRaw("(REPLACE(REPLACE(pessoa.cpf_cnpj, '.', ''), '-', '') like '".$q2."%'
                                    or REPLACE(REPLACE(pessoa.rg_ie, '.', ''), '-', '') like '".$q2."%')"
                );
            }else{
                CawHelpers::addOrWhereLike($builder, "pessoa.nome", $request->get('query'));
            }
        }

        if(!empty($request->get('tipo_pessoa'))){
            $builder = $builder->where("cb_tp.tipo", "like", $request['tipo_pessoa']);
        }

        $builder = $builder->orderBy("pessoa.nome")->limit(50)->get();



        return $builder;

    }

}
