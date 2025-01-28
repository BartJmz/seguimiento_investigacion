<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NombramientoPlacaPersonal extends Model
{
    //
    protected $table='nombramientoplacapersonal';
    protected $primaryKey = 'idNombramientoPersonal';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idNombramientoPersonal','fechaNombramiento','idPersonalAEINom','idNombramientoDisponibleNom','estatus'];
        protected $hidden = [
           
        ];
}
