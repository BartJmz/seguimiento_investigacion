<?php

namespace App\Http\Controllers;

use App\PersonalAEI;
use App\DatosFamiliares;
use App\Familiar;
use App\Telefonos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use Illuminate\Support\Facades\Response;
use DB;

class PersonalController extends Controller
{
    //
    public function getPersonal(){
        $personalAEI = PersonalAEI::get();
        return $personalAEI;    
    }
    public function getPersonalID($idPersonalAEI){
        //$personalAEI = PersonalAEI::find($idPersonalAEI);
        $personalAEI = DB::table('personalaei')
        ->join('adscripcion','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds','=','comandancia.idComandancia')
        ->select(
            'personalaei.idPersonalAEI',
            'personalaei.operativo',
            'personalaei.cuip',
            'personalaei.viaIngreso',
            'personalaei.cartillaSmn',
            'personalaei.emailAEI',
            'personalaei.personaID',
            'comandancia.nombreComandancia'
        )
        ->get();
        return $personalAEI;
    }
    public function getPersonaTelefonoId($numeroTel){
        $idcom = DB::table('telefono')
        ->where('numeroTel','=',$numeroTel)
        ->select(
            'telefono.idTelefono'
        )
        ->get();
        return $idcom;
    }
       
    //Guardamos datos del personal 
    public function savePersonal(Request $request){
        $personalAEI= new PersonalAEI();
        $personalAEI -> fill($request -> all());
        $personalAEI->save();
        return $personalAEI;
    }
    public function saveFamiliar(Request $request){
        $familiar= new DatosFamiliares();
        $familiar -> fill($request -> all());
        $familiar->save();
        return $familiar;
    }
    public function saveFamilia(Request $request){
        $familia= new Familiar();
        $familia -> fill($request -> all());
        $familia->save();
        return $familia;
    }
    public function saveTelefono(Request $request){
        $telefono= new Telefonos();
        $telefono -> fill($request -> all());
        $telefono->save();
        return $telefono;
    }
    public function buscaremail($emailAEI){
        $email = DB::table('personalaei')
        ->where('personalaei.emailAEI','=',$emailAEI)
        ->select('emailAEI')
        ->get();
        return $email;
    }
}
