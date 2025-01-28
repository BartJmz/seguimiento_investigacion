<?php

namespace App\Http\Controllers;

use App\Localidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;
class LocalidadController extends Controller
{
    //
    public function getLocalidad(){
        $localidad = Localidad::get();
        return $localidad;
    }

}
