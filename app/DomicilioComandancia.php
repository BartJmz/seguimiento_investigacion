<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomicilioComandancia extends Model
{
    //
    protected $table='domiciliocomandancia';
    protected $primaryKey = 'idDomicilioComandancia';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = ['idDomicilioComandancia','idDireccionDomicilio','idComandanciaDir'];
    protected $hidden = [
    ];
}
