<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoBienes extends Model
{
    //
    protected $table = 'tipo_bienes';
    protected $primaryKey= 'id_tipo_bienes';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['id_tipo_bienes',
    'descripción'];
}
