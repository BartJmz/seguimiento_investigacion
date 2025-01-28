<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomicilioPersona extends Model
{
    //
    protected $table='domiciliopersona';
    protected $primaryKey = 'idD';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = ['idD','FechaInformacion',
    'Tipo','Fuente','Observaciones','idDomicilioPersonasD','idPersonaD'];
    protected $hidden = [];
}
