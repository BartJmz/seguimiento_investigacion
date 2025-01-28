<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CambioArma extends Model
{
    //
    protected $table ='cambioarma';
    protected $primaryKey = 'idCambioArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idCambioArma',
    'matricula',
    'fechacambio',
    'motivo'];
}
