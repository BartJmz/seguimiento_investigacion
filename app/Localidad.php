<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
     //
     protected $table='localidad';
     protected $primaryKey = 'idLocalidad';
     public    $timestamps = false;
     public $incrementing = false;
     
 
     protected $fillable = [
         'idLocalidad','cveLocalidad','nombreLocalidad','ambito',
         'latitud','longitud','cveMunicipioL'
     ];
     ///protected $guarded = ['idLocalidad'];  
     
     protected $hidden = [
     ];
}
