<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenalVisiblesCadaver extends Model
{
    //
    protected $table ='senalesvisiblescadaver';
    protected $primaryKey = 'idsenalesvisiblescadaver';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idsenalesvisiblescadaver','idActaDLT','nombreCadaver','apPatCadaver','apMatCadaver','edad',
        'posicioncadaver','orientacioncadaver','estatura','complexion','tez','tatuajes','cicatriz','lunar',
        'malformacioncongenita','equimosishematoma','laceraciones','abrasiones','contuciones',
        'fracturafisuras','cvecadaver'
    ];
}
