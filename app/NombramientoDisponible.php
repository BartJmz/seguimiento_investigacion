<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NombramientoDisponible extends Model
{
    //
    protected $table='nombramientodisponible';
    protected $primaryKey = 'idNombramientoDisponible';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idNombramientoDisponible','placa','idCargoNom'];
        protected $hidden = [
           
        ];
}
