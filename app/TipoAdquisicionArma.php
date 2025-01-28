<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAdquisicionArma extends Model
{
    //
    protected $table ='tipoadquisicionarma';
    protected $primaryKey = 'idtipoadquisicion';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idtipoadquisicion','tipoadquisicion'
    ];
}
