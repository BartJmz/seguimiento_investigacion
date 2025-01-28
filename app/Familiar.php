<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    //
    protected $table = 'familiar';
    protected $primaryKey= 'idFamiliar';
    public $timestamps = false;
    public $incrementing = false;
 
    protected $fillable = ['idFamiliar',
     'idDatosFamiliaresF','idPersonaFamiliarF'];
     //protected $guarded = ['idServicios'];
}
