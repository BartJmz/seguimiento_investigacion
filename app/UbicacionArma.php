<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbicacionArma extends Model
{
    //
    protected $table ='ubicacionarma';
    protected $primaryKey = 'idubicacionArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idubicacionArma','idMunicipioArma','nombreLocalidadArma','idArmaUbicacion'];
}
