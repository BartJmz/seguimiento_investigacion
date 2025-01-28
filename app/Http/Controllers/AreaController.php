<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminta\Support\Facades\Hash;
use App\Area;
use DB;

class AreaController extends Controller
{
    //
    public function index(){
        /*
        $area = AreaOnly:: get();
        return $area;
        */
        $area = DB::table('area')
        ->where('area.status','=',1)
        ->select(
        'area.idArea',
        'area.nombreArea',
        'area.status')
        ->orderBy('area.nombreArea', 'asc')
        ->get();
        return $area;
    }
    public function getAreaID($idArea){
        $area = Area::find($idArea);
        return $area;
    }
    public function updateArea(Request $request, $idArea){
        $area = Area::find($idArea);
        $area -> fill($request -> all());
        $area -> save();
        return $area;
       
    }
    public function saveArea(Request $request){
        $area= new Area();
        $area -> fill($request -> all());
        $area->save();
        return $area;
    }
    public function exitNombreArea($Nombre){
        $user = DB::table('area')
        ->where('area.nombreArea','=',$Nombre)
        ->select('idArea','nombreArea')
        ->get();
        return $user;
    }
}
