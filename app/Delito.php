<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delito extends Model
{
    //
    protected $table='delito';
    protected $primaryKey = 'idDelito';
    //protected $foreingKey = 'personaID';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = ['idDelito','nombredelito'];
    protected $hidden = [];
}
