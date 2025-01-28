<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPersonal extends Model
{
    //
    protected $table ='estatus';
    protected $primaryKey = 'idEstatus';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idEstatus','nombreEstatus'
];
}
