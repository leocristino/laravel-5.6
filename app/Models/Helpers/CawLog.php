<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Model;

class CawLog extends Model
{
    protected $table    =  'log';
    protected $fillable = [
        'tablename', // F/J
        'id_table',
        'id_user',
        'dados',
        'data',
        'ip'
    ];

    protected $hidden = [];
    public $timestamps = false;

    /*protected static function boot()
    {
        static::addGlobalScope('softDelete', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->whereRaw('deleted_at is null');
        });
    }*/
}
