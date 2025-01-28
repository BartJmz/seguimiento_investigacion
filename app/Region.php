<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $table = 'region';
    protected $primaryKey = 'idRegion';
    public  $timestamps = false;
    protected $fillable = ['nombreRegion'];
    protected $guarded = ['idRegion'];
}
