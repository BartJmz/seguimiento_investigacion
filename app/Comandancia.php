<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

	class Comandancia extends Model
{
    protected $table='comandancia';
    protected $primaryKey = 'idComandancia';
    public    $timestamps = false;
    public $incrementing = false;
    

    protected $fillable = ['idComandancia','nombreComandancia','email','tel','regionRegion','direccionComandancia'];
    //protected $guarded = ['idComandancia'];  
    
    protected $hidden = [
    ];
}
