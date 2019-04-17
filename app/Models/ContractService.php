<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Http\Request;
use \DB;
use Mockery\Exception;

class ContractService extends CawModel
{

    protected $table    =  'contract_service';
    protected $fillable = [
        'id_contract',
        'id_service',
        'value',
        'addition_discount',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public $timestamps = true;

    public static function getList(Request $request)
    {
        $builder = ContractService::select('contract_service.*','service.*','contract.*')
                    ->join('service','id','=','id_service')
                    ->join('contract','id','=','1');


        $builder->orderBy('service.name');
        return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
    }



    public static function updateArray($id_contract, $itens)
    {
        try {
            DB::beginTransaction();
            foreach ($itens as $item) {
                $verificador = isset($item['active']) ? false : true;

                //adicionando valores
                if (empty($item['id_contract']) && $verificador === true)
                {

                    if (empty($item['id_contract']))
                        $item['id_contract'] = $id_contract;

                    $contract_service = new ContractService();
                    $contract_service->id_contract = $id_contract;
                    $contract_service->id_service = $item['id_service'];
                    $contract_service->value = $item['value'];
                    $contract_service->addition_discount = $item['addition_discount'];
                    $contract_service->save();
                }
                //excluindo valores
                else if (!empty($id_contract)&& $item['active'] === false || $item['active'] != 1)
                {
                    ContractService::where('id',$item['idContractInService'])->delete();
                }

            }
            DB::commit();
            return true;

        }catch (\Exception $e){
            DB::rollBack();
            return $e;
        }
    }

    public static function getSelect(){
        return Car::where('active','=',1)->get();
    }

    public static function getListReport($request)
    {
        $builder = ContractService::select('*')
            ->leftJoin('contract','contract.id','=','contract_service.id_contract')
            ->leftJoin('service','service.id','=','contract_service.id_service')
            ->join('person','person.id','=','contract.id_person');

        CawHelpers::addWhereLike($builder, 'name_social_name', $request['name_social_name']);
        CawHelpers::addWhereLike($builder, 'id_payment_type', $request['id_payment_type']);

        if ($request['id_contract'])
        {
            $builder->where('contract.id', '=', $request['id_contract']);
        }

        if ($request['end_date'] == '1')
        {
            $builder->where(function ($query) {
            $query->where('contract.end_date', '=', NULL)
                ->orWhere('contract.end_date', '>=', date('Y-m-d'));
            });
        }
        elseif($request['end_date'] != '')
        {
            $builder->where('contract.end_date','<', $request['end_date']);
        }


        $builder->orderBy('contract.id');
        return $builder->get();
    }

    public static function getListReportPDF(Request $request, $id)
    {
        $builder = ContractService::select('contract_service.*','service.*')
            ->leftJoin('service','service.id','=','contract_service.id_service')
            ->where('contract_service.id_contract','=',$id);


        $builder->orderBy('contract_service.id_contract');
        return $builder->get();
    }
}