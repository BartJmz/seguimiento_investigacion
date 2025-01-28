<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    //
    protected $table='domicilio';
    protected $primaryKey = 'idDomicilio';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = [
        'codigoPostal','colonia','nInterior',
        'nExterior','latitud','longitud',
        'calle','referenciaDelLugar','localidadDomicilio',
        'cve'
    ];
    protected $guarded = ['idDomicilio'];  
    
    protected $hidden = [
    ];
}
