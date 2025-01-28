<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoArma extends Model
{
    //
    protected $table ='tipoarma';
    protected $primaryKey = 'idtipoArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idtipoArma','tipoArama'];
}
