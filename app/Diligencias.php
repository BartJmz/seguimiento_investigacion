<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diligencias extends Model
{
    //
    protected $table='diligencias';
    protected $primaryKey = 'diligencias';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = [
        'diligencias','nombreDiligencias','aux'
    ];
    protected $guarded = [''];  
    
    protected $hidden = [
    ];
}
