<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
     //
     protected $table='municipio';
     protected $primaryKey = 'idMunicipio';
     public    $timestamps = false;
     public $incrementing = false;
     
 
     protected $fillable = [
         'idMunicipio','cveMunicipio','nomMunicipio','cveEntidadM'
     ];
     
     protected $hidden = [
     ];
}
