<?php

namespace App\Models;

use App\Models\Helpers\CawModel;
use App\Models\Helpers\CawHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        'street_number',
        'complement',
        'fixed_telephone',
        'cellphone',
        'obs',
        'id_city',
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

        $builder = Person::select("person.id",
                                          "person.type",
                                          "person.name_social_name",
                                          "person.fantasy_name",
                                          "person.cpf_cnpj",
                                          "person.rg",
                                          "person.ie",
                                          "person.date_birth",
                                          "person.email",
                                          "person.zip",
                                          "person.street",
                                          "person.district",
                                          "person.complement",
                                          "person.city",
                                          "person.street_number",
                                          "person.fixed_telephone",
                                          "person.cellphone",
                                          "person.obs",
                                          "person.state",
                                          "person.active")
                                        ->addSelect(DB::raw("(select COUNT(history.id) from history
                                        where history.id_person = person.id) as count_history"))
                                        ->leftJoin('history','history.id_person','=','person.id')
                                        ->groupBy('person.id');

        CawHelpers::addWhereLike($builder, 'name_social_name', $request['name_social_name']);
        CawHelpers::addWhereLike($builder, 'cpf_cnpj', CawHelpers::removeFormatting($request['cpf_cnpj']));

        if($request['active'] != null)
        {
            $builder->where('active','=',$request['active']);
        }

        $builder->orderBy('name_social_name');

        return $builder->paginate(config('app.list_count'))->appends($request->except('page'));
    }

    public function save(array $options = [])
    {

        if($this->type == 'J')
        {
            if(!CawHelpers::isCNPJ($this->cpf_cnpj)){
                return new \Exception('CNPJ Inválido');
            }
        }
        elseif ($this->type == 'F')
        {
            if(!CawHelpers::isCPF($this->cpf_cnpj)){
                return new \Exception('CPF Inválido');
            }
        }

        $this->cpf_cnpj = CawHelpers::removeFormatting($this->cpf_cnpj);
        $this->zip = CawHelpers::removeFormatting($this->zip);
        $this->fixed_telephone = CawHelpers::removeFormatting($this->fixed_telephone);
        $this->cellphone = CawHelpers::removeFormatting($this->cellphone);

        if ($this->name_social_name == "")
        {
            return new \Exception('O campo nome é obrigatório.');
        }
        if($this->type == 'J')
        {
            if ($this->fantasy_name == "")
            {
                return new \Exception('O campo nome fantasia é obrigatório.');
            }
        }

        if ($this->email == "")
        {
            return new \Exception('O campo e-mail é obrigatório.');
        }

        return parent::save($options); // TODO: Change the autogenerated stub
    }

    public function getCpfCnpjAttribute($value)
    {
        if ($value != "")
        {
            $value = CawHelpers::removeFormatting($value);
            if (strlen($value) == 14)
            {
                return CawHelpers::mask($value, '##.###.###/####-##');
            }
            else
            {
                return CawHelpers::mask($value, '###.###.###-##');
            }
        }

        return $value;
    }

//    public function getZipAttribute($value)
//    {
//        if ($value != "")
//        {
//            return CawHelpers::mask($value, '##.###-###');
//        }
//
//    }
//    public function getFixedTelephoneAttribute($value)
//    {
//        if ($value != "")
//        {
//            return CawHelpers::mask($value, '(##)#####-####');
//        }
//    }
//
//    public function getCellphoneAttribute($value)
//    {
//        if ($value != "")
//        {
//            return CawHelpers::mask($value, '(##)#####-####');
//        }
//    }

    /**
     * @param $id_user
     * @param $type
     * @return bool
     */
    public static function activeDisabled($id_user, $type){

        try {
            $person = Person::where('id', '=', $id_user)
                ->first();
            if($person != null) {

                if ($type == 1) {
                    $person->active = 0;
                } else {
                    $person->active = 1;
                }

                $res = $person->save();

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

    public static function getSelect(){
        return Person::orderBy('name_social_name')->get();
    }

}