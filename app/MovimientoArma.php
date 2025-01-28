<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoArma extends Model
{
    //
    protected $table ='movimientoarma';
    protected $primaryKey = 'idmovimientoarma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idmovimientoarma','descripcion'
];
}
