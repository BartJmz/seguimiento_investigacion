<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    //
    protected $table ='ministeriopublico';
    protected $primaryKey = 'idministeriopublico';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
        'idministeriopublico',
        'nombreMinisterioPublico',
        'apPatMinisterioPublico',
        'apMatMinisterioPublico',
        'adscripcion',
        'autoriza',
        'carpetainv'
    ];
}
