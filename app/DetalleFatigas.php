<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFatigas extends Model
{
    //
    protected $table = 'detallefatigas';
    protected $primaryKey= 'iddetallefatigast';
    public $timestamps = false;
    public $incrementing = false;
 
    protected $fillable = ['iddetallefatigast','iddetallefatigas',
     'personaID','estado','area','servicio'];
}
