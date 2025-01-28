<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    //
    protected $table='imagen';
    protected $primaryKey = 'imagen_id';
    public    $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
    'imagen_id','nombre_imagen','imagen','mimeimagen',
    'fechaImagen','idPersonaImagen'];
    protected $hidden = [
       
    ];
}
