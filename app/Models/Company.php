<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use Illuminate\Http\Request;
use \DB;

class Company extends CawModel
{

    protected $table    =  'company';
    protected $fillable = [
        'name',
        'cpf_cnpj',
        'street',
        'street_number',
        'state',
        'email',
        'zip',
        'district',
        'city',
        'complement',
        'fixed_telephone',
        'cellphone',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public $timestamps = true;


}