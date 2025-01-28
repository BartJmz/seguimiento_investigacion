<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaneacionDes extends Model
{
    //
    protected $table='planeacion_des';
    protected $primaryKey = 'idplaneacion_des';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idplaneacion_des',
        'descripcion'];
        protected $hidden = [
           
        ];
}
