<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    //
    protected $table='permisos';
    protected $primaryKey = 'idpermisos';
    public    $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
    'idpermisos','folio','fechaInicial','fechaTermino',
    'motivos','canDias','idPersonalPermiso','estatus'];
    protected $hidden = [
       
    ];
}
