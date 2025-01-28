<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //
    protected $table = 'perfilcomandancia';
    protected $primaryKey = 'IdPerfilComandancia';
    public  $timestamps = false;
    protected $fillable = ['NombrePerfilComandancia'];
    protected $guarded = ['IdPerfilComandancia'];
}
