<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adscripcion extends Model
{
    //Modelo adscripcion -> Tabla adscripcion en la BD.
    protected $table='adscripcion';
    protected $primaryKey = 'idAdscripcion';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idAdscripcion','idPersonalAEIAds','idComandanciaAds','fechaMovimiento','vigente','encargado','observaciones','idMovimeintoPersonalAEI','fechaIngreso','placa_uso','estatus'
    ];
        protected $hidden = [
           
        ];
}
