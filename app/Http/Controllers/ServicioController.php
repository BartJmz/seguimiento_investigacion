<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminta\Support\Facades\Hash;
use App\Comandancia;
use App\Servicio;
use App\Area;
use App\ComandanciaServicio;
use DB;

class ServicioController extends Controller
{
    //
    public function index(){
        $service = DB ::table('servicios')
        ->where('area.status','=',1)
        ->join('area','servicios.idAreaServicio', '=' ,'area.idArea')
        ->select(
            'servicios.idServicios',
            'servicios.nombreServicio',
            'area.nombreArea',
            'servicios.idAreaServicio'
        )
        ->get();
        return $service;
    }
    public function index2(){
        $service = DB ::table('area')
        //->where('area.status','=',1)
        ->join('servicios','servicios.idAreaServicio', '=' ,'area.idArea')
        ->join('comandanciaservicio','comandanciaservicio.idtiposServicios', '=' ,'servicios.claveser')
        ->join('comandancia','comandanciaservicio.idservicioComandacia', '=' ,'comandancia.idComandancia')
        ->select(
            'comandancia.nombreComandancia',
            'servicios.nombreServicio',
            'area.nombreArea',
            'comandanciaservicio.idComandanciaServicio'
        )
        ->get();
        return $service;
    }
    public function getServicioID($idServicios){
        $service = DB::table('servicios')
        ->join('area','servicios.idAreaServicio', '=' ,'area.idArea')
        ->where('servicios.idServicios','=',$idServicios)
        ->select(
        'servicios.idServicios',
        'servicios.nombreServicio',
        'area.nombreArea',
        'servicios.idAreaServicio'
        )
        ->get();
        return $service;
    }
    public function updateServicio(Request $request, $idServicios){
        $service = Servicio::find($idServicios);
        $service -> fill($request -> all());
        $service -> save();
        return $service;
       //return var_dump($comandancias);
    }
    public function saveServicio(Request $request){
        $service= new Servicio();
        $service -> fill($request -> all());
        $service->save();
        return $service;
    }
    //Ver servicio por comandancia
    public function getServicioComandancia(){
        $service = DB::table('comandanciaservicio')
        ->join('servicios','comandanciaservicio.idtiposServicios', '=' ,'servicios.idServicios')
        ->join('comandancia','comandanciaservicio.idservicioComandacia', '=' ,'comandancia.idComandancia')
        ->join('area','servicios.idAreaServicio', '=' ,'area.idArea')
        ->select(
            'comandancia.nombreComandancia',
            'area.nombreArea',
            'servicios.nombreServicio'
        )
        ->get();
        return $service;
    }
    //Agregamos servicio por comandancia
    public function saveServicioComandancia(Request $request){
        $service= new ComandanciaServicio();
        $service -> fill($request -> all());
        $service->save();
        return $service;
    }

    //fin
}
