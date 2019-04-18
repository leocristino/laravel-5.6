<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Http\Request;
use \DB;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Null_;

class Contract extends CawModel
{

    protected $table    =  'contract';
    protected $fillable = [
        'id_person',
        'id_payment_type',
        'id_bank_account',
        'due_day',
        'emergency_password',
        'contra_emergency_password',
        'start_date',
        'end_date',
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

        $builder = Contract::select('contract.*',
            'person.id as id_person',
            'person.name_social_name',
            'payment_type.id as id_payment_type',
            'payment_type.name')
            ->addSelect(DB::raw("(select SUM(contract_service.value + contract_service.addition_discount) from contract_service
            where contract_service.id_contract = contract.id) as valueContract"))
            ->addSelect(DB::raw("(select COUNT(car.id) from contract_car as car
            where car.id_contract = contract.id) as qtde_valores_car"))
            ->addSelect(DB::raw("(select COUNT(imei.id) from contract_imei as imei
            where imei.id_contract = contract.id) as qtde_valores_imei"))
            ->addSelect(DB::raw("(select COUNT(service.id) from contract_service as service
            where service.id_contract = contract.id) as qtde_valores_service"))
            ->join('person', 'person.id', '=', 'contract.id_person')
            ->join('payment_type','payment_type.id','=','contract.id_payment_type')
            ->leftJoin('contract_service', 'contract_service.id_contract','=','contract.id')
            ->addSelect(DB::raw('(CASE WHEN contract.end_date < CURDATE() THEN 0 ELSE 1 END) AS contractActive'))
            ->groupBy('contract.id');


        CawHelpers::addWhereLike($builder, 'person.name_social_name', $request['name_social_name']);

        if ($request['id_contract']){
            $builder->where('contract.id', '=', $request['id_contract']);
        }
        CawHelpers::addWhereLike($builder, 'contract.id_payment_type', $request['id_payment_type']);

        $date = date("Y-m-d");
        if ($request['end_date'] == $date)
        {
            $builder->where('contract.end_date','<', $date);
        }
        else if ($request['end_date'] == "1")
        {
            # WHERE COM OR CIRCUNDADO POR PARENTESES
            $builder->where(function ($query) {
                $query->where('contract.end_date', '=', NULL)
                    ->orWhere('contract.end_date', '>=', date('Y-m-d'));
            });
        }

        $builder->orderBy('contract.id');

        if (isset($_GET['report']) == true)
        {
            return $builder->get();
        }
        else
        {
            return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
        }

    }

    public function save(array $options = [])
    {
        if($this->id_person == "") {
            return new Exception("O campo Pessoa é obrigatório.");
        }

        if ($this->id_payment_type == "") {
            return new Exception("o campo tipo de pagamento é obrigatório.");
        }

        if ($this->due_day == "") {
            return new Exception("o campo dia de pagamento é obrigatório.");
        }

        if ($this->emergency_password == "") {
            return new Exception("o campo senha é obrigatório.");
        }

        if ($this->emergency_password == "") {
            return new Exception("o campo senha é obrigatório.");
        }

        if ($this->start_date == "") {
            return new Exception("o campo data inicial é obrigatório.");
        }

        return parent::save($options); // TODO: Change the autogenerated stub
    }

    public static function activeDisabled($id, $type)
    {
        try {
            $contract = Contract::where('contract.id', '=', $id)
                ->first();
            if($contract != null) {

                if ($type == 1) {
                    $contract->active = 0;
                } else {
                    $contract->active = 1;
                }

                $res = $contract->save();

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

    public function getCar(){
        return $this->hasMany(Car::class, 'id_contract')->get();
    }
    public function getImei(){
        return $this->hasMany(Imei::class, 'id_contract')->get();
    }

    public function getContractService(){
        return $this->hasMany(ContractService::class,'id_contract')
            ->select('contract_service.id_service', 'service.name as service','contract_service.value','contract_service.addition_discount','contract_service.id as idContractInService','service.*')
            ->join('service','service.id','=','contract_service.id_service')
            ->orderBy('service.name')
            ->get();

    }

    public static function billing($request)
    {
        $end_date = substr($request['end_date'],0,10);

        $builder = Contract::select('contract.*')
            ->addSelect(DB::raw("(select SUM(contract_service.value + contract_service.addition_discount) from contract_service
            where contract_service.id_contract = contract.id) as valueContract"))
            ->join('contract_service', 'contract_service.id_contract','=','contract.id')
            ->where('start_date','<=', $end_date );

//        # WHERE COM OR, CIRCUNDADO POR PARENTESES
        $builder->where(function ($query) use ($end_date)
        {
            $query->where('end_date', '=', NULL)
                ->orWhere('end_date', '>=',$end_date);

        });
//        dd($builder->toSql(),$builder->getBindings());
        return $builder->get();
    }


}