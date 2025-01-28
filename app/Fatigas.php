<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fatigas extends Model
{
    //
    protected $table = 'fatigas';
    protected $primaryKey= 'idfatigas';
    public $timestamps = false;
    public $incrementing = false;
 
    protected $fillable = ['idfatigas',
     'fecha_fatiga','comandancia','clavedil','hora','idresponsable'];
}
