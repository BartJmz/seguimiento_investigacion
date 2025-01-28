<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaseArma extends Model
{
    //
    protected $table ='clasearma';
    protected $primaryKey = 'idClaseArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=['idClaseArma','claseArma'];
}
