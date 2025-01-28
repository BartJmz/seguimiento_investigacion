<?php

namespace App\Http\Controllers;

use App\NombramientoDisponible;
use App\Cargo;
use App\Placa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
 
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response;
use DB;

class NombramientoDisponibleController extends Controller
{
    //
    public function index(){
         $nombramiento = DB::table('nombramientodisponible')
         ->join('placapersonal','nombramientodisponible.placa', '=','placapersonal.idplacapersonal')
         ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->select(
            'nombramientodisponible.idNombramientoDisponible',
            'placapersonal.idplacapersonal',
            'cargos.idCargo'
         )
         ->get();
         return $nombramiento;
     }
     public function updatePlacaCargo(Request $request, $idNombramientoDisponible){
        $placacargo = NombramientoDisponible::find($idNombramientoDisponible);
        $placacargo -> fill($request -> all());
        $placacargo -> save();
        return $placacargo;
       // return var_dump($comandancias);
    }

}
