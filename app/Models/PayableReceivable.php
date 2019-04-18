<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use \DB;

class PayableReceivable extends CawModel
{
    use SoftDeletes;

    protected $table    =  'financial_launch';
    protected $fillable = [
        'id_person',
        'id_ticket',
        'id_payment_type',
        'id_bank_account',
        'account_type',
        'description',
        'due_date',
        'value_bill',
        'payment_date',
        'amount_paid',
        'description_bank_return',
        'chq_bank',
        'chq_agency',
        'chq_current_account',
        'chq_number',
        'chq_reason_return',
        'chq_date_return',
        'lot'

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
        $builder = PayableReceivable::select('financial_launch.*',
                                                        'person.name_social_name',
                                                        'person.active as active_person',
                                                        'person.id as person_id',
                                                        'bank_account.name as name_bank_account',
                                                        'payment_type.name as name_payment_type',
                                                        'ticket.name as name_ticket')
                            ->join('person','person.id', '=','financial_launch.id_person')
                            ->join('ticket','ticket.id','=','financial_launch.id_ticket')
                            ->join('payment_type','payment_type.id','=','financial_launch.id_payment_type')
                            ->leftJoin('bank_account','bank_account.id','=','financial_launch.id_bank_account');

        CawHelpers::addWhereLike($builder, 'person.name_social_name', $request['name_social_name']);
        CawHelpers::addWhereLike($builder, 'financial_launch.account_type', $request['account_type']);
        CawHelpers::addWhereLike($builder, 'financial_launch.lot', $request['lot']);

        $builder->orderBy('financial_launch.id');
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
        if($this->id_person == "")
        {
            return new \Exception('O campo Pessoa é obrigatório.');
        }

        if($this->id_ticket == "")
        {
            return new \Exception('O campo Plano de Contas é obrigatório.');
        }

        if($this->id_payment_type == "")
        {
            return new \Exception('O campo Forma de Pagamento é obrigatório.');
        }

        if($this->due_date == null)
        {
            return new \Exception('O campo Data de Vencimento é obrigatório.');
        }

        if($this->value_bill == 0)
        {
            return new \Exception('O campo Valor a Pagar é obrigatório.');
        }


        return parent::save($options); // TODO: Change the autogenerated stub
    }

    public function saveBilling(array $options = [])
    {
        return parent::save($options); // TODO: Change the autogenerated stub

    }

    public static function deleteLine($id)
    {

        $account_receivable = PayableReceivable::query()
            ->where('id', '=', $id)
            ->delete();

        if ($account_receivable > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function selectToBill($id, $date)
    {
        $builder = PayableReceivable::select('due_date')
            ->where('id_person','=', $id)
            ->where('due_date','=', $date);

        return $builder->get();
    }

}