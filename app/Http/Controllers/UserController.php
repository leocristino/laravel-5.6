<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Models\Pessoa;
use App\Models\User;
use App\Models\UserGrupo;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('user.index',
            [
                'data' => User::getList($request),
                'params' => $request->all(),
            ]
        );
    }

    public function create()
    {
        $user = new User();
        $user['permissoes'] = [];

        $user_grupo = UserGrupo::get();
        foreach ($user_grupo as $item) {
            $item['permissoes'] = $item->getUserGrupoPermissoes();
        }
        return view('user.form',
            [
                'data' => $user,
                'user_grupo' => $user_grupo,
                'permissoes' => Permissao::orderBy("nome")->get(),
                'pessoa_vendedor' => Pessoa::getListTipoPessoa("V"),
                'pessoa_agencia' => Pessoa::getListTipoPessoa("A"),
            ]
        );
    }

    public function edit($id)
    {
        $user = User::find($id);
        $user['permissoes'] = $user->getUserPermissoes();

//        dd(Permissao::orderBy("nome")->get());

        return view('user.form',
            [
                'data' => $user,
                'permissoes' => Permissao::orderBy("nome")->get(),

            ]
        );
    }


    public function store(Request $request)
    {
        if(empty($request->get('id'))){
            $user = new User();
        }else {
            $user = User::find($request->get('id'));
        }

        $user->fill($request->toArray());

        try {
            DB::beginTransaction();

            if (empty($request->get('id'))) {
                $user->data_cad = date("Y-m-d H:i:s");
            }

            if($request->get('ativo') == null){
                $user->ativo = 'N';
            }else{
                $user->ativo = 'S';
            }

            $res = $user->save();
            $res2 = $user->setUserPermissoes($request->get('permissoes'));

            if ($res === true && $res2 === true) {
                DB::commit();
                return ['result' => 'true', 'msg' => ''];
            } else {
                DB::rollBack();
                return ['result' => 'false', 'msg' => ($res !== true) ? $res->getMessage() : $res2->getMessage()];
            }
        }catch (QueryException $e){
            DB::rollBack();
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }

    public function indexPassword(){

        $auth = Auth::user();

        if($auth == null) {
            return redirect('/');
        }

        return view('password.form');
    }

    public function alterarSenha(Request $request){

        try {
            $senha = User::alterarSenha($request);

            if($senha == true) {
                return ['result' => 'true', 'msg' => ''];
            }else{
                return ['result' => 'false', 'msg' => 'Senhas incorretas.'];
            }

        }catch (QueryException $e){
            return ['result' => 'false', 'msg' => $e->getMessage()];
        }
    }
}
