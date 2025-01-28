<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalMovimientoArma extends Model
{
    //
    protected $table='personalmovimientoarma';
    protected $primaryKey = 'idPersonalArmaMovimeinto';
    public    $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'idPersonalArmaMovimeinto',
        'idTipoMovimeintoArma',
        'idPersonalAEIArma',
        'idArmaMovimiento',
        'fechaMovimientoArma',
        'fechaCambio',
        'motivoMovimiento',
        'CarpetaDeInvsArma',
        'estatusdelarma',
        'status_arma'];
        protected $hidden = [
           
        ];
}
