<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    protected $table = 'servicios';
    protected $primaryKey= 'idServicios';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['idServicios','nombreServicio','idAreaServicio','claveser'];
    //protected $guarded = ['idServicios'];
    
}
