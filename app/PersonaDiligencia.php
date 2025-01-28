<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaDiligencia extends Model
{
    //
    protected $table ='persona_diligencia';
    protected $primaryKey = 'idPersonaDiligencia';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idPersonaDiligencia',
        'nombrePersonaDiligencia',
        'apPatDiligencia',
        'apMatDiligencia',
        'fechaNacimientoDiligencia',
        'curpDiligencia',
        'estadoCivilDiligencia',
        'escolaridadDiligencia',
        'ocupacionDiligencia',
        'sexoDiligencia',
        'edadAparenteDiligencia',
        'idioma',
        'lugarDeNacimiento',
        'rolentrevistado',
        'marcas_visibles',
        'aliasDiligencia',
        'telefonoDiligenciaPersona',
        'documentacionOficialEntrevistado',
        'parentescoPersonaDiligencia',
        'relatoentrevista',
        'observaciones_entre',
        'carpetainv'
    ];
}
