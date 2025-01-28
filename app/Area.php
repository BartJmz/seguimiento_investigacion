<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table ='area';
    protected $primaryKey = 'idArea';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=['idArea','nombreArea','status'];
    //protected $guarded=['idArea'];
}
