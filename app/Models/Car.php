<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Http\Request;
use \DB;
use Mockery\Exception;

class Car extends CawModel
{

    protected $table    =  'car';
    protected $fillable = [
        'license_plate',
        'model',
        'color',
        'chassis',
        'driver_license',
        'active',
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

        $builder = Car::select('imei.*');

        CawHelpers::addWhereLike($builder, 'model', $request['model']);

        if ($request['active'] != ""){
            $builder->where('active','=',$request['active']);
        }

        $builder->orderBy('car.model');
        return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
    }

    public function save(array $options = [])
    {
//        if($this->number == "")
//        {
//            return new Exception("O campo imei é obrigatório.");
//        }
//
//        if($this->description == "")
//        {
//            return new Exception("O campo descrição é obrigatório.");
//        }

        return parent::save($options); // TODO: Change the autogenerated stub
    }

    public static function activeDisabled($id, $type){

        try {
            $car = Car::where('id', '=', $id)
                ->first();
            if($car != null) {

                if ($type == 1) {
                    $car->active = 0;
                } else {
                    $car->active = 1;
                }

                $res = $car->save();

                if($res === true){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }catch (QueryException $e){
            return false;
        }
    }
}