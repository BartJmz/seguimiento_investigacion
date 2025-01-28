<?php

namespace App\Http\Controllers;

use App\Adscripcion;
use App\Movimiento;
use App\Comandancia;
use App\Persona;
use App\Cargo;
use App\Placa;
use App\NombramientoDisponible;
use App\NombramientoPlacaPersonal;
use App\FechaModiciacion;
use App\Permisos;

use Illuminate\Http\Request;
use App\http\Requests\ComandanciaForm;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response; 
use DB;
class AdscripcionController extends Controller
{
    //
    public function index(){
        $adscripcion = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('region','comandancia.RegionRegion', '=','region.idRegion')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->select(
        'adscripcion.idAdscripcion',
        'adscripcion.idComandanciaAds',
        'adscripcion.fechaMovimiento',
        'movimientopersonal.movimiento',
        'comandancia.idComandancia',
        'comandancia.nombreComandancia',
        'region.idRegion',
        'region.nombreRegion',
        'adscripcion.vigente',
        'adscripcion.encargado',
        'adscripcion.observaciones',
        'personalaei.idPersonalAEI',
        'personalaei.operativo',
        'persona.nombrePersona',
        'persona.apPat',
        'persona.apMat',
        'persona.curp'
        )
        ->get();
        return $adscripcion;
    } 
    public function idadscripcion_por_comandancia($idComandanciaAds){
        $adscripcion = DB::table('adscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI') 
        ->join('persona','personalaei.personaID', '=','persona.idPersona')     
        ->join('nombramientodisponible','adscripcion.placa_uso', '=','nombramientodisponible.placa')          
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')               
        ->where('adscripcion.idComandanciaAds', '=', $idComandanciaAds)
        ->where('adscripcion.estatus', '=', 1)
        ->select(
            'adscripcion.idAdscripcion',
            'adscripcion.idComandanciaAds',
            'adscripcion.idPersonalAEIAds',
            'adscripcion.idMovimeintoPersonalAEI',
            'adscripcion.fechaIngreso',
            'adscripcion.fechaMovimiento',
            'adscripcion.vigente',
            'adscripcion.encargado',
            'adscripcion.observaciones',
            'adscripcion.placa_uso',
            'comandancia.nombreComandancia',
            'movimientopersonal.movimiento',
            'personalaei.idPersonalAEI',
            'personalaei.operativo',
            'personalaei.cuip',
            'personalaei.viaIngreso',
            'personalaei.cartillaSmn',
            'personalaei.emailAEI',
            'personalaei.personaID',
            'persona.idPersona',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.fechaNacimiento',
            'persona.curp',
            'persona.rfc',
            'persona.imss',
            'persona.estadoCivil',
            'persona.escolaridad',
            'persona.ocupacion',
            'persona.sexo',
            'persona.tipoSanguineo',
            'persona.edadAparente',
            'persona.alias',
            'persona.observaciones',
            'persona.lugarDeNacimiento',
            'cargos.Descripcion',
            'nombramientodisponible.placa'
        )
        ->get();
        return $adscripcion;
    } 
    public function personal_carpetaInv($idpersonalaeicarpeta){
        $adscripcion = DB::table('carpetadeinvestigacion')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv', '=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta', '=','personalaei.idPersonalAEI') 
        ->join('persona','personalaei.personaID', '=','persona.idPersona')            
        ->join('delito','carpetadeinvestigacion.tipoDelito', '=','delito.idDelito')               
        ->where('carpetainvpersonal.idpersonalaeicarpeta', '=', $idpersonalaeicarpeta)
        ->where('carpetainvpersonal.ecargado_vigente', '=', 1)
        ->select(
            'carpetadeinvestigacion.CarpetaInvestigacion','carpetadeinvestigacion.FechaHoraInicio','carpetadeinvestigacion.FechaHoraConsignacion','carpetadeinvestigacion.Estatus','delito.nombredelito','carpetainvpersonal.responsable','persona.apPat','persona.apMat','persona.nombrePersona','carpetainvpersonal.idpersonalaeicarpeta'
        )
        ->get();
        return $adscripcion;
    } 
    //
    public function personal_carpetaInvResponsable($idpersonalaeicarpeta){
        $adscripcion = DB::table('carpetadeinvestigacion')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv', '=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta', '=','personalaei.idPersonalAEI') 
        ->join('persona','personalaei.personaID', '=','persona.idPersona')            
        ->join('delito','carpetadeinvestigacion.tipoDelito', '=','delito.idDelito')               
        ->where('carpetainvpersonal.idpersonalaeicarpeta', '=', $idpersonalaeicarpeta)
        ->where('carpetainvpersonal.ecargado_vigente', '=', 1)
        ->select(
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'delito.nombredelito',
            'carpetainvpersonal.responsable',
            'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona',
            'carpetainvpersonal.idpersonalaeicarpeta',
            'carpetainvpersonal.idcarpetainvpersonal'
        )
        ->get();
        return $adscripcion;
    } 
   //Paso 1. Mostrar todas las comandancias.
    /* YO PUEDO HACER LA CONSULTA EN BASE A LAS ADSCRIPCIONES POR COMANDANCIA
*/
    public function verCatidadAdsPorComandancia(){
        $tabla = DB::select(
        'SELECT 
        comandancia.idComandancia as idComandanciaAds,
        comandancia.nombreComandancia as COMANDANCIA, 
        region.nombreRegion as REGION,
        COUNT(adscripcion.idComandanciaAds) AS TOTAL
        FROM adscripcion
        INNER JOIN comandancia ON adscripcion.idComandanciaAds = comandancia.idComandancia
        INNER JOIN region ON comandancia.regionRegion = region.idRegion
        WHERE adscripcion.estatus = 1
        GROUP BY comandancia.idComandancia, comandancia.nombreComandancia, region.nombreRegion',[]);        
        return $tabla;
    }
    //Funcion Estado de fuerza.
    public function getestadovehiculos(){
        $tabla = DB::select(
            'SELECT
            plantillavehiculo.idplantillaVehiculo,
            plantillavehiculo.idAsignacionComandancia,
            comandancia.nombreComandancia,
            COUNT(plantillavehiculo.idplantillaVehiculo) as total2
            FROM
            plantillavehiculo
            INNER JOIN vehiculo ON plantillavehiculo.idVehiculoAsignado = vehiculo.numeroSerie
            INNER JOIN movimientovehiculo ON plantillavehiculo.tipoAsignacion = movimientovehiculo.idMovimientovehiculo
            INNER JOIN comandancia ON plantillavehiculo.idAsignacionComandancia = comandancia.idComandancia
            WHERE plantillavehiculo.tipoAsignacion = 2
            GROUP BY plantillavehiculo.idplantillaVehiculo,plantillavehiculo.idAsignacionComandancia,comandancia.nombreComandancia
            ',[]);        
            
        /*
         plantillavehiculo.idplantillaVehiculo,
            plantillavehiculo.idAsignacionComandancia,
            comandancia.nombreComandancia,
            movimientovehiculo.movimientovehiculo,
            plantillavehiculo.tipoAsignacion

        $tabla = DB::select(
        'SELECT 
        plantillavehiculo.idAsignacionComandancia,
        COUNT(plantillavehiculo.idplantillaVehiculo) AS total2 
        FROM  plantillavehiculo       
        INNER JOIN comandancia ON plantillavehiculo.idAsignacionComandancia = comandancia.idComandancia
        GROUP BY plantillavehiculo.idplantillaVehiculo, plantillavehiculo.tipoAsignacion,  plantillavehiculo.idAsignacionComandancia',[]);        
        
        */
        return $tabla;
    }
     //Funcion estado de fuerza vehiculos.
     public function getestadoarmas(){
        $tabla = DB::select(
        'SELECT
        adscripcion.idComandanciaAds,
        count(personalmovimientoarma.idArmaMovimiento) as total
        FROM  adscripcion      
        INNER JOIN personalaei ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
        INNER JOIN personalmovimientoarma ON personalmovimientoarma.idPersonalAEIArma = personalaei.idPersonalAEI
        INNER JOIN arma ON personalmovimientoarma.idArmaMovimiento = arma.matricula
        WHERE
        adscripcion.estatus = 1 AND
        personalmovimientoarma.status_arma = 1
        GROUP BY
        adscripcion.idComandanciaAds',[]);        
        return $tabla;
    }
    public function getestadoarmasID($idComandanciaAds){
        $tabla = DB::select(
        'SELECT
        personalaei.cuip,
        arma.matricula,
        marcaarma.marca,
        calibrearma.calibre,
        tipoarma.tipoArama,
        clasearma.claseArma


        FROM  adscripcion      
        INNER JOIN personalaei ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
        INNER JOIN personalmovimientoarma ON personalmovimientoarma.idPersonalAEIArma = personalaei.idPersonalAEI
        INNER JOIN arma ON personalmovimientoarma.idArmaMovimiento = arma.matricula        
        INNER JOIN marcaarma ON arma.marca = marcaarma.idMarcaArma
        INNER JOIN calibrearma ON arma.calibre = calibrearma.idCalibre
        INNER JOIN tipoarma ON arma.tipoArma = tipoarma.idtipoArma
        INNER JOIN clasearma ON arma.clase_arma = clasearma.idClaseArma
        WHERE
        adscripcion.idComandanciaAds = ? AND
        adscripcion.estatus = 1 AND
        personalmovimientoarma.status_arma = 1',[$idComandanciaAds]);        
        return $tabla;
    }
    public function comandanciapersonal($idComandanciaAds){
        $adscripcioncomandancia = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('idComandanciaAds','=',$idComandanciaAds)
        ->select(
        //'adscripcion.idAdscripcion',
        'adscripcion.idComandanciaAds',
        'comandancia.idComandancia',
        'comandancia.nombreComandancia',
        //'adscripcion.fechaMovimiento',
        'movimientopersonal.movimiento',
        'adscripcion.fechaMovimiento',
        'adscripcion.vigente',
        'adscripcion.encargado',
        //'adscripcion.observaciones',
        'personalaei.idPersonalAEI',
        'persona.nombrePersona',
        'persona.apPat',
        'persona.apMat',
        'persona.curp'
        )
        ->get();
        return $adscripcioncomandancia;
    }
     public function nombre($idComandanciaAds){
        $adscripcioncomandancia = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('idComandanciaAds','=',$idComandanciaAds)
        ->select(
        'comandancia.nombreComandancia'
        )
        ->get();
        return $adscripcioncomandancia;
    }
    public function movimiento(){
        $movimiento = Movimiento:: get();
        return $movimiento;
    }
    public function saveAdscripcion(Request $request){
        $ads= new Adscripcion();
        $ads -> fill($request -> all());
        $ads->save();
        return $ads;
    }
    public function savefechaAds(Request $request){
        $adsFecha= new FechaModiciacion();
        $adsFecha -> fill($request -> all());
        $adsFecha->save();
        return $adsFecha;
    }
    public function savePermiso(Request $request){
        $permisos= new Permisos();
        $permisos -> fill($request -> all());
        $permisos->save();
        return $permisos;
    }
    public function saveNomDis(Request $request){
        $nom= new NombramientoPlacaPersonal();
        $nom -> fill($request -> all());
        $nom -> estatus = 1;
        $nom->save();
        return $nom;
    }
    public function updatePlaca(Request $request, $idplaca){
        $placa = Placa::find($idplaca);
        $placa -> fill($request -> all());
        $placa -> save();
        return $placa;
       // return var_dump($comandancias);
    }    
    public function updateDisponibleADS(Request $request, $idAdscripcion){
        $updateDisponibleADS = Adscripcion::find($idAdscripcion);
        $updateDisponibleADS -> fill($request -> all());
        $updateDisponibleADS -> save();
        return $updateDisponibleADS;
       // return var_dump($comandancias);
    }
    public function asignarEncargado(Request $request, $idAdscripcion){
        $asignarEncargado = Adscripcion::find($idAdscripcion);
        $asignarEncargado -> fill($request -> all());
        $asignarEncargado -> save();
        return $asignarEncargado;
    }
    public function updatePlaca2(Request $request, $idplacapersonal){
        $placa = Placa::find($idplacapersonal);
        $placa -> fill($request -> all());
        $placa ->  disponible = 1;
        $placa -> save();
        return $placa;
       // return var_dump($comandancias);
    }
    public function updateNombramientoPlaca(Request $request, $idNombramientoPersonal)
    {
        $nombramientoplaca = NombramientoPlacaPersonal::find($idNombramientoPersonal);
        $nombramientoplaca -> fill($request -> all());
        $nombramientoplaca ->  estatus = 0;
        $nombramientoplaca -> save();
        return $nombramientoplaca;
    }
    public function exitcurp($curp){
        $ads = DB::table('persona')
        ->where('persona.curp','=',$curp)
        ->select('persona.idPersona')
        ->get();
        return $ads;
    }
    public function exitpersonalaei($personaID){
        $ads = DB::table('personalaei')
        ->where('personalaei.personaID','=',$personaID)
        ->select('personalaei.idPersonalAEI')
        ->get();
        return $ads;
    }
    public function exiteplaca($personaID){
        $ads = DB::table('personalaei')
        ->where('personalaei.personaID','=',$personaID)
        ->select('personalaei.idPersonalAEI')
        ->get();
        return $ads;
    }
    public function exiteplacaNom ($idNombramientoDisponible){
        $ads = DB::table('nombramientodisponible')
        ->where('nombramientodisponible.idNombramientoDisponible','=',$idNombramientoDisponible)
        ->select('nombramientodisponible.placa')
        ->get();
        return $ads;
    }
    public function buscaplacadis ($idNombramientoDisponible){
        $ads = DB::table('nombramientodisponible')
        ->where('nombramientodisponible.placa','=',$idNombramientoDisponible)
        ->select('nombramientodisponible.idNombramientoDisponible')
        ->get();
        return $ads;
    }
    public function exitcurpAds($id){
        $user = DB::table('adscripcion')
        ->where('adscripcion.idPersonalAEIAds','=',$id)
        ->get();
        return $user;
    }
    
     public function getMov(){
        $mov = DB::table('movimientopersonal')
        ->select('movimientopersonal.movimiento')
        ->get();
         return $mov;
     }
     public function getComandanciaads(){
        $comandancia = DB::table('comandancia')
        ->select(
            'comandancia.idComandancia',
            'comandancia.nombreComandancia')
        ->get();
         return $comandancia;
     }
     
     public function getAdsID($idPersonalAEIAds){
        $ads = DB::table('adscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom', '=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponibleNom', '=','nombramientodisponible.idNombramientoDisponible')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->where('adscripcion.idPersonalAEIAds','=',$idPersonalAEIAds)
        ->where('nombramientoplacapersonal.estatus','=', 1)
        ->where('adscripcion.vigente','=',1)
        ->select(
            'comandancia.nombreComandancia',
            'adscripcion.idAdscripcion',
            'adscripcion.idComandanciaAds',
            'adscripcion.idPersonalAEIAds',
            'adscripcion.fechaMovimiento',
            'movimientopersonal.movimiento',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'adscripcion.vigente',
            'adscripcion.encargado',
            'adscripcion.observaciones',
            'nombramientodisponible.placa',
            'cargos.Descripcion',
            'persona.idPersona'
            )
        ->get();
        return $ads;
    }
    public function getAdsv1($idPersonalAEIAds){
        $ads = DB::table('adscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom', '=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponibleNom', '=','nombramientodisponible.idNombramientoDisponible')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->where('adscripcion.idPersonalAEIAds','=',$idPersonalAEIAds)
        ->where('adscripcion.vigente','=', 0)
        ->select(
            'adscripcion.idPersonalAEIAds',
            'nombramientodisponible.idNombramientoDisponible',
            'nombramientodisponible.placa',
            'persona.idPersona'
            )
        ->limit(1)    
        ->get();
        return $ads;
    }
    public function getAdsID2($idPersonalAEI){
        $ads = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('nombramientodisponible','adscripcion.placa_uso', '=','nombramientodisponible.placa')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        
        ->where('adscripcion.idPersonalAEIAds','=',$idPersonalAEI)
        ->where('movimientopersonal.idMovimientoPersonal','!=', 4)
        ->select(
            'movimientopersonal.movimiento',
            'comandancia.nombreComandancia',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'nombramientodisponible.placa',
            'cargos.Descripcion',
            'adscripcion.fechaMovimiento',
            'adscripcion.observaciones'
            )
         
        /*
        ->groupBy(
            'nombramientoplacapersonal.estatus',
            'nombramientodisponible.placa', 
            'cargos.Descripcion',
            'nombramientoplacapersonal.fechaNombramiento'
        )
        */
        ->get();
        return $ads;
    }
    public function getAdsID3($idComandancia){
        $ads = DB::table('adscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI', '=','movimientopersonal.idMovimientoPersonal')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom', '=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponibleNom', '=','nombramientodisponible.idNombramientoDisponible')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->where('adscripcion.idPersonalAEIAds','=',$idComandancia)
        ->where('movimientopersonal.idMovimientoPersonal','=', 4)
        ->select(
            'comandancia.nombreComandancia',
            'adscripcion.idAdscripcion',
            'adscripcion.idComandanciaAds',
            'adscripcion.idPersonalAEIAds',
            'adscripcion.fechaMovimiento',
            'movimientopersonal.idMovimientoPersonal',
            'movimientopersonal.movimiento',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'adscripcion.vigente',
            'adscripcion.encargado',
            'adscripcion.observaciones',
            'nombramientodisponible.placa',
            'cargos.Descripcion'
            )
        ->get();
        return $ads;
    }
    /*
     public function getAdsID4($idPersonalPermiso){
        $ads = DB::table('permisos')
        ->join('personalaei','permisos.idPersonalPermiso', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('permisos.idPersonalPermiso','=', $idPersonalPermiso)
        ->select(
            'personalaei.idPersonalAEI',
            'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona',
            'permisos.folio',
            'permisos.fechaInicial',
            'permisos.fechaTermino',
            'permisos.motivos',
            'permisos.canDias'
            
            )
        ->get();
        return $ads;
    }
    EJEMPLO     
    }     
     */
    public function getAdsID4($idPersonalPermiso){
        $ads = DB::table('permisos')
        ->join('personalaei','permisos.idPersonalPermiso', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('permisos.idPersonalPermiso','=', $idPersonalPermiso)
        ->select(
            'personalaei.idPersonalAEI',
            'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona',
            'permisos.folio',
            'permisos.fechaInicial',
            'permisos.fechaTermino',
            'permisos.motivos',
            'permisos.canDias'
            
            )
        ->get();
        return $ads;
    }
    public function updateAdscripcion(Request $request, $idAdscripcion){
        $Ads = Adscripcion::find($idAdscripcion);
        $Ads -> fill($request -> all());
        $Ads -> save();
        return $Ads;
       // return var_dump($comandancias);
    }
    public function nombramientoplaca($idPersonalAEIAds){
        $nombramientoplaca = DB::table('nombramientoplacapersonal')
        ->where('nombramientoplacapersonal.idPersonalAEINom','=', $idPersonalAEIAds)
        ->where('nombramientoplacapersonal.estatus','=', 1)
        ->select(
            /*
            'nombramientoplacapersonal.fechaNombramiento',
            'nombramientoplacapersonal.fechaNombramiento',
            'nombramientoplacapersonal.idPersonalAEINom',
            'nombramientoplacapersonal.idNombramientoDisponibleNom',
            */
            'nombramientoplacapersonal.idNombramientoPersonal',
            'nombramientoplacapersonal.idNombramientoDisponibleNom',
            'nombramientoplacapersonal.estatus'
            
            )
        ->get();
        return $nombramientoplaca;
    }
    public function vehiculoComandancia($idAsignacionComandancia){
        $vehiculo = DB::table('plantillavehiculo')
        ->join('vehiculo','plantillavehiculo.idVehiculoAsignado', '=','vehiculo.numeroSerie')
        ->where('plantillavehiculo.idAsignacionComandancia', '=', $idAsignacionComandancia)
        ->select(
            'plantillavehiculo.idVehiculoAsignado',
            'plantillavehiculo.idAsignacionComandancia',
            'plantillavehiculo.fechaAsignacion',
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
            'vehiculo.ObservacionesVehiculo',
            'vehiculo.status'
        )
        ->get();
        return $vehiculo;
    } 
    
}
