<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VestimentaCadaver extends Model
{
    //
    protected $table ='vestimentadelcadaver';
    protected $primaryKey = 'idvesticadaver';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idvesticadaver',
        'idpersonacadaver',
        'Blusa',
        'Camisaconbotonesalfrente',
        'Camisadevestir',
        'Chaleco',
        'Chamarra',
        'Falda',
        'Pantalon',
        'Pantalondemezclilla',
        'Pants',
        'Playeraconcuelloredondo',
        'PlayeraconcuelloV',
        'Playeratipopolo',
        'Sudadera',
        'Sueter',
        'Vestido',
        'otros',
        'observaciones',
        'Tenis',
        'ZapatoCerrado',
        'Botas',
        'ZapatosTacon',
        'Cinturon',
        'Bolsa',
        'Anillos',
        'Reloj',
        'cadena',
        'collar',
        'pulcera',
        'cartera',
        'esclava',
        'aretes',
    ];
}
