<?php     

namespace App\Http\Controllers;
//
use App\Placa;
use App\CodigoPostal; 
use App\Domicilio;
use App\Localidad;
use App\Municipio;
use App\NombramientoDisponible;
use App\DomicilioComandancia;
use App\AgendaComandancia;
//

use App\Comandancia;  //hacemos uso de nuestro modelo Comandancia
use App\Region;
use Illuminate\Http\Request;
use App\http\Requests\ComandanciaForm;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response;
use DB;

class ComandanciaController extends Controller
{
    public function allComandancias(){
       // $comandancias = Comandancia::get();
        $comandancias = DB::table('comandancia')
        ->join('region','comandancia.RegionRegion', '=','region.idRegion')
        //->join('agendacomandancia','agendacomandancia.idComandanciaFK', '=','comandancia.idComandancia')
        //->join('domicilio','domicilio.idDomicilio','=','comandancia.direccionComandancia')
        ->select(
        'comandancia.idComandancia',
        'comandancia.nombreComandancia',
        'comandancia.email',
        'region.idRegion',
        'region.nombreRegion'
        //'agendacomandancia.numeroTelefonico'
        //'domicilio.idDomicilio'
        )
        ->orderBy('comandancia.nombreComandancia', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $comandancias;
    }
    
    public function getComandanciasID($idComandancia){
        $comandancias = DB::table('comandancia')
        ->join('region','comandancia.regionRegion', '=','region.idRegion')
        //->join('agendacomandancia','agendacomandancia.idComandanciaFK', '=','comandancia.idComandancia')
        ->join('domiciliocomandancia','domiciliocomandancia.idComandanciaDir', '=','comandancia.idComandancia')
        ->join('domicilio','domiciliocomandancia.idDireccionDomicilio', '=','domicilio.cve')
        ->join('localidad','domicilio.localidadDomicilio', '=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
        ->join('municipiocodigopostal','municipiocodigopostal.idMunicipio', '=','municipio.idMunicipio')
        ->join('entidad','municipio.cveEntidadM', '=','entidad.cveEntidad')
        ->where('comandancia.idComandancia','=',$idComandancia)
        ->select(
            'comandancia.idComandancia',
            'comandancia.nombreComandancia',
            'comandancia.email',
            //'agendacomandancia.numeroTelefonico',
            'region.nombreRegion',
            'domicilio.colonia',
            'domicilio.calle',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.referenciaDelLugar',
            'localidad.nombreLocalidad',
            'localidad.ambito',
            'municipio.nomMunicipio',
            'municipiocodigopostal.codigoPostal',
            'entidad.nombreEntidad'
            )
        ->orderBy('comandancia.idComandancia')
        ->take(1)
        ->get();
        return $comandancias;
    }
   //Modificando
   public function getComandanciasID2($idComandancia){
    $comandancias = DB::table('comandancia')
    ->join('region','comandancia.regionRegion', '=','region.idRegion')
    //->join('agendacomandancia','agendacomandancia.idComandanciaFK', '=','comandancia.idComandancia')
    ->where('comandancia.idComandancia','=',$idComandancia)
    ->select(
        'comandancia.idComandancia',
        'comandancia.nombreComandancia',
        'comandancia.email',
        //'agendacomandancia.numeroTelefonico',
        'comandancia.regionRegion'
        //'region.nombreRegion'
        )
    ->get();
    return $comandancias;
    }   
    public function getComandanciaIDAgenda($nombreComandancia){
        $numeroTelefonico = DB::table('agendacomandancia')
        ->join('comandancia','agendacomandancia.idComandanciaFK', '=','comandancia.nombreComandancia')
        ->where('comandancia.nombreComandancia','=',$nombreComandancia)
        ->select(
            'agendacomandancia.numeroTelefonico',
            'agendacomandancia.ext',
            'comandancia.idComandancia',
            'comandancia.nombreComandancia'
            )
        ->get();
        return $numeroTelefonico;
        } 
    public function getComandanciasDomicilio($idComandanciaDir){
    $domicilio = DB::table('domicilio')
    ->join('domiciliocomandancia','domiciliocomandancia.idDireccionDomicilio', '=','domicilio.cve')
    ->join('localidad','domicilio.localidadDomicilio', '=','localidad.idLocalidad')
    ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
    ->join('entidad','municipio.cveEntidadM', '=','entidad.cveEntidad')
    ->where('domiciliocomandancia.idComandanciaDir','=',$idComandanciaDir)
    ->select(
        'domicilio.idDomicilio',
        'domicilio.codigoPostal',
        'domicilio.colonia',
        'domiciliocomandancia.idDomicilioComandancia',
        'domicilio.nInterior',
        'domicilio.nExterior',
        'domicilio.calle',
        'domicilio.referenciaDelLugar',
        'domicilio.localidadDomicilio',
        'localidad.nombreLocalidad',
        'municipio.nomMunicipio',
        'entidad.nombreEntidad'
        )
    ->get();
    return $domicilio;
    }    
   //
   public function updatePlacaCargo(Request $request, $idNombramientoDisponible){
    $comandancias = NombramientoDisponible::find($idNombramientoDisponible);
    $comandancias -> fill($request -> all());
    $comandancias -> save();
    return $comandancias;
   // return var_dump($comandancias);
}
public function updatePlaca(Request $request, $updatePlaca){
    $placas = Placa::find($updatePlaca);
    $placas -> fill($request -> all());
    $placas -> save();
    return $placas;
   // return var_dump($comandancias);
}
    public function updateComandancia(Request $request, $idComandancia){
        $comandancias = Comandancia::find($idComandancia);
        $comandancias -> fill($request -> all());
        $comandancias -> save();
        return $comandancias;
       // return var_dump($comandancias);
    }
    public function updateDomicilio(Request $request, $idDomicilio){
        $domicilio = Domicilio::find($idDomicilio);
        $domicilio -> fill($request -> all());
        $domicilio -> save();
        return $domicilio;
       // return var_dump($comandancias);
    }
    public function saveComandancia(Request $request){
        $comandancias= new Comandancia();
        $comandancias -> fill($request -> all());
        $comandancias->save();
        return $comandancias;
    }
    public function saveAgenda(Request $request){
        $AgendaComandancia= new AgendaComandancia();
        $AgendaComandancia -> fill($request -> all());
        $AgendaComandancia->save();
        return $AgendaComandancia;
    }
    
    public function buscaremail($email){
        $comandancias = DB::table('comandancia')->where('email', $email)->first();
        if(is_null($comandancias))
            return Response::json(['response' => 'email disponible'], 404);
            //return Response::json($comandancias->email, 200);
    }
    //Comandancia Localidad
    public function localidadComandancia(){
        $localidadComandancia = DB::table('domiciliocomandancia')
        ->join('domicilio','domiciliocomandancia.idDireccionDomicilio', '=','domicilio.idDomicilio')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL','=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->join('comandancia','domiciliocomandancia.idComandanciaDir','=','comandancia.idComandancia')
        ->select(
            'domicilio.idDomicilio',
            'comandancia.idComandancia',
            'comandancia.nombreComandancia',
            'entidad.nombreEntidad',
            'municipio.nomMunicipio',
            'localidad.nombreLocalidad',
            'domicilio.codigoPostal',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.calle',
            'domicilio.referenciaDelLugar',
            'domicilio.localidadDomicilio'
        )
        ->orderBy('comandancia.nombreComandancia', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $localidadComandancia;
    }
    //Esta funcion te da todas las direcciones por id de la comandancia 
    //te puede servir si en ves de darle un idComandancia busacas por CP
    public function getDireccionID($idComandancia){
        $localidadComandancia = DB::table('domiciliocomandancia')
        ->join('domicilio','domiciliocomandancia.idDireccionDomicilio', '=','domicilio.idDomicilio')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL','=','municipio.cveMunicipio')
        ->join('municipiocodigopostal','municipiocodigopostal.idMunicipio','=','municipio.idMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->join('comandancia','domiciliocomandancia.idComandanciaDir','=','comandancia.idComandancia')
        ->join('region','comandancia.RegionRegion', '=','region.idRegion')
        ->join('agendacomandancia','agendacomandancia.idComandanciaFK', '=','comandancia.idComandancia')
        ->where('domiciliocomandancia.idComandanciaDir','=',$idComandancia)
        ->select(
            'comandancia.idComandancia',
            'comandancia.nombreComandancia',
            'comandancia.email',
            'agendacomandancia.numeroTelefonico',
            'region.idRegion',
            'region.nombreRegion',
            'domiciliocomandancia.idDomicilioComandancia',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.calle',
            'domicilio.referenciaDelLugar',
            'municipiocodigopostal.codigoPostal',
            'localidad.idLocalidad',
            'localidad.nombreLocalidad',
            'localidad.ambito',
            'municipio.nomMunicipio',
            'municipio.cveMunicipio',
            'entidad.nombreEntidad'
            )
            ->orderBy('comandancia.nombreComandancia', 'asc')
            //->groupBy('comandancia.NombreComandancia')
            ->get();
            return $localidadComandancia;
    }
   
    public function saveDomicilio(Request $request){                
        $domicilio= new Domicilio();
        $domicilio -> fill($request -> all());
        $domicilio->save();
        return $domicilio;
        //return var_dump($domicilio);
    }
     //ARRIBA TODO BIEN
    public function saveDomicilioComandancia(Request $request){
        $domicilioc= new DomicilioComandancia();
        $domicilioc -> fill($request -> all());
        $domicilioc->save();
        return $domicilioc;
    }
    public function getCpID($codigoPostal){
        $cp = CodigoPostal::find($codigoPostal);
        return $cp;
    }
    public function getMunicipioCVE($idMunicipio)
    {
        # code...
        $municipio = DB::table('municipio')
        ->join('entidad','municipio.cveEntidadM', '=','entidad.cveEntidad')        
        ->join('localidad','localidad.cveMunicipioL', '=','municipio.cveMunicipio')        
        ->where('idMunicipio','=',$idMunicipio)
        ->select(
            'municipio.nomMunicipio',
            'municipio.cveMunicipio',
            'entidad.nombreEntidad',
            'localidad.idLocalidad',
            'localidad.nombreLocalidad'
        )
        ->get();
        return $municipio;
    }/*
    public function busca($nombreComandancia){
        $idcom = DB::table('comandancia')
        ->where('nombreComandancia','=',$nombreComandancia)
        ->select(
            'comandancia.idComandancia'
        )
        ->get();
        return $idcom;
    }*/
    public function buscaNombre($nombreComandancia){
        $idcom = DB::table('comandancia')
        ->where('nombreComandancia','=',$nombreComandancia)
        ->select(
            'comandancia.idComandancia',
            'comandancia.nombreComandancia'
        )
        ->get();
        return $idcom;
    }
    public function busca2($codigoPostal){
        $idcom = DB::table('domicilio')
        ->where('codigoPostal','=',$codigoPostal)
        ->select(
            'domicilio.idDomicilio'
        )
        ->get();
        return $idcom;
    }
    public function busca3($email){
        $email = DB::table('comandancia')
        ->where('email','=',$email)
        ->select(
            'comandancia.email'
        )
        ->get();
        return $email;
    }
    public function exit_tel($numeroTelefonico){
        $numeroTelefonico = DB::table('agendacomandancia')
        ->where('agendacomandancia.numeroTelefonico','=',$numeroTelefonico)
        ->select(
            'agendacomandancia.numeroTelefonico'
        )
        ->get();
        return $numeroTelefonico;
    }
    public function destroy($idComandancia){
        $del = Comandancia::find($idComandancia);
        $del ->delete();
        return $del;
    }
    public function updateVigencia(Request $request, $idplaca){
        $placa = Placa::find($idplaca);
        $placa -> fill($request -> all());
        $placa ->  disponible = 1;
        $placa -> save();
        return $placa;
    }
    public function updateVigencia2(Request $request, $idplaca){
        $placa = Placa::find($idplaca);
        $placa -> fill($request -> all());
        $placa ->  disponible = 0;
        $placa -> save();
        return $placa;
    }
}
