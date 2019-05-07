<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Models\Pessoa;
use App\Models\User;
use App\Models\UserGrupo;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

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
        $user->active = 1;
        $user['permissoes'] = [];

        return view('user.form',
            [
                'data' => $user,
                'permissoes' => Permissao::orderBy("nome")->get()
            ]
        );
    }

    public function edit($id)
    {
        $user = User::find($id);
        $user['permissoes'] = $user->getUserPermissoes()->toArray();

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

            if($request->get('active') == null){
                $user->active = 0;
            }else{
                $user->active = 1;
            }

            if (!empty($request->input('password'))) {
                $senha = $request->input('password');
                $user->password = bcrypt($senha);
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

    public function activeDisabled(Request $request)
    {
        try {
            $res = User::activeDisabled($request->id, $request->type);

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
