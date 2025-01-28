<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComandanciaServicio extends Model
{
    //
    protected $table='comandanciaservicio';
    protected $primaryKey = 'idComandanciaServicio';
    public    $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['idComandanciaServicio','idservicioComandacia','idtiposServicios'];
    protected $guarded = [''];  
    protected $hidden = [
    ];
}
