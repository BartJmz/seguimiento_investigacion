<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    protected $table='persona';
    protected $primaryKey = 'idPersona';
    public    $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
    'idPersona','apPat','apMat','nombrePersona','fechaNacimiento',
    'curp','rfc','alias','edadAparente','sexo','estadoCivil',
    'ocupacion','escolaridad','observaciones','imss','tipoSanguineo','lugarDeNacimiento','clavecarp'];
    protected $hidden = [
       
    ];
}
