<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    protected $table = 'roles';
    protected $primaryKey ='idRoles';
    public $timestamps = false;
    protected $fillable = ['nombreRoles'];
    protected $guarded = ['idRoles']; 
}
