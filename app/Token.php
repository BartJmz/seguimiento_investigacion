<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    //
    protected $table ='tokenpassword';
    protected $primaryKey = 'idtoken';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idtoken','correo','token'];
    //protected $guarded=['idArea'];
}
