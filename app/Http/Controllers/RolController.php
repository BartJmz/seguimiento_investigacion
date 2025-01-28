<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use DB;

class RolController extends Controller
{
    //
    public function getRol(){
        $rol = Rol::get();
        return $rol;
    }
}
