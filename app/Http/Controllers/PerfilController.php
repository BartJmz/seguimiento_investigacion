<?php

namespace App\Http\Controllers;


use App\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use DB;

class PerfilController extends Controller
{
    //
    public function getPerfil(){
        $perfil = Perfil::get();
         return $perfil;
     }
}