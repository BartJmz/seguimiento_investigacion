<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    //
    protected $table ='vehiculo';
    protected $primaryKey = 'numeroSerie';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=['marcaVehiculo','tipoVehiculo',
    'colorVehiculo','modeloVehiculo','numeroSerie','cilVehiculo','PlacaActual','fechaRegistroVehiculo','ObservacionesVehiculo'
];
}
