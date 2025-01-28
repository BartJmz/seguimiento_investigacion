<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regionalizacion extends Model
{
    //
    protected $table = 'regionalizacion';
    protected $primaryKey = 'idregionalizacion';
    public  $timestamps = false;
    protected $fillable = ['region','distrito'];
    //protected $guarded = ['idregionalizacion'];
}

