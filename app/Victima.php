<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Victima extends Model
{
    //
    protected $table ='victima';
    protected $primaryKey = 'idVictima';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idVictima',
        'idPersonaVictima',
        'idDomicilioVictima'
    ];
}
