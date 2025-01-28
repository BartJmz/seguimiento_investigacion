<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalAEI extends Model
{
    //
    protected $table='personalaei';
    protected $primaryKey = 'idPersonalAEI';
    //protected $foreingKey = 'personaID';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = ['personaID','operativo','cuip',
    'viaIngreso','cartillaSmn','emailAEI'];
    protected $hidden = [
       
    ];
}
