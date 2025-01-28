<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModoTipoDelito extends Model
{
    //
    protected $table ='clasificaciondelito';
    protected $primaryKey = 'idclasificaciondelito';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idclasificaciondelito',
    'descripcionclsd'
    ];

}
