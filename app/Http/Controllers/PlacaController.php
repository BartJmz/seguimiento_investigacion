<?php

namespace App\Http\Controllers;

use App\Placa;
use App\Cargo;
use App\NombramientoDisponible;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response;
use DB;

class PlacaController extends Controller
{
    //
    /*
    public function getPlaca(){
        $placa = Placa::get();
        return $placa;
    }*/
    public function getPlaca(){
        $placas = DB::table('nombramientodisponible')
        ->join('placapersonal','nombramientodisponible.placa', '=','placapersonal.idplacapersonal')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->select(
            'placapersonal.idplacapersonal',
            'cargos.Descripcion',
            'placapersonal.disponible'
        )
        ->get();
        return $placas;
     }
    public function disponible(){
        $placa = DB::table('placapersonal')
        ->where('placapersonal.disponible','=',1)
        ->select(
            'placapersonal.idplaca',
            'placapersonal.idplacapersonal'
        )
        ->get();
        return $placa;
    }
    public function disponible2(){
        $placa = DB::table('nombramientodisponible')
        ->join('placapersonal','nombramientodisponible.placa', '=','placapersonal.idplacapersonal')
        ->where('placapersonal.disponible','=',1)
        ->select(
            'nombramientodisponible.idNombramientoDisponible',
            'nombramientodisponible.placa',
            'placapersonal.disponible',
            'placapersonal.idplacapersonal'
        )
        ->get();
        return $placa;
    }
    
    public function ocupado(){
        $placa = DB::table('placapersonal')
        ->where('placapersonal.disponible','=',0)
        ->select(
            'placapersonal.idplacapersonal'
        )
        ->get();
        return $placa;
    }
    public function savePlaca(Request $request){
        $placa= new Placa();
        $placa -> fill($request -> all());
        $placa->save();
        return $placa;
    }
    
    public function getIdPlaca($idplacapersonal){
        $placa = DB::table('placapersonal')
        ->where('placapersonal.idplacapersonal','=',$idplacapersonal)
        ->select(
            'placapersonal.idplacapersonal',
            'placapersonal.disponible',
            'placapersonal.idplaca'
        )
        ->get();
        return $placa;
    }
    
    public function getIdPlacaCargo($idplacapersonal){
        $placas = DB::table('nombramientodisponible')
        ->join('placapersonal','nombramientodisponible.placa', '=','placapersonal.idplacapersonal')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->where('nombramientodisponible.placa','=',$idplacapersonal)
        ->select(
            'nombramientodisponible.idNombramientoDisponible',
            'nombramientodisponible.placa',
            'nombramientodisponible.idCargoNom'
        )
        ->get();
        return $placas;
    }
    public function getCargo(){
        $cargo = Cargo::get();
        return $cargo;
    }
    public function savePlacaCargo(Request $request){
        $placacargo= new NombramientoDisponible();
        $placacargo -> fill($request -> all());
        $placacargo->save();
        return $placacargo;
    } 
}
