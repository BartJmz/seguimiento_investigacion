<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputadoVictima extends Model
{
    //
    protected $table ='inputado_victima';
    protected $primaryKey = 'idinputado_victima';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idinputado_victima',
        'idPersona',
        'idcvedom',
        'distrito',
        'ubicacion',
        'nexos',
        'tipopersona',
        'carpetaInvestigacionPersona'
    ];
}
