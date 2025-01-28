<?php

namespace App\Http\Controllers;

use App\CodigoPostal; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;
class CodigoPostalController extends Controller
{
    //
    public function indexCodigoPostal(){
        $cp = CodigoPostal::get();
        return $cp;
     }
     public function getCpID($codigoPostal){
        $cp = CodigoPostal::find($codigoPostal);
        return $cp;
    }
}
