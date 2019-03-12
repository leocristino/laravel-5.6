<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Http\Request;

class Person extends CawModel
{

    protected $table    =  'person';
    protected $fillable = [
        'type',
        'name_social_name',
        'fantasy_name',
        'cpf_cnpj',
        'rg',
        'ie',
        'date_birth',
        'email',
        'zip',
        'street',
        'district',
        'city',
        'state',
        'number',
        'complement',
        'fixed_telephone',
        'cellphone',
        'obs',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public $timestamps = true;

    public static function getList(Request $request){

        $builder = Person::select("id",
                                          "type",
                                          "name_social_name",
                                          "fantasy_name",
                                          "cpf_cnpj",
                                          "rg",
                                          "ie",
                                          "date_birth",
                                          "email",
                                          "zip",
                                          "street",
                                          "district",
                                          "city",
                                          "state",
                                          "active");

        CawHelpers::addWhereLike($builder, 'name_social_name', $request['name_social_name']);
        CawHelpers::addWhereLike($builder, 'cpf_cnpj', $request['cpf_cnpj']);

        $builder->orderBy('name_social_name');

        return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
    }
}