<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoFisicoArma extends Model
{
    //
    protected $table ='estadofisicoarma';
    protected $primaryKey = 'idEstadoFisicoArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idEstadoFisicoArma','estodofisico'
];
}
