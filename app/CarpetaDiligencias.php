<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarpetaDiligencias extends Model
{
    //
    protected $table='carpetadiligencias';
    protected $primaryKey = 'idcarpetadiligencias';
    //protected $foreingKey = 'personaID';
    public    $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['idcarpetadiligencias','idCarpetaInvDiligencia','idDiligenciasCarp','estatus','cantidad'];
    protected $hidden = [];
}
