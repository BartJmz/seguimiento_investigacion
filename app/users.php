<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //
    protected $table='users';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    public $incrementing = false;

    //protected $fillable = ['name','email','password','idRolesUser','personalaeiUser'];
    protected $fillable = ['email','password','idRolesUser','personalaeiUser','status'];
    protected $guarded = ['id'];  
    
    protected $hidden = [
        'password',
    ];
}
 