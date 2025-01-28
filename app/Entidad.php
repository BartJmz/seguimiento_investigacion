<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
     //
     protected $table='entidad';
     protected $primaryKey = 'idEntidad';
     public    $timestamps = false;
     public $incrementing = false;
     
 
     protected $fillable = [
         'cveEntidad','nombreEntidad'
     ];
     protected $guarded = ['idEntidad'];  
     
     protected $hidden = [
     ];
}
