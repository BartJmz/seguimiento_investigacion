<?php

namespace App\Http\Controllers;

use App\nombramientoplacapersonal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use DB;

class NombramientoPlacaPersonalController extends Controller
{
    //
    public function index(){
        $nombramientoplacapersonal = DB::table('nombramientoplacapersonal')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponible', '=','nombramientodisponible.idNombramientoDispobible')
        ->join('personalaei','nombramientoplacapersonal.idPersonalAEI', '=','personalaei.idPersonalAEI')
        ->join('placapersonal','nombramientodisponible.placa', '=','placapersonal.idplacapersonal')
        ->join('cargos','nombramientodisponible.idCargo', '=','cargos.idCargo')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
       ->select(
        'nombramientoplacapersonal.idNombramientoPersonal',
        'nombramientoplacapersonal.fechaNombramiento',
        'persona.nombrePersona',
        'placapersonal.idplacapersonal',
        'cargos.Descripcion'
        )
        ->get();
        return $nombramientoplacapersonal;
    }

}
