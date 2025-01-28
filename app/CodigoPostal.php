<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    //
    protected $table ='municipiocodigopostal';
    protected $primaryKey = 'codigoPostal';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable= ['codigoPostal','idMunicipio'];
}
