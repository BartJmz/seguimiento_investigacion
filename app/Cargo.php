<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    protected $table='cargos';
    protected $primaryKey = 'idCargo';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idCargo','Descripcion'];
        protected $hidden = [
           
        ];
}
