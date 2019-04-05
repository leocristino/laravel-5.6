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
}