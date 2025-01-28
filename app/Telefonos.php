<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefonos extends Model
{
    //
     protected $table = 'telefono';
     protected $primaryKey= 'idTelefono';
     public $timestamps = false;
     public $incrementing = false;
 
     protected $fillable = ['idTelefono',
     'numeroTel','fechaInformacion','tipo',
     'idPersonaTel','status'];
     //protected $guarded = ['idServicios'];
     
}
