<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AreaOnly;
use DB;
class AreaOnlyController extends Controller
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
        $area = AreaOnly::find($idArea);
        return $area;
    }
    public function getAreaNombre($nombreArea){
        $area = DB::table('area')
        ->where('area.nombreArea','=', $nombreArea)
        ->select('area.nombreArea')
        ->get();
        return $area;
    }
    public function updateArea(Request $request, $idArea){
        $area = AreaOnly::find($idArea);
        $area -> fill($request -> all());
        $area -> save();
        return $area;
       
    }
    public function saveAreaOnly(Request $request){
        $area= new AreaOnly();
        $area -> status =1;
        $area -> fill($request -> all());
        $area->save();
        return $area;
    }
    public function updateAreaOnly(Request $request, $idArea){
        $area = AreaOnly::find($idArea);
        $area -> fill($request -> all());
        $area -> save();
        return $area;
    }
    public function updateAreaOnly2(Request $request, $idArea){
        $area = AreaOnly::find($idArea);
        $area -> fill($request -> all());
        $area -> status = 0;
        $area -> save();
        return $area;
    }
}
