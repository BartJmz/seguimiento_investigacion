<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hechos extends Model
{
    //
    protected $table ='hechos';
    protected $primaryKey = 'idhechos';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idhechos','fecha','idregionhechos','distrito','idmunicipio','agencia','colonia','calle','numero','descripcion','ubicacion','referencia','carpetainv'
];
}
