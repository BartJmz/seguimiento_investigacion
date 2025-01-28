<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Placa extends Model
{
    //
    protected $table='placapersonal';
    protected $primaryKey = 'idplaca';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idplaca','idplacapersonal','disponible'];
        protected $hidden = [
           
        ];
}
