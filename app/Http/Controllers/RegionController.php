<?php

namespace App\Http\Controllers;

use App\Region;
use App\Regionalizacion;
use App\RegionMunicipio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
//use Illuminate\Support\Facades\Response;
use DB;
class RegionController extends Controller
{
    //
    public function getRegion(){
        $region = Region::get();
         return $region;
    }
    public function getRegionalizacion($region){
        $regionalizacion = DB :: table ('regionalizacion')
        ->where('regionalizacion.region','=',$region)
        ->select(
            'regionalizacion.idregionalizacion',
            'regionalizacion.region',
            'regionalizacion.distrito'
            
        )
        //->orderBy('regionalizacion.distrito')
        ->get();
        return $regionalizacion; 
    }
    public function getRegionv2($region){
        $regionalizacion2 = DB :: table ('hechos')
        ->join('region','hechos.idregionhechos','=','region.idRegion')
        ->join('regionalizacion','regionalizacion.region','=','region.idRegion')
        ->join('carpetadeinvestigacion','hechos.carpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->where('regionalizacion.idregionalizacion','=',$region)
        ->select(
            'regionalizacion.region',
            'regionalizacion.idregionalizacion'            
        )        
        ->get();
        return $regionalizacion2; 
    }
    public function getMunicipioID($idregionalizacion){
        $regionalizacion = DB :: table ('regionmunicipio')
        ->join('regionalizacion','regionmunicipio.idregionalizacion','=','regionalizacion.idregionalizacion')
        ->join('municipio','regionmunicipio.idmunicipio','=','municipio.idMunicipio')
        ->where('regionalizacion.idregionalizacion','=',$idregionalizacion)
        ->select(
                'regionalizacion.distrito',
                'municipio.nomMunicipio',
                'municipio.idMunicipio',
                'municipio.cveMunicipio'
        )   
        ->get();
        return $regionalizacion; 
    }
    
    public function getdistritoInfo($idregionalizacion){
        $regionalizacion = DB :: table ('regionalizacion')
        ->where('regionalizacion.idregionalizacion','=',$idregionalizacion)
        ->select(
            'regionalizacion.idregionalizacion',
            'regionalizacion.region',
            'regionalizacion.distrito'
        )   
        ->get();
        return $regionalizacion; 
    }
    //Termina.
}
