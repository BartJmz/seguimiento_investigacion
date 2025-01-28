<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarpetaDeIvPersonal extends Model
{
    //
    protected $table ='carpetainvpersonal';
    protected $primaryKey = 'idcarpetainvpersonal';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idcarpetainvpersonal','idcarpetainv','idpersonalaeicarpeta','responsable','fecha_asig_system','fecha_termino','ecargado_vigente','notificar'
    //Agremamos los campos
    ];
}
