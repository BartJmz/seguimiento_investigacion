<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    //
    protected $table = 'parentesco';
    protected $primaryKey= 'idParentesco';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['idParentesco','Descripcion'];
    //protected $guarded = ['idServicios'];
     
}
