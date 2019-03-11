<?php

namespace App\Models;

use App\Models\Helpers\CawModel;

class UserPermissao extends CawModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    =  'user_permissao';
    protected $fillable = [
        'id_user',
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
        return $this->hasOne(Permissao::class, 'id_permissao');
    }
}