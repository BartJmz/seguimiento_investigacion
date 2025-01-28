<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaDLT extends Model
{
    //Modelo base diligencias.
    protected $table ='actadlt';
    protected $primaryKey = 'idActaDLT';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idActaDLT','carpeta','dependencia','idMunicipio','idLocalidad','idrespondable','fechadecreacion','cve','tipoDiligencia'
    ];
}
