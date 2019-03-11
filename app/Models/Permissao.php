<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Permissao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    =  'permissao';
    protected $fillable = [
        'nome',
        'nickname',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    public $timestamps = false;

    //$permissao_nickname = string ou array
    public static function userHasPermissao($permissao_nickname){

        if(empty(session('permissoes'))){
            return false;
        }

        if(is_array($permissao_nickname)){
            foreach ($permissao_nickname as $item) {
                if(in_array(strtoupper($item), session('permissoes'))){
                    return true;
                }
            }
        }else{
            if(in_array(strtoupper($permissao_nickname), session('permissoes'))){
                return true;
            }
        }

        return false;
    }

}