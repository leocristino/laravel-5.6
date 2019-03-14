<?php

namespace App\Models;

use App\Models\Helpers\CawHelpers;
use App\Models\Helpers\CawModelUser;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class User extends CawModelUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $rememberTokenName = '';

    protected $table    =  'user';
    protected $fillable = [
        'name',
        'email',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
    public $timestamps = true;

    public static function getList(Request $request){

        $builder = User::select("user.id", "user.name", "user.email", "user.active");

        CawHelpers::addWhereLike($builder, 'name', $request['name']);

        $builder->orderBy('user.name');

        return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
    }

    /**
     * @param $email
     * @param $senha
     * @return array
     */
    public static function login($email, $password){

        $user_existing = User::query()
            ->where('email', '=', $email)
            ->first();

        if(!empty($user_existing)) {
            $user = User::query()
                ->where('email', '=', $email)
                ->where('active', '=', 1)
                ->first();

            if (!empty($user)) {
                if (Auth::attempt(['email' => $email, 'password' => $password])){
                    $all_permissions = array_merge($user->getUserPermissoesNickname()->toArray());

                    Session::put('user', $user);
                    Session::put('permissoes', $all_permissions);
                    Session::save();

                    auth()->login($user);

                    $redirect = Session::pull('last_url', '');

                    return ['result' => 'true', 'msg' => '', 'redirect' => $redirect];
                }else{
                    return ['result' => 'false', 'msg' => 'Usuário e/ou senha inválidos!'];
                }
            } else {
                return ['result' => false, 'msg' => 'Usuário não esta ativo.'];
            }
        }else{
            return ['result' => false, 'msg' => 'Usuário não cadastrado.'];
        }
    }

    public function getUserPermissoes(){
        $user_permissao = $this->hasMany(UserPermissao::class , 'id_user')->get()->pluck('id_permissao');

        return $user_permissao;
    }

    public function getUserPermissoesNickname(){
        $user_permissao = $this->select('p.nickname')
                                ->join('user_permissao as up', 'up.id_user', '=', 'user.id')
                                ->join('permissao as p', 'up.id_permissao', '=', 'p.id')
                                ->where('user.id', '=', $this->id)
                                ->get()->pluck('nickname');

        foreach ($user_permissao as $k => $v){
            $user_permissao[$k] = mb_strtoupper($v);
        }

        return $user_permissao;
    }

    public function setUserPermissoes($permissoes){
        try{
            $res = UserPermissao::where('id_user', '=', $this->id)->delete();
            if($res === false){
                return false;
            }

            foreach ($permissoes as $item){
                $res = (new UserPermissao(['id_user' => $this->id, 'id_permissao' => $item]))->save();
                if($res === false){
                    return false;
                }
            }
        }catch (QueryException $e){
            return $e;
        }
        return true;
    }

    public static function alterarSenha(Request $request){
        try{

            $senha_atual = $request['password'];
            $nova_senha = $request['new_password'];
            $confirma_senha = $request['confirm_password'];

            $userAuth = Auth::id();

            $user = User::where('id', '=', $userAuth)
                            ->where('senha', '=', $senha_atual)
                            ->where('ativo', '=', 'S')
                            ->first();

            if(isset($user)){
                if($nova_senha == $confirma_senha){

                    $user->senha = $nova_senha;
                    $res = $user->save();

                    return $res;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }catch (QueryException $e){
            return $e;
        }
    }
}