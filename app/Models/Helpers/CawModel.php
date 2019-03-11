<?php
/**
 * Created by PhpStorm.
 * User: Valerio
 * Date: 14/05/2018
 * Time: 14:19
 */

namespace App\Models\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CawModel extends Model
{

    //caso não queira manter o log, informar false!
    protected $log = true;

    public function __construct(array $attributes = [])
    {

        parent::__construct($attributes);

        if(empty($attributes)) {
            //inicializa todos os atrubutos como null
            foreach ($this->fillable as $item) {
                $this->setAttribute($item, null);
            }
        }
    }

    public function save(array $options = [])
    {
        //se não for pra fazer o log
        if(isset($this->log) && $this->log == false){
            return parent::save($options);
        }

        //faz o log do que entrou de diferenças no cadastro
        $exists = $this->exists;
        $original = $this->getOriginal();

        //tenta salvar o registro
        $res = parent::save($options);
        if($res === false){
            return false;
        }

        //se for update
        if($exists == true) {
            $diff = array_diff_assoc($this->getAttributes(), $original);

            unset($diff['updated_at']);

            if (empty($diff)) {
                return true;
            }
        }else{
            //se for insert
            $diff = $this->getAttributes();
        }

        try {
            $log = new CawLog();
            $log->tablename = $this->table;
            $log->id_table = $this->getOriginal($this->primaryKey);
            $log->id_user = session('user')->id;
            $log->dados = json_encode($diff);
            $log->data = date('Y-m-d H:i:s');
            $log->ip = \request()->ip();
            $log->save();
        }catch (\Exception $e){
            error_log(date('d/m/Y : H:i:s')." - Erro ao inserir no log - [".$e->getMessage()."] [".$e->getFile()."] [".$e->getLine()."]");
        }
        return true;
    }

    public function delete()
    {
        //se não for pra fazer o log
        if(isset($this->log) && $this->log == false){
            return parent::delete();
        }

        //faz o log do que entrou de diferenças no cadastro
        try {
            DB::beginTransaction();

            //tenta excluir o registro
            $res = parent::delete();
            if($res === false){
                DB::rollBack();
                return false;
            }

            $log = new CawLog();
            $log->tablename = $this->table;
            $log->id_table = $this->getOriginal($this->primaryKey);
            $log->id_user = session('user')->id;
            $log->dados = json_encode(array('deleted_at' => date('Y-m-d H:i:s')));
            $log->data = date('Y-m-d H:i:s');
            $log->save();

            DB::commit();

            return true;
        }catch (\Exception $e){
            DB::rollBack();
            return $e;
        }
    }


}