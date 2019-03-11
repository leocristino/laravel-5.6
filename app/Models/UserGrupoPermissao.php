<?php

namespace App\Models;

use App\Models\Helpers\CawModel;

class UserGrupoPermissao extends CawModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    =  'user_grupo_permissao';
    protected $fillable = [
        'id_user_grupo',
        'id_permissao',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    public $timestamps = false;

    public function permissao(){
        return $this->hasOne(Permissao::class, 'id', 'id_permissao');
    }

    public function userGrupo(){
        return $this->hasOne(UserGrupo::class, 'id', 'id_user_grupo');
    }
}