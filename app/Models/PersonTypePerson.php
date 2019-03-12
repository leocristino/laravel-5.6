<?php

namespace App\Models;

use App\Models\Helpers\CawModel;

class PersonTypePerson extends CawModel
{
    protected $table    =  'person_type_person';
    protected $fillable = [
        'id_pessoa',
        'id_cb_geral_tipo_pessoa',
    ];
    protected $primaryKey = [
        'id_pessoa',
        'id_cb_geral_tipo_pessoa',
    ];
    public $incrementing = false;

    protected $hidden = [];
    protected $log = false;
    public $timestamps = false;
}