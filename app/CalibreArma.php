<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalibreArma extends Model
{
    //
    protected $table ='calibrearma';
    protected $primaryKey = 'idCalibre';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idArma','calibre'
];
    //protected $guarded=['idArea'];
}
