<?php

namespace App\Http\Controllers;
use App\PlantillaVehiculo;
use App\Vehiculo;
use App\Comandancia;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;
use Illuminate\Http\Request;

class PlantillaVehiculoController extends Controller
{
    //
    public function getComandancia(){
        $Comandancia = Comandancia::get();
        return $Comandancia;
    }
    public function vehiculoDisponible(){
        $vehiculoDisponible = DB::table('vehiculo')
        ->where('vehiculo.status','=', 1)
        ->select(
           'vehiculo.numeroSerie',           
            'vehiculo.tipoVehiculo',
            'vehiculo.marcaVehiculo',
            'vehiculo.modeloVehiculo'
        )
        ->get();
        return $vehiculoDisponible;
    }

    public function getAllVehiculo(){
        $allarmas = DB::table('plantillavehiculo')
        ->join('vehiculo','plantillavehiculo.idVehiculoAsignado', '=','vehiculo.numeroSerie')
        ->join('comandancia','plantillavehiculo.idAsignacionComandancia', '=','comandancia.idComandancia')
        ->join('movimientovehiculo','plantillavehiculo.tipoAsignacion', '=','movimientovehiculo.idMovimientovehiculo')
        ->join('region','comandancia.regionRegion', '=','region.idRegion')
        ->where('plantillavehiculo.estatus','=',1)    
        ->select(
            'plantillavehiculo.idplantillaVehiculo',
            'plantillavehiculo.fechaAsignacion',
            'plantillavehiculo.tipoAsignacion',
            'plantillavehiculo.idAsignacionComandancia',
            'plantillavehiculo.ObservacionAsignacion',
            'comandancia.nombreComandancia',
            'comandancia.regionRegion',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.status',
            'vehiculo.ObservacionesVehiculo',
            'movimientovehiculo.movimientovehiculo',
            'region.nombreRegion'
        )
        ->orderBy('plantillavehiculo.fechaAsignacion', 'asc')
        ->get();
        return $allarmas;
    }
    public function getIDPlantilaVehiculo($numeroSerie){
        $allarmas = DB::table('plantillavehiculo')
        ->join('vehiculo','plantillavehiculo.idVehiculoAsignado', '=','vehiculo.numeroSerie')
        ->join('comandancia','plantillavehiculo.idAsignacionComandancia', '=','comandancia.idComandancia')
        ->join('movimientovehiculo','plantillavehiculo.tipoAsignacion', '=','movimientovehiculo.idMovimientovehiculo')
        ->join('region','comandancia.regionRegion', '=','region.idRegion')
        ->where('vehiculo.numeroSerie','=', $numeroSerie)
        ->where('plantillavehiculo.estatus','=',1)    
        ->select(
            'plantillavehiculo.idplantillaVehiculo',
            'plantillavehiculo.fechaAsignacion',
            'plantillavehiculo.tipoAsignacion',
            'plantillavehiculo.ObservacionAsignacion',            
            'plantillavehiculo.idAsignacionComandancia',
            'comandancia.nombreComandancia',
            'comandancia.regionRegion',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.ObservacionesVehiculo',
            'movimientovehiculo.movimientovehiculo',
            'region.nombreRegion'
        )
        ->orderBy('plantillavehiculo.fechaAsignacion', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $allarmas;
    }
    public function getVehiculo(){
        $allarmas = DB::table('vehiculo')
        ->where('vehiculo.status','!=',2)
        ->select(
            'vehiculo.fechaRegistroVehiculo',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.ObservacionesVehiculo',
            'vehiculo.status'
        )
        ->orderBy('vehiculo.PlacaActual', 'asc')
        
        ->get();
        return $allarmas;
    }
    public function getVehiculo2(){
        $allarmas = DB::table('vehiculo')
        ->where('vehiculo.status','=',2)
        ->select(
            'vehiculo.fechaRegistroVehiculo',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.ObservacionesVehiculo',
            'vehiculo.status'
        )
        ->orderBy('vehiculo.PlacaActual', 'asc')
        
        ->get();
        return $allarmas;
    }
    public function getIDVehiculo($numeroSerie){
        $allarmas = DB::table('vehiculo')
        ->where('vehiculo.numeroSerie','=', $numeroSerie)
        ->select(
            'vehiculo.fechaRegistroVehiculo',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.ObservacionesVehiculo',
            'vehiculo.status'
        )
        ->orderBy('vehiculo.PlacaActual', 'asc')
        ->get();
        return $allarmas;
    }
    public function getIDPlantillaVehiculo($numeroSerie){
        $allarmas = DB::table('plantillavehiculo')
        ->join('vehiculo','plantillavehiculo.idVehiculoAsignado','=','vehiculo.numeroSerie')      
        ->join('comandancia','plantillavehiculo.idAsignacionComandancia','=','comandancia.idComandancia')     
        ->where('vehiculo.numeroSerie','=', $numeroSerie)    
        ->where('plantillavehiculo.estatus','=', 1)    
        ->select(            
            'plantillavehiculo.idplantillaVehiculo',
            'plantillavehiculo.idAsignacionComandancia',
            'plantillavehiculo.fechaAsignacion',
            'plantillavehiculo.fecha_baja_cambio',
            'comandancia.nombreComandancia',
            'plantillavehiculo.idVehiculoAsignado',                
            'plantillavehiculo.tipoAsignacion',
            'plantillavehiculo.ObservacionAsignacion',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.fechaRegistroVehiculo',
            'vehiculo.ObservacionesVehiculo'
        )
        ->orderBy('vehiculo.PlacaActual', 'asc')
        ->get();
        return $allarmas;
    }
    public function getIDVehiculo2($numeroSerie){
        $existe = DB::table('vehiculo')
        ->where('vehiculo.numeroSerie','=', $numeroSerie)
        ->select(
            'vehiculo.numeroSerie'
        )
        ->get();
        return $existe;
    }
    public function getIDVehiculo3($numeroSerie){
        $allarmas = DB::table('plantillavehiculo')
        ->join('vehiculo','plantillavehiculo.idVehiculoAsignado','=','vehiculo.numeroSerie')        
        ->where('vehiculo.numeroSerie','=', $numeroSerie)    
        ->select(            
            'plantillavehiculo.idplantillaVehiculo',
            'plantillavehiculo.idAsignacionComandancia',
            'plantillavehiculo.idVehiculoAsignado',                
            'plantillavehiculo.tipoAsignacion',
            'vehiculo.marcaVehiculo',
            'vehiculo.tipoVehiculo',
            'vehiculo.colorVehiculo',
            'vehiculo.modeloVehiculo',
            'vehiculo.numeroSerie',
            'vehiculo.cilVehiculo',
            'vehiculo.PlacaActual',
            'vehiculo.fechaRegistroVehiculo',
            'vehiculo.ObservacionesVehiculo'
        )
        ->orderBy('vehiculo.PlacaActual', 'asc')
        ->get();
        return $allarmas;
    }
    public function saveVehiculo(Request $request){
        $armas= new Vehiculo();
        $armas -> fill($request -> all());
        $armas -> status =1;
        $armas->save();
        return $armas;
    }
    public function saveAsiganacionVehiculo(Request $request){
        $vehiculo_asignacion= new PlantillaVehiculo();
        $vehiculo_asignacion -> fill($request -> all());
        $vehiculo_asignacion -> tipoAsignacion = 2;
        $vehiculo_asignacion -> estatus = 1;
        $vehiculo_asignacion->save();
        return $vehiculo_asignacion;
    }
    public function saveAsiganacionVehiculo3(Request $request){
        $vehiculo_asignacion= new PlantillaVehiculo();
        $vehiculo_asignacion -> fill($request -> all());
        $vehiculo_asignacion -> tipoAsignacion = 4;
        $vehiculo_asignacion -> estatus = 0;
        $vehiculo_asignacion->save();
        return $vehiculo_asignacion;
    }
    public function updateVehiculo(Request $request, $numeroSerie){
        $updateVehiculo = Vehiculo::find($numeroSerie);
        $updateVehiculo -> fill($request -> all());
        $updateVehiculo->save();
        return $updateVehiculo;
       // return var_dump($comandancias);
    }
    public function updateVehiculo2(Request $request, $numeroSerie){
        $updateVehiculoDisponible = Vehiculo::find($numeroSerie);
        $updateVehiculoDisponible -> status =0;
        $updateVehiculoDisponible->save();
        return $updateVehiculoDisponible;
       // return var_dump($comandancias);
    }
    public function updateVehiculo3(Request $request, $numeroSerie){
        $updateVehiculoDisponible = Vehiculo::find($numeroSerie);
        $updateVehiculoDisponible -> status =2;
        $updateVehiculoDisponible->save();
        return $updateVehiculoDisponible;
       // return var_dump($comandancias);
    }
    public function updatePlantillaVehiculo(Request $request, $idplantillaVehiculo){
        $updatePlantillaVehiculo = PlantillaVehiculo::find($idplantillaVehiculo);
        $updatePlantillaVehiculo -> fill($request -> all());
        $updatePlantillaVehiculo->save();
        return $updatePlantillaVehiculo;
       // return var_dump($comandancias);
    }
    //fin
}
