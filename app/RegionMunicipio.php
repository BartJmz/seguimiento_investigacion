<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionMunicipio extends Model
{
    //
    protected $table = 'regionmunicipio';
    protected $primaryKey = 'idregionmunicipio';
    public  $timestamps = false;
    protected $fillable = ['idregionmunicipio','idregionalizacion','idmunicipio'];
}
