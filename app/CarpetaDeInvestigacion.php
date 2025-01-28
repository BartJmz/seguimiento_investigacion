<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarpetaDeInvestigacion extends Model
{
    //
    protected $table ='carpetadeinvestigacion';
    protected $primaryKey = 'idCarpetaInvestigacion';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idCarpetaInvestigacion','CarpetaInvestigacion','FechaHoraInicio','FechaHoraConsignacion','Estatus','Observaciones','tipoDelito','tipomodoDelito','comandaciacapinv'
];
}
