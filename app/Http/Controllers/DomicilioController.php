<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use App\Domicilio;
use App\Localidad;
use App\Municipio;
use DB;

class DomicilioController extends Controller
{
    //
    public function index(){
        $domicilio = DB::table('domicilio')
        ->join('localidad','localidad.idLocalidad', '=','domicilio.localidadDomicilio')
        ->join('municipio','municipio.cveMunicipio', '=','localidad.cveMunicipioL')
        ->join('entidad','entidad.cveEntidad', '=','municipio.cveEntidadM')
        ->select(
            'entidad.nombreEntidad',
            'municipio.nomMunicipio',
            'localidad.nombreLocalidad',
            'localidad.ambito',
            'domicilio.cp',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.calle'
        )
        ->orderBy('municipio.nomMunicipio', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $domicilio;
    }
}
