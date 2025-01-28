<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioPersonal extends Model
{
    //
    protected $table = 'serviciopersonalaei';
    protected $primaryKey= 'idservicioPersonal';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['idservicioPersonal','idComanciaServicioFK','idPersonalAEIFK'];
}
