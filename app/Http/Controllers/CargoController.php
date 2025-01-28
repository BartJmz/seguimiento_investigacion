<?php

namespace App\Http\Controllers;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response; 
use DB;

class CargoController extends Controller
{
    //
    public function getCargo(){
        $cargo = Cargo::get();
        return $cargo;
    }
    public function saveCargo(Request $request){
        $placa= new Cargo();
        $placa -> fill($request -> all());
        $placa->save();
        return $placa;
    }
}
