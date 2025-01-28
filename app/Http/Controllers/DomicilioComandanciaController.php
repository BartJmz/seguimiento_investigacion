<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use App\Domicilio;
use App\Localidad;
use App\Municipio;
use App\Comandancia;
use DB;


class DomicilioComandanciaController extends Controller
{
    //
    public function index(){
        $localidadComandancia = DB::table('domiciliocomandancia')
        ->join('domicilio','domiciliocomandancia.idDireccion', '=','domicilio.idDomicilio')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL','=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->join('comandancia','domiciliocomandancia.idComandanciaDir','=','comandancia.idComandancia')
        ->select(
            'comandancia.nombreComandancia',
            'entidad.nombreEntidad',
            'municipio.nomMunicipio',
            'localidad.nombreLocalidad',
            'domicilio.cp',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.calle',
            'domicilio.referenciaDelLugar'
        )
        ->orderBy('comandancia.nombreComandancia', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $localidadComandancia;
    }
}
