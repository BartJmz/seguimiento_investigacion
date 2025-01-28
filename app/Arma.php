<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    //
    protected $table ='arma';
    protected $primaryKey = 'idArma';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idArma','clase_arma','calibre','marca','modelo',
    'matricula','foliosREGFED_C','foliosREGFED_D','tipoArma','fechaRegistroArma',
    'materialesCompoArma','estadoFisico','coloresArma','status','adquisicion',
    'observacionesArma','tipoCompra'
];
    //protected $guarded=['idArea'];
}
