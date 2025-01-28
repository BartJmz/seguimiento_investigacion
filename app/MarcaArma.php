<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarcaArma extends Model
{
    //
    protected $table ='marcaarma';
    protected $primaryKey = 'idMarcaArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idMarcaArma','marca'
];
}
