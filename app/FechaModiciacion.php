<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaModiciacion extends Model
{
    //
    protected $table='fechacambioads';
    protected $primaryKey = 'idfechacambiaoads';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = [
        'fecha_modificacion','idAdscripcionMov','descripcion'
    ];
    protected $guarded = [''];  
    
    protected $hidden = [
    ];
}
