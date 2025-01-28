<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantillaVehiculo extends Model
{
    //
    protected $table ='plantillavehiculo';
    protected $primaryKey = 'idplantillaVehiculo';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idplantillaVehiculo','idVehiculoAsignado','idAsignacionComandancia',
    'fechaAsignacion','tipoAsignacion','ObservacionAsignacion','fecha_baja_cambio','estatus'
];
}
