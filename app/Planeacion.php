<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planeacion extends Model
{
    //
    protected $table='planeacion';
    protected $primaryKey = 'idplaneacion';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idplaneacion',
        'idCarpetaInvDiligenciaPlaneacion',
        'idDiligenciasCarpP',
        'cantidadPlaneacion',
        'estatus',
        'rol_victima'];
        protected $hidden = [
           
        ];
}
