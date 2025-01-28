<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //
    protected $table='movimientopersonal';
    protected $primaryKey = 'idMovimientoPersonal';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idMovimientoPersonal','movimiento'
       
    ];
        protected $hidden = [
           
        ];
}
