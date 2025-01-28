<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    //

    protected $table='tokenpassword';
    protected $primaryKey = 'user';
    public    $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'user','correo','token'
    ];    
    protected $guarded = [''];  
    protected $hidden = [
    ];
}
