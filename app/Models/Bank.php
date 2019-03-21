<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use Illuminate\Http\Request;
use \DB;

class Bank extends CawModel
{

    protected $table    =  'cb_bank';
    protected $fillable = [
        'id',
        'name',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public $timestamps = true;

    public static function getSelectBank()
    {
        $builder = Bank::select('id','name')->orderBy('name')->get();

        return $builder;
    }

}