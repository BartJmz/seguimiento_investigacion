<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LugarIntervencion extends Model
{
    //    
    protected $table ='lugarintervencion';
    protected $primaryKey = 'idlugarintervencion';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idlugarintervencion','fechalugar_intervencion','idMunicipio',
        'idLocalidad','cp','colonia','calle','ni','ne','motivo','lugarointernvencion','carpetainv'
    ];
}
