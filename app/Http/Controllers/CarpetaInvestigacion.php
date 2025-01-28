<?php

namespace App\Http\Controllers;


use App\CarpetaDeInvestigacion;
use App\CarpetaDeIvPersonal;
use App\Delito;
use App\ModoTipoDelito;
use App\Diligencias;
use App\CarpetaDiligencias;
use App\InputadoVictima;
use App\PersonaDiligencia;
use App\Planeacion;
use App\PlaneacionDes;

use App\Hechos;

use App\ActaDLT;
use App\LugarIntervencion;
use App\Ministerio;
use App\SenalVisiblesCadaver;
use App\VestimentaCadaver;

use App\TipoBienes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


use Illuminate\Support\Facades\Response;
//use DB;

class CarpetaInvestigacion extends Controller
{
    //
    public function getDiligencias(){
        //$Diligencias = Diligencias::get();
        $Diligencias = DB :: table ('diligencias')
        ->select(
            'diligencias.idDiligencias',
            'diligencias.nombreDiligencias'
            )
        ->orderBy('diligencias.idDiligencias', 'asc')
        ->get();
        return $Diligencias;
    }
    /*
    public function indexV1($idComandancia){
        $carpetas1 = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('comandancia','carpetadeinvestigacion.comandaciacapinv','=','comandancia.idComandancia')
        ->where('comandancia.idComandancia','=',$idComandancia)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.tipoDelito',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'comandancia.idComandancia',
            'comandancia.nombreComandancia'
            )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetas1;   
    }*/
    public function indexV1($idComandancia){
        @semaforo1;
        @semaforo2;
        @semaforo3;
        @auxiliar;
        $tabla = DB::select('SELECT
            @semaforo1 = "" as semaforo1,
            @semaforo1 = "" as semaforo2,
            @semaforo1 ="" as semaforo3,         
            @auxiliar = "" as auxiliar, 
            carpetadeinvestigacion.idCarpetaInvestigacion as idCarpetaInvestigacion, 
            hechos.fecha as fecha,
            carpetadiligencias.idCarpetaInvDiligencia as CarpetaInvestigacion,carpetadeinvestigacion.FechaHoraInicio as FechaHoraInicio,carpetadeinvestigacion.FechaHoraConsignacion as FechaHoraConsignacion,
            carpetadeinvestigacion.Estatus,personalaei.idPersonalAEI as idPersonalAEI,delito.nombredelito as nombredelito,
            SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN ( carpetadiligencias.cantidad) ELSE 0 END) AS REALIZADAS,
            SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END) AS CANTITDAD

        FROM carpetadiligencias
        INNER JOIN carpetadeinvestigacion ON carpetadiligencias.idCarpetaInvDiligencia = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN hechos ON carpetadeinvestigacion.CarpetaInvestigacion =  hechos.carpetainv
        INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
        INNER JOIN carpetainvpersonal ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN comandancia ON carpetadeinvestigacion.comandaciacapinv = comandancia.idComandancia                    
        WHERE comandancia.idComandancia = ? AND
        carpetainvpersonal.ecargado_vigente = 1 AND
        carpetadeinvestigacion.Estatus != "CONCLUIDA"
        GROUP BY  carpetadeinvestigacion.idCarpetaInvestigacion, hechos.fecha,carpetadiligencias.idCarpetaInvDiligencia, delito.nombredelito, carpetadeinvestigacion.FechaHoraInicio, 
        carpetadeinvestigacion.FechaHoraConsignacion, carpetadeinvestigacion.Estatus, personalaei.idPersonalAEI', [$idComandancia]);
        //return $tabla;
        if(!$tabla){
            return;
        }
       
        return Response::json($tabla, 200); 
    }
    public function indexV2($idComandancia){
        $tabla = DB::select('SELECT
            carpetadeinvestigacion.idCarpetaInvestigacion as idCarpetaInvestigacion,carpetadiligencias.idCarpetaInvDiligencia as CarpetaInvestigacion,carpetadeinvestigacion.FechaHoraInicio as FechaHoraInicio,carpetadeinvestigacion.FechaHoraConsignacion as FechaHoraConsignacion,
            carpetadeinvestigacion.Estatus,personalaei.idPersonalAEI as idPersonalAEI,delito.nombredelito as nombredelito,
            SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN 1 ELSE 0 END) * 100 AS REALIZADAS,
            SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END) AS CANTITDAD

        FROM carpetadiligencias
        INNER JOIN carpetadeinvestigacion ON carpetadiligencias.idCarpetaInvDiligencia = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
        INNER JOIN carpetainvpersonal ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN comandancia ON carpetadeinvestigacion.comandaciacapinv = comandancia.idComandancia                        
        WHERE comandancia.idComandancia = ? AND
        carpetainvpersonal.ecargado_vigente = 1 AND
        carpetadeinvestigacion.Estatus = "CONCLUIDA"
        GROUP BY  carpetadeinvestigacion.idCarpetaInvestigacion, carpetadiligencias.idCarpetaInvDiligencia, delito.nombredelito, carpetadeinvestigacion.FechaHoraInicio, 
        carpetadeinvestigacion.FechaHoraConsignacion, carpetadeinvestigacion.Estatus, personalaei.idPersonalAEI', [$idComandancia]);
        //return $tabla;
        if(!$tabla){
            return;
        }
       
        return Response::json($tabla, 200); 
    }
    public function SinResponsable(){
        $tabla = DB::select('SELECT
        carpetainvpersonal.idcarpetainv,
        persona.apPat,
        persona.apMat,
        persona.nombrePersona,
        nombramientodisponible.placa,
        cargos.Descripcion,
        personalaei.idPersonalAEI                    
        FROM carpetainvpersonal
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN persona ON personalaei.personaID = persona.idPersona
        INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
        INNER JOIN nombramientodisponible ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible
        INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
        
        WHERE carpetainvpersonal.ecargado_vigente = 0', []);
    	return $tabla;
    }

    public function index1($idComandancia){
        $carpetas1 = DB :: table ('comandancia')       
       
        ->where('comandancia.idComandancia','=',$idComandancia)
        ->select(           
            'comandancia.idComandancia',
            'comandancia.nombreComandancia'
            )
        ->get();
        //return $carpetas1;
        if(!$carpetas1){
            return;
        }
       
        return Response::json($carpetas1, 200);    
    }
    //
    public function info_planeacion($idplaneacion_des){
        $info_planeacion = DB :: table ('planeacion_des')              
        ->where('planeacion_des.idplaneacion_des','=',$idplaneacion_des)
        ->select(           
            'planeacion_des.descripcion'
            )
        ->get();
        if(!$info_planeacion){
            return;
        }
       
        return Response::json($info_planeacion, 200);    
    }
    public function rol_acta($idCarpetaInvDiligenciaPlaneacion){
        $planeacion = DB :: table ('planeacion')              
        ->where('planeacion.idCarpetaInvDiligenciaPlaneacion','=',$idCarpetaInvDiligenciaPlaneacion)
        ->where('planeacion.idDiligenciasCarpP','=',3)
        //->where('planeacion.estatus','=',0)
        ->select(           
            'planeacion.idplaneacion',
            'planeacion.idCarpetaInvDiligenciaPlaneacion',
            'planeacion.estatus',
            'planeacion.rol_victima'
            )
        ->get();
        if(!$planeacion){
            return;
        }
       
        return Response::json($planeacion, 200);    
    }
    //Actualizar planeacion estatus
    public function update_planeacion(Request $request, $idplaneacion){
        $updatePlaneacion = Planeacion::find($idplaneacion);
        $updatePlaneacion -> fill($request -> all());
        $updatePlaneacion -> save();
        return $updatePlaneacion;

    }    
    // Preguntamos por la notificación.
    public function notificación_activa($idPersonalAEI){
        $notificacion = DB :: table ('carpetainvpersonal')              
        ->where('carpetainvpersonal.notificar','=', 0 )
        ->where('carpetainvpersonal.idpersonalaeicarpeta','=', $idPersonalAEI )
        ->select(           
            'carpetainvpersonal.idcarpetainv',
            'carpetainvpersonal.notificar'
            )
        ->get();
        if(!$notificacion){
            return;
        }       
        return Response::json($notificacion, 200);    
    }
    /*
     EDITAMOS ESTA PARTE! AGREGANDO A  personalaei.idPersonalAEI
     */
    public function lista_prioridad($idComandancia){
        $tabla = DB::select('SELECT
        carpetainvpersonal.idcarpetainvpersonal,
        carpetainvpersonal.idcarpetainv,
        carpetadeinvestigacion.FechaHoraInicio,
        carpetadeinvestigacion.Estatus,
        personalaei.idPersonalAEI,
        carpetadeinvestigacion.CarpetaInvestigacion
        FROM carpetainvpersonal
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        WHERE
        personalaei.idPersonalAEI = ? AND
        carpetainvpersonal.ecargado_vigente = 1 AND
        carpetadeinvestigacion.Estatus NOT LIKE "CONCLUIDA"
        ORDER BY        
        carpetadeinvestigacion.FechaHoraInicio', [$idComandancia]);
    	return $tabla;
    }
    public function lista_prioridad2($idpersonalaeicarpeta){
        $tabla = DB::select('SELECT
        carpetainvpersonal.idcarpetainvpersonal,
        carpetainvpersonal.idcarpetainv,
        carpetadeinvestigacion.FechaHoraInicio,
        carpetadeinvestigacion.Estatus,
        personalaei.idPersonalAEI,
        carpetadeinvestigacion.CarpetaInvestigacion
        FROM carpetainvpersonal
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        WHERE
        carpetainvpersonal.idpersonalaeicarpeta = ? AND
        carpetainvpersonal.notificar = 0 AND
        carpetadeinvestigacion.Estatus NOT LIKE "CONCLUIDA"
        ORDER BY        
        carpetadeinvestigacion.FechaHoraInicio', [$idpersonalaeicarpeta]);
    	return $tabla;
    }
    //
    public function getInfoCarpeta($CarpetaInvestigacion){
        $domicilio = DB::table('carpetadeinvestigacion')
        /*       
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv', '=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito', '=','delito.idDelito')
        ->join('clasificaciondelito','carpetadeinvestigacion.tipomodoDelito', '=','clasificaciondelito.idclasificaciondelito')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta', '=','personalaei.idPersonalAEI')
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        */
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv', '=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('hechos','hechos.carpetainv', '=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('region','hechos.idregionhechos', '=','region.idRegion')
        ->join('regionalizacion','regionalizacion.region', '=','region.idRegion')        
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.tipoDelito',
            'carpetadeinvestigacion.tipomodoDelito',
            'carpetadeinvestigacion.comandaciacapinv',
            
            //
            'carpetainvpersonal.idcarpetainvpersonal',
            'carpetainvpersonal.idpersonalaeicarpeta',
            //Hechos
            'hechos.idhechos',
            'hechos.fecha',
            'hechos.idregionhechos',
            'hechos.distrito',
            'hechos.idmunicipio',
            'hechos.agencia',
            'hechos.colonia',
            'hechos.calle',
            'hechos.numero',
            'hechos.ubicacion',
            'hechos.referencia',
            'hechos.descripcion',

            'regionalizacion.region',
            'regionalizacion.idregionalizacion'
            )
        ->get();
        return $domicilio;
        }
        public function getActaDLT($CarpetaInvestigacion){
            $domicilio = DB::table('actadlt')                  
            ->where('actadlt.carpeta','=',$CarpetaInvestigacion)
            ->where('actadlt.tipoDiligencia','=','ACTADLT')
            ->select(
            'actadlt.idActaDLT',
            'actadlt.cve',
            'actadlt.dependencia',
            'actadlt.idMunicipio',
            'actadlt.idLocalidad',
            'actadlt.idrespondable',
            'actadlt.fechadecreacion',
            'actadlt.carpeta')
            ->get();
            return $domicilio;
            }
            public function getEntrevista($CarpetaInvestigacion){
                $domicilio = DB::table('actadlt')                  
                ->where('actadlt.carpeta','=',$CarpetaInvestigacion)
                ->where('actadlt.tipoDiligencia','=','ENTREVISTA')
                ->select(
                'actadlt.idActaDLT',
                'actadlt.cve',
                'actadlt.dependencia',
                'actadlt.idMunicipio',
                'actadlt.idLocalidad',
                'actadlt.idrespondable',
                'actadlt.fechadecreacion',
                'actadlt.carpeta')
                ->get();
                return $domicilio;
            }
            public function getInventarioBienes($CarpetaInvestigacion){
                $bienes = DB::table('actadlt')                  
                ->where('actadlt.carpeta','=',$CarpetaInvestigacion)
                ->where('actadlt.tipoDiligencia','=','INVENTARIO')
                ->select(
                'actadlt.idActaDLT',
                'actadlt.cve',
                'actadlt.dependencia',
                'actadlt.idMunicipio',
                'actadlt.idLocalidad',
                'actadlt.idrespondable',
                'actadlt.fechadecreacion',
                'actadlt.carpeta')
                ->get();
                return $bienes;
            }
            
        public function getInfoPersonaCarpeta($carpetaInvestigacionPersona){
            $InfoPersonaCarpeta = DB::table('inputado_victima')                    
            ->join('domicilio','inputado_victima.idcvedom', '=','domicilio.cve')            
                ->join('persona','inputado_victima.idPersona', '=','persona.idPersona')              
                ->join('regionalizacion','inputado_victima.distrito', '=','regionalizacion.idregionalizacion')                
                
                ->join('regionmunicipio','regionmunicipio.idregionalizacion', '=','regionalizacion.idregionalizacion')                            
                ->join('localidad','domicilio.localidadDomicilio', '=','localidad.idLocalidad')
                ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')            
                ->where('inputado_victima.carpetaInvestigacionPersona','=',$carpetaInvestigacionPersona)
                ->where('inputado_victima.tipopersona','=', 'INPUTADO')
                ->select(
                    'inputado_victima.carpetaInvestigacionPersona',
                    'inputado_victima.idinputado_victima',
                    'inputado_victima.distrito',
                    'inputado_victima.ubicacion',
                    'inputado_victima.nexos',                
                    'inputado_victima.tipopersona',
                    'domicilio.idDomicilio',
                    'domicilio.codigoPostal',
                    'domicilio.colonia',
                    'domicilio.nExterior',
                    'domicilio.calle',
                    'domicilio.referenciaDelLugar',
                    'domicilio.localidadDomicilio',
                    'domicilio.cve',
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
                    'regionalizacion.region',
                    'regionmunicipio.idmunicipio',
                    'regionmunicipio.idregionalizacion',
                    'localidad.cveMunicipioL',  
                    'municipio.idMunicipio',
                    'municipio.cveMunicipio'
                    )
                ->limit(1)
                ->get();
            return $InfoPersonaCarpeta;
            }
            public function getInfoPersonaCarpeta2($carpetaInvestigacionPersona){
                $InfoPersonaCarpeta = DB::table('inputado_victima')        
                ->join('domicilio','inputado_victima.idcvedom', '=','domicilio.cve')
                ->join('persona','inputado_victima.idPersona', '=','persona.idPersona')  
                ->join('regionalizacion','inputado_victima.distrito', '=','regionalizacion.idregionalizacion')
                ->join('regionmunicipio','regionmunicipio.idregionalizacion', '=','regionalizacion.idregionalizacion')
                ->join('localidad','domicilio.localidadDomicilio', '=','localidad.idLocalidad')
                ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
                ->where('inputado_victima.carpetaInvestigacionPersona','=',$carpetaInvestigacionPersona)
                ->where('inputado_victima.tipopersona','=', 'VICTIMA')
                ->select(
                    'inputado_victima.carpetaInvestigacionPersona',
                    'inputado_victima.idinputado_victima',
                    'inputado_victima.distrito',
                    'inputado_victima.ubicacion',
                    'inputado_victima.nexos',                
                    'inputado_victima.tipopersona',
                    'domicilio.idDomicilio',
                    'domicilio.codigoPostal',
                    'domicilio.colonia',
                    'domicilio.nExterior',
                    'domicilio.calle',
                    'domicilio.referenciaDelLugar',
                    'domicilio.localidadDomicilio',
                    'domicilio.cve',
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
                    'regionalizacion.region',
                    'regionmunicipio.idmunicipio',
                    'regionmunicipio.idregionalizacion',
                    'localidad.cveMunicipioL',
                    'municipio.idMunicipio',
                    'municipio.cveMunicipio'
                    )
                ->limit(1) 
                ->get();
                return $InfoPersonaCarpeta;
                }
    public function index($idComandancia){
        $carpetas = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('comandancia','carpetadeinvestigacion.idCarpetaInvestigacion','=','comandancia.idComandancia')
        ->join('region','comandancia.regionRegion','=','region.idRegion')
        ->join('agendacomandancia','agendacomandancia.idComandanciaFK','=','comandancia.nombreComandancia')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        //->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        ->where('carpetadeinvestigacion.comandaciacapinv','=',$idComandancia)
        ->select(
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'carpetadeinvestigacion.tipoDelito',
            //'comandancia.idComandancia',
            //'comandancia.nombreComandancia',
            'region.nombreRegion',
            'agendacomandancia.numeroTelefonico',
            'carpetainvpersonal.responsable',
            //'personalaei.cuip',
            //'personalaei.emailAEI',
            'persona.apPat',    
            'persona.apMat',
            'persona.nombrePersona'
            //'telefono.numeroTel'
        )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetas;   
    }
    /*
    public function index2($idComandancia){
        $carpetas1 = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('comandancia','carpetadeinvestigacion.comandaciacapinv','=','comandancia.idComandancia')
        ->where('comandancia.idComandancia','=',$idComandancia)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.tipoDelito',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'comandancia.idComandancia',
            'comandancia.nombreComandancia'
            )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetas1;   
    }
    */
    /*
    public function index2($idpersonalaeicarpeta){
        $carpetasAgent = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        ->where('carpetainvpersonal.idpersonalaeicarpeta','=',$idpersonalaeicarpeta)
        ->select(
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'carpetadeinvestigacion.tipoDelito',
            'carpetainvpersonal.responsable',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'personalaei.emailAEI',
            'persona.apPat',    
            'persona.apMat',
            'persona.nombrePersona',
            'telefono.numeroTel'
        )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetasAgent;   
    }
    */
    /**
     
     */
    public function index3($CarpetaInvestigacion){
        $carpetasAgent = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        ->where('carpetadeinvestigacion.Estatus','!=','CONCLUIDA')
        ->where('carpetainvpersonal.ecargado_vigente','=',1)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'carpetadeinvestigacion.tipoDelito',
            'carpetainvpersonal.responsable',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'personalaei.emailAEI',
            'persona.apPat',    
            'persona.apMat',
            'persona.nombrePersona',
            'telefono.numeroTel'
        )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetasAgent;   
    }
    public function index4($CarpetaInvestigacion){
        $carpetasDiligencias = DB :: table ('carpetadiligencias')
        ->join('diligencias','carpetadiligencias.idDiligenciasCarp','=','diligencias.idDiligencias')
        ->join('carpetadeinvestigacion','carpetadiligencias.idCarpetaInvDiligencia','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        ->select(
            'diligencias.idDiligencias',
            'diligencias.nombreDiligencias',
            'carpetadiligencias.idcarpetadiligencias',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadiligencias.estatus',
            'carpetadiligencias.cantidad',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito'
        )
        ->orderBy('diligencias.nombreDiligencias', 'asc')
        ->get();
        return $carpetasDiligencias;   
    }
    //Checar porque no esta correcto, no se compara que seha una solo comandancia.
    public function index5($carpetadeinvestigacion){
        $tabla = DB::select('SELECT  
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idDiligenciasCarpP = 1 AND idCarpetaInvDiligenciaPlaneacion = ?)
                INVENTARIO,
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idDiligenciasCarpP = 2 AND idCarpetaInvDiligenciaPlaneacion = ?)
                ACTA_DLTC,         
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idDiligenciasCarpP = 3 AND idCarpetaInvDiligenciaPlaneacion = ?)
                ENTREVISTA,
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idDiligenciasCarpP = 4 AND idCarpetaInvDiligenciaPlaneacion = ?)
                INFORME_ACTIVIADES,
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idDiligenciasCarpP = 5 AND idCarpetaInvDiligenciaPlaneacion = ?)
                TARJETA_INFORMATIVA,
                (SELECT COUNT(idDiligenciasCarpP) 
                FROM planeacion 
                WHERE idCarpetaInvDiligenciaPlaneacion = ?)
                TOTAL',[$carpetadeinvestigacion,$carpetadeinvestigacion,$carpetadeinvestigacion,$carpetadeinvestigacion,$carpetadeinvestigacion,$carpetadeinvestigacion]);
        return $tabla;
    }
    public function index6($CarpetaInvestigacion){
        $carpetasAgent = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        ->where('carpetadeinvestigacion.Estatus','=','CONCLUIDA')
        ->where('carpetainvpersonal.ecargado_vigente','=',1)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'carpetadeinvestigacion.tipoDelito',
            'carpetainvpersonal.responsable',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'personalaei.emailAEI',
            'persona.apPat',    
            'persona.apMat',
            'persona.nombrePersona',
            'telefono.numeroTel'
        )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetasAgent;   
    }
    public function index7($CarpetaInvestigacion){
        $carpetasAgent = DB :: table ('carpetadeinvestigacion')
        ->join('delito','carpetadeinvestigacion.tipoDelito','=','delito.idDelito')
        ->join('carpetainvpersonal','carpetainvpersonal.idcarpetainv','=','carpetadeinvestigacion.CarpetaInvestigacion')
        ->join('personalaei','carpetainvpersonal.idpersonalaeicarpeta','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$CarpetaInvestigacion)
        ->where('carpetainvpersonal.ecargado_vigente','=',1)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion',
            'carpetadeinvestigacion.FechaHoraInicio',
            'carpetadeinvestigacion.FechaHoraConsignacion',
            'carpetadeinvestigacion.Estatus',
            'carpetadeinvestigacion.Observaciones',
            'carpetadeinvestigacion.comandaciacapinv',
            'delito.nombredelito',
            'carpetadeinvestigacion.tipoDelito',
            'carpetainvpersonal.responsable',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'personalaei.emailAEI',
            'persona.apPat',    
            'persona.apMat',
            'persona.nombrePersona',
            'telefono.numeroTel'
        )
        ->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get();
        return $carpetasAgent;   
    }
    //
    public function getDelito(){
        $delito = Delito::get();
         return $delito;
    }
    public function getTipoModoDelito(){
        $tipomododelito = ModoTipoDelito::get();
         return $tipomododelito;
    }
    public function getPersonalComandancia($idComandancia){
        $carpetas = DB :: table ('adscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds','=','comandancia.idComandancia')
        ->join('personalaei','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom','=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','adscripcion.placa_uso','=','nombramientodisponible.placa')
        ->join('users','users.personalaeiUser','=', 'personalaei.idPersonalAEI')
        ->where('comandancia.idComandancia','=',$idComandancia)
        ->where('nombramientoplacapersonal.estatus','=', 1)
        ->where('adscripcion.estatus','=', 1)
        ->where('users.status','=', 1)
        ->where('users.idRolesUser','!=', 10)
        ->select(   
            'comandancia.nombreComandancia',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'personalaei.idPersonalAEI',
            //'personalaei.cuip',
            'nombramientodisponible.placa',
            'users.idRolesUser'
        )
        //->orderBy('carpetadeinvestigacion.FechaHoraInicio', 'asc')
        ->get(); 
        if(!$carpetas){
            return;
        }
       
        return Response::json($carpetas, 200); 
    }
    public function getpersonalComandanciaCarpeta($idComandancia){
        $tabla = DB::select('SELECT
        persona.nombrePersona,
        persona.apPat,
        persona.apMat,
        personalaei.idPersonalAEI
        FROM carpetainvpersonal
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        INNER JOIN persona ON personalaei.personaID = persona.idPersona
        INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        WHERE carpetadeinvestigacion.comandaciacapinv = ? AND
        carpetainvpersonal.ecargado_vigente = 1
        GROUP BY 
        persona.nombrePersona,
        persona.apPat,
        persona.apMat,
        personalaei.idPersonalAEI', [$idComandancia]);
    	return $tabla;
    }
    //Validaciones
    public function exiteCarpetaInv($carpetadeinvestigacion){
        $ext = DB :: table ('carpetadeinvestigacion')       
        ->where('carpetadeinvestigacion.CarpetaInvestigacion','=',$carpetadeinvestigacion)
        ->select(
            'carpetadeinvestigacion.idCarpetaInvestigacion',
            'carpetadeinvestigacion.CarpetaInvestigacion'
            )            
        ->get();
        return $ext;   
    }
    //
    public function saveCarpetaInv(Request $request){
        $carpInv= new CarpetaDeInvestigacion();
        $carpInv -> fill($request -> all());
        $carpInv->save();
        return $carpInv;
    }
    public function saveCarpetaInvPersona(Request $request){
        $carpInvPersona= new CarpetaDeIvPersonal();
        $carpInvPersona -> fill($request -> all());
        $carpInvPersona->save();
        return $carpInvPersona;
    }
    /*
    public function saveCarpetaInvDiligencias(Request $request){
        $carpInvDiligencias= new CarpetaDiligencias();
        $carpInvDiligencias -> fill($request -> all());
        $carpInvDiligencias->save();
        return $carpInvDiligencias;
    }
    Modificamos.
    */
    public function saveCarpetaInvDiligencias(Request $request){
        $arrayDiligencia = $request->input('arreglo'); 
        foreach ($arrayDiligencia as $key => $objDiligencia) {
            DB::table('carpetadiligencias')->insert($objDiligencia);
        }
    }
    public function saveHechos(Request $request){
        $carpetahechos= new Hechos();
        $carpetahechos -> fill($request -> all());
        $carpetahechos->save();
        return $carpetahechos;
    }
    public function saveInputadoVictima(Request $request){
        $inputadovictima= new InputadoVictima();
        $inputadovictima -> fill($request -> all());
        $inputadovictima->save();
        return $inputadovictima;
    }
    public function updateCarpeta(Request $request, $CarpetaInvestigacion){
        $updateCarpeta = CarpetaDeInvestigacion::find($CarpetaInvestigacion);
        $updateCarpeta -> fill($request -> all());
        $updateCarpeta -> save();
        return $updateCarpeta;
       // return var_dump($comandancias);
    }    
    public function update_Notificacion(Request $request, $idCarpetaInvestigacion){
        $updateNotificacion = CarpetaDeIvPersonal::find($idCarpetaInvestigacion);
        $updateNotificacion -> fill($request -> all());        
        $updateNotificacion ->  notificar = 1;
        $updateNotificacion -> save();
        return $updateNotificacion;
       // return var_dump($comandancias);
    }    
    public function update_hechos_carpeta(Request $request, $idhechos){
        $updateCarpetaHechos = Hechos::find($idhechos);
        $updateCarpetaHechos -> fill($request -> all());
        $updateCarpetaHechos -> save();
        return $updateCarpetaHechos;
       // return var_dump($comandancias);
    }
    public function update_responsable_carpeta(Request $request, $idcarpetainvpersonal){
        $updateCarpetaResponsable = CarpetaDeIvPersonal::find($idcarpetainvpersonal);
        $updateCarpetaResponsable -> fill($request -> all());
        $updateCarpetaResponsable -> save();
        return $updateCarpetaResponsable;
    }
    public function update_responsable_carpeta2(Request $request){
        $arreglo = $request->input('editarResponsable');                 
         foreach ($arreglo as $key => $detalle) {        
            DB::table('carpetainvpersonal')
            ->where([
                ['idcarpetainvpersonal', '=', $detalle["idcarpetainvpersonal"] ],
            ])->update($detalle);        
        }   
    }    
    public function saveResponsableCarpeta(Request $request){
        $arrayCarpetaRes = $request->input('guardarResponsable');
          foreach ($arrayCarpetaRes as $key => $objResponsable) {
             DB::table('carpetainvpersonal')->insert($objResponsable);
         }
     }
    public function update_inputado_victima(Request $request, $idinputado_victima){
        $updateInputado_victima = InputadoVictima::find($idinputado_victima);
        $updateInputado_victima -> fill($request -> all());
        $updateInputado_victima -> save();
        return $updateInputado_victima;
       // return var_dump($comandancias);
    }
    //Actualizar estado dilgencias.
    public function updateEstatusDiligencia(Request $request, $idcarpetadiligencias){        
        $updateStatus = CarpetaDiligencias::find($idcarpetadiligencias);
        $updateStatus -> fill($request -> all());
        $updateStatus -> save();
        return $updateStatus;
       // return var_dump($comandancias);
    }
    // Funciones para la Planeacion.
    public function savePlaneacion(Request $request){
        $savePlaneacion= new Planeacion();
        $savePlaneacion -> fill($request -> all());
        $savePlaneacion->save();
        return $savePlaneacion;
    }
    public function savePlaneacionDes(Request $request){
        $savePlaneacionDes= new PlaneacionDes();
        $savePlaneacionDes -> fill($request -> all());
        $savePlaneacionDes->save();
        return $savePlaneacionDes;
    }
    //
    //METODO PARA GUARDAR DILIGENCIAS!!
    public function saveActaDLT(Request $request){
        $saveActaDLT= new ActaDLT();
        $saveActaDLT -> fill($request -> all());
        $saveActaDLT->save();
        return $saveActaDLT;
    }
    public function saveActaDLTlugarintervencion(Request $request){
        $lugarintervencion= new LugarIntervencion();
        $lugarintervencion -> fill($request -> all());
        $lugarintervencion->save();
        return $lugarintervencion;
    }
    public function saveActaDLTMinisterio(Request $request){
        $Ministerio= new Ministerio();
        $Ministerio -> fill($request -> all());
        $Ministerio->save();
        return $Ministerio;
    }
    public function saveSenalVisiblesCadaver(Request $request){
        $SenalVisiblesCadaver= new SenalVisiblesCadaver();
        $SenalVisiblesCadaver -> fill($request -> all());
        $SenalVisiblesCadaver->save();
        return $SenalVisiblesCadaver;
    }
    public function getcveDLT($cve){
        $cve = DB :: table ('actadlt')              
        ->where('actadlt.cve','=',$cve)
        ->select(           
            'actadlt.idActaDLT'
            )
        ->get();
        return $cve;   
    }
    public function saveVestimentaCadaver(Request $request){
        $VestimentaCadaver= new VestimentaCadaver();
        $VestimentaCadaver -> fill($request -> all());
        $VestimentaCadaver->save();
        return $VestimentaCadaver;
    }
    public function update_carpetadiligencias(Request $request, $idcarpetadiligencias){
        $updateCarpetaDiligencias = CarpetaDiligencias::find($idcarpetadiligencias);
        $updateCarpetaDiligencias -> fill($request -> all());
        $updateCarpetaDiligencias -> save();
        return $updateCarpetaDiligencias;
       // return var_dump($comandancias);
    }
    
    public function update_carpetaResponsable(Request $request, $idcarpetainvpersonal){
        $updateCarpetaDiligencias = CarpetaDeIvPersonal::find($idcarpetadiligencias);
        $updateCarpetaDiligencias -> fill($request -> all());
        $updateCarpetaDiligencias -> save();
        return $updateCarpetaDiligencias;
       // return var_dump($comandancias);
    }
    //Corregir consulta no esta correcta.
    public function getIdDiligencia($idCarpetaInvDiligencia){
        $cve = DB :: table ('carpetadiligencias')         
        ->where('carpetadiligencias.idCarpetaInvDiligencia','=', $idCarpetaInvDiligencia)     
        ->where('carpetadiligencias.idDiligenciasCarp','=', 3)
        ->select(           
            'carpetadiligencias.idcarpetadiligencias',
            'carpetadiligencias.cantidad'
            )
        ->get();
        return $cve;   
    }
    public function getIdDiligencia1($idCarpetaInvDiligencia){
        $cve = DB :: table ('carpetadiligencias')         
        ->where('carpetadiligencias.idCarpetaInvDiligencia','=', $idCarpetaInvDiligencia)     
        ->where('carpetadiligencias.idDiligenciasCarp','=', 2)
        ->select(           
            'carpetadiligencias.idcarpetadiligencias',
            'carpetadiligencias.cantidad'
            )
        ->get();
        return $cve;   
    }    

    //GENERAMOS DELITOS EN GENERAL.
    public function getTotalDelitos($comandaciacapinv){
    	$tabla = DB::select('
    		SELECT
            (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
                WHERE carpetadeinvestigacion.comandaciacapinv = ?
                AND delito.nombredelito = "ABIGEATO")
                ABIGEATO,
            (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion             
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?				
                AND delito.nombredelito = "ABUSO DE AUTORIDAD")
                ABUSO_DE_AUTORIDAD,
            (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion             
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?				
                AND delito.nombredelito = "ABUSO SEXUAL")
                ABUSO_SEXUAL,
            (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "AMENAZAS")
                AMENAZAS,
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito            
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "ASALTO")
                ASALTO,  
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "ATAQUES A LAS VIAS DE COMUNICACION")
                ATAQUE_VIAS_DE_COMUNICACION,
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "CONTRA LA SALUD")
                CONTRA_LA_SALUD,
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "DANOS")
                DANOS,      
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		 
                AND delito.nombredelito = "DESAPARICION DE PERSONA")
                DESAPARICION_DE_PERSONA,
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "DESPOJO")
                DESPOJO,
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "DISPARO DE ARMA DE FUEGO")
                DISPARO_DE_ARMA_DE_FUEGO,  
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "EL QUE SE CONFIGURE")
                EL_QUE_SE_CONFIGURE,   
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "ESTUPRO")
                ESTUPRO, 
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "EXTORSION")
                EXTORSION,  
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "FRAUDE")
                FRAUDE,   
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "HOMICIDIO")
                HOMICIDIO,  
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito                 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "LESIONES")
                LESIONES, 
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "OTROS DELITOS")
                OTROS_DELITOS,   
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "PERSONA NO LOCALIZADA")
                PERSONA_EXTRAVIADA,  
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "ROBO")
                ROBO, 
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "ROBO DE VEHICULO")
                ROBO_DE_VEHICULO,    
            (SELECT COUNT(delito.nombredelito) FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "VIOLACION")
                VIOLACION,            
            (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
				WHERE carpetadeinvestigacion.comandaciacapinv = ?		
                AND delito.nombredelito = "VIOLENCIA INTRAFAMILIAR")
                VIOLENCIA_INTRAFAMILIAR',
            [$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv,$comandaciacapinv]);
    	return $tabla;
    }
    public function getCantidadDeDelitos($carpetadeinvestigacion){
        $tabla = DB::select('SELECT           
                (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
                WHERE carpetadeinvestigacion.comandaciacapinv = ?)
                TOTAL',[$carpetadeinvestigacion]);
        return $tabla;
    }
    //ESTAMOS TRBAJANDO AQUI getCantidadCarpetasEstatus
    public function getCantidadCarpetasEstatus($carpetadeinvestigacion){
        $tabla = DB::select('SELECT           
                (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
                WHERE carpetadeinvestigacion.comandaciacapinv = ?
                AND carpetadeinvestigacion.Estatus = "APERTURA")
                APERTURA,
                (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
                WHERE carpetadeinvestigacion.comandaciacapinv = ?
                AND carpetadeinvestigacion.Estatus = "INVESTIGACION")
                INVESTIGACION,
                (SELECT COUNT(delito.nombredelito) 
                FROM carpetadeinvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito 
                WHERE carpetadeinvestigacion.comandaciacapinv = ?
                AND carpetadeinvestigacion.Estatus = "CONCLUIDA")
                CONCLUIDA',[$carpetadeinvestigacion,$carpetadeinvestigacion,$carpetadeinvestigacion]);
        return $tabla;
    }
    /*
     Añadimos solo una condicion: carpetainvpersonal.ecargado_vigente = 1
     */
    public function index2($idpersonalaeicarpeta){
        @semaforo1;
        @semaforo2;
        @semaforo3;
        @auxiliar;
        $tabla = DB::select('SELECT
            @semaforo1 = "" as semaforo1,
            @semaforo1 = "" as semaforo2,
            @semaforo1 ="" as semaforo3,      
            @auxiliar = "" as auxiliar, 
            carpetadiligencias.idCarpetaInvDiligencia as CarpetaInvestigacion,
            carpetadeinvestigacion.FechaHoraInicio as FechaHoraInicio,
            hechos.fecha as fecha,
            carpetadeinvestigacion.FechaHoraConsignacion as FechaHoraConsignacion,
            personalaei.idPersonalAEI as idPersonalAEI,
            delito.nombredelito as nombredelito,
            SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN (carpetadiligencias.cantidad) ELSE 0 END) AS REALIZADAS,
            SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END) AS CANTITDAD            

        FROM carpetadiligencias
        INNER JOIN carpetadeinvestigacion ON carpetadiligencias.idCarpetaInvDiligencia = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN hechos ON carpetadeinvestigacion.CarpetaInvestigacion =  hechos.carpetainv
        INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
        INNER JOIN carpetainvpersonal ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI

        
        WHERE carpetainvpersonal.idpersonalaeicarpeta = ? AND carpetadeinvestigacion.Estatus != "CONCLUIDA" AND carpetainvpersonal.ecargado_vigente = 1
        GROUP BY carpetadiligencias.idCarpetaInvDiligencia, hechos.fecha, delito.nombredelito, carpetadeinvestigacion.FechaHoraInicio, 
        carpetadeinvestigacion.FechaHoraConsignacion, personalaei.idPersonalAEI', [$idpersonalaeicarpeta]);
    	return $tabla;
    }
    public function getPlaneacionTotal(){
        $estadoCarpetas = DB::select('SELECT
        Count(planeacion.cantidadPlaneacion) AS cantidad,
        planeacion.idCarpetaInvDiligenciaPlaneacion
        FROM
        planeacion
        GROUP BY
        planeacion.idCarpetaInvDiligenciaPlaneacion',[]);
        return $estadoCarpetas;
    }
    
    public function index2Concluidas($idpersonalaeicarpeta){        
        $tabla = DB::select('SELECT 
            carpetadeinvestigacion.Estatus,
            carpetadiligencias.idCarpetaInvDiligencia as CarpetaInvestigacion,
            carpetadeinvestigacion.FechaHoraInicio as FechaHoraInicio,
            carpetadeinvestigacion.FechaHoraConsignacion as FechaHoraConsignacion,
            personalaei.idPersonalAEI as idPersonalAEI,
            delito.nombredelito as nombredelito,
            SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN 1 ELSE 0 END) * 100 AS REALIZADAS,
            SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END) AS CANTITDAD

        FROM carpetadiligencias
        INNER JOIN carpetadeinvestigacion ON carpetadiligencias.idCarpetaInvDiligencia = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
        INNER JOIN carpetainvpersonal ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        
        WHERE carpetainvpersonal.idpersonalaeicarpeta = ? AND
        carpetainvpersonal.ecargado_vigente = 1 AND
        carpetadeinvestigacion.Estatus = "CONCLUIDA"
        GROUP BY carpetadeinvestigacion.Estatus, carpetadiligencias.idCarpetaInvDiligencia, delito.nombredelito, carpetadeinvestigacion.FechaHoraInicio, 
        carpetadeinvestigacion.FechaHoraConsignacion, personalaei.idPersonalAEI', [$idpersonalaeicarpeta]);
    	return $tabla;
    }
    /*

    SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN 1 ELSE 0 END) * 100 / SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END)
    public function index2($idpersonalaeicarpeta){
        $tabla = DB::select('SELECT
            carpetadiligencias.idCarpetaInvDiligencia as CarpetaInvestigacion,
            carpetadeinvestigacion.FechaHoraInicio as FechaHoraInicio,
            carpetadeinvestigacion.FechaHoraConsignacion as FechaHoraConsignacion,
            personalaei.idPersonalAEI as idPersonalAEI,
            delito.nombredelito as nombredelito,
            SUM(CASE WHEN carpetadiligencias.cantidad > 0 THEN 1 ELSE 0 END) AS REALIZADAS,
            SUM(CASE WHEN carpetadiligencias.estatus = 1 THEN 1 ELSE 0 END) AS CANTITDAD

        FROM carpetadiligencias
        INNER JOIN carpetadeinvestigacion ON carpetadiligencias.idCarpetaInvDiligencia = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
        INNER JOIN carpetainvpersonal ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion
        INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
        
        WHERE carpetainvpersonal.idpersonalaeicarpeta = ?
        GROUP BY carpetadiligencias.idCarpetaInvDiligencia, delito.nombredelito, carpetadeinvestigacion.FechaHoraInicio, 
        carpetadeinvestigacion.FechaHoraConsignacion, personalaei.idPersonalAEI', [$idpersonalaeicarpeta]);
    	return $tabla;
    }

        public function getProgress(){
        $tabla = DB::select('SELECT 
            carpetadiligencias.idCarpetaInvDiligencia as CARPETA,
            COUNT(carpetadiligencias.cantidad) AS REALIZADAS
            FROM carpetadiligencias
            WHERE cantidad > 0
            GROUP BY carpetadiligencias.idCarpetaInvDiligencia'

        );
    	return $tabla;
    }

     public function getProgress(){
        $tabla = DB::select('SELECT 
          (SELECT COUNT(carpetadiligencias.cantidad) 
          FROM carpetadiligencias 
          WHERE cantidad > 0) REALIZADAS,
          (SELECT COUNT(carpetadiligencias.estatus) 
          FROM carpetadiligencias  
          WHERE estatus = 1) CANTIDAD', []);
    	return $tabla;
    }
     
     */
    public function getProgress2(){
        $tabla = DB::select('SELECT 
            carpetadiligencias.idCarpetaInvDiligencia as CARPETA,
            COUNT(carpetadiligencias.estatus) AS CANTIDAD
            FROM carpetadiligencias                    
            WHERE estatus = 1
            GROUP BY carpetadiligencias.idCarpetaInvDiligencia'
        );
    	return $tabla;
    }



    public function getTotalDelitos2(){
        $estadoCarpetas = DB::select('SELECT 
				(SELECT COUNT(carpetadeinvestigacion.Estatus) FROM carpetainvpersonal 
                INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
                INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
                INNER JOIN persona ON personalaei.personaID = persona.idPersona
                WHERE carpetadeinvestigacion.Estatus = "APERTURA")
                APERTURA,
                (SELECT COUNT(carpetadeinvestigacion.Estatus) 
                FROM carpetainvpersonal 
                INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
                INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
                INNER JOIN persona ON personalaei.personaID = persona.idPersona
                WHERE carpetadeinvestigacion.Estatus = "INVESTIGACION")
                INVESTIGACION,
                (SELECT COUNT(carpetadeinvestigacion.Estatus) 
                FROM carpetainvpersonal 
                INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
                INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
                INNER JOIN personalaei ON carpetainvpersonal.idpersonalaeicarpeta = personalaei.idPersonalAEI
                INNER JOIN persona ON personalaei.personaID = persona.idPersona
                WHERE carpetadeinvestigacion.Estatus = "CONCLUIDA")
                CONCLUIDA',[]);
        return $estadoCarpetas;
    }  
//Te quedaste en que vas hacer una consulta para el Agente
public function getTotalDelitos3($idpersonalaeicarpeta){
    $tabla = DB::select('SELECT
            (SELECT COUNT(carpetadeinvestigacion.Estatus) FROM carpetainvpersonal 
            INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
            INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
            WHERE carpetainvpersonal.idpersonalaeicarpeta = ? 
            AND carpetadeinvestigacion.Estatus = "APERTURA") 
            EN_APERTURA,            
            (SELECT COUNT(carpetadeinvestigacion.Estatus) FROM carpetainvpersonal 
            INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
            INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
            WHERE carpetainvpersonal.idpersonalaeicarpeta = ? 
            AND carpetadeinvestigacion.Estatus = "INVESTIGACION") 
            EN_INVESTIGACION,
            (SELECT COUNT(carpetadeinvestigacion.Estatus) 
            FROM carpetainvpersonal 
            INNER JOIN carpetadeinvestigacion ON carpetainvpersonal.idcarpetainv = carpetadeinvestigacion.CarpetaInvestigacion 
            INNER JOIN delito ON carpetadeinvestigacion.tipoDelito = delito.idDelito
            WHERE carpetainvpersonal.idpersonalaeicarpeta = ? 
            AND carpetadeinvestigacion.Estatus = "CONCLUIDA") 
            CONCLUIDA', [$idpersonalaeicarpeta, $idpersonalaeicarpeta, $idpersonalaeicarpeta]);
    //return $tabla;
    if(!$tabla){
        return;
    }
   
    return Response::json($tabla, 200);  
}
public function getInfoDiligenciaDLT($cve){
    $actadlt = DB::table('actadlt')                    
    ->join('ministeriopublico','ministeriopublico.carpetainv', '=','actadlt.cve')
    ->join('personalaei','actadlt.idrespondable', '=','personalaei.idPersonalAEI')
    ->join('senalesvisiblescadaver','senalesvisiblescadaver.idActaDLT', '=','actadlt.idActaDLT')
    ->join('vestimentadelcadaver','vestimentadelcadaver.idpersonacadaver', '=','senalesvisiblescadaver.cvecadaver')
    ->join('municipio','ministeriopublico.carpetainv', '=','actadlt.cve')
    ->join('entidad','municipio.cveEntidadM', '=','entidad.cveEntidad')
    ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('actadlt.cve','=', $cve)
        ->select(
            'actadlt.carpeta',
            'actadlt.cve',
            'actadlt.fechadecreacion',
            'actadlt.dependencia',
            'actadlt.idLocalidad',            
            'municipio.nomMunicipio',
            'entidad.nombreEntidad',
            'ministeriopublico.apPatMinisterioPublico',
            'ministeriopublico.apMatMinisterioPublico',
            'ministeriopublico.nombreMinisterioPublico',
            'ministeriopublico.adscripcion',
            'ministeriopublico.autoriza',
            'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona',
            'senalesvisiblescadaver.posicioncadaver',
            'senalesvisiblescadaver.orientacioncadaver',
            'senalesvisiblescadaver.nombreCadaver',
            'senalesvisiblescadaver.apPatCadaver',
            'senalesvisiblescadaver.apMatCadaver',
            'senalesvisiblescadaver.edad',
            'senalesvisiblescadaver.estatura',
            'senalesvisiblescadaver.complexion',
            'senalesvisiblescadaver.tez',
            'senalesvisiblescadaver.tatuajes',
            'senalesvisiblescadaver.cicatriz',
            'senalesvisiblescadaver.lunar',
            'senalesvisiblescadaver.equimosishematoma',
            'senalesvisiblescadaver.malformacioncongenita',
            'senalesvisiblescadaver.laceraciones',
            'senalesvisiblescadaver.contuciones',
            'senalesvisiblescadaver.abrasiones',
            'senalesvisiblescadaver.fracturafisuras',
            'vestimentadelcadaver.Blusa',
            'vestimentadelcadaver.Camisaconbotonesalfrente',
            'vestimentadelcadaver.Camisadevestir',
            'vestimentadelcadaver.Chaleco',
            'vestimentadelcadaver.Chamarra',
            'vestimentadelcadaver.Falda',
            'vestimentadelcadaver.Pantalon',
            'vestimentadelcadaver.Pantalondemezclilla',
            'vestimentadelcadaver.Pants',
            'vestimentadelcadaver.Playeraconcuelloredondo',
            'vestimentadelcadaver.PlayeraconcuelloV',
            'vestimentadelcadaver.Playeratipopolo',
            'vestimentadelcadaver.Sudadera',
            'vestimentadelcadaver.Sueter',
            'vestimentadelcadaver.Vestido',
            'vestimentadelcadaver.otros',
            'vestimentadelcadaver.observaciones',
            'vestimentadelcadaver.Tenis',
            'vestimentadelcadaver.ZapatoCerrado',
            'vestimentadelcadaver.Botas',
            'vestimentadelcadaver.ZapatosTacon',
            'vestimentadelcadaver.Cinturon',
            'vestimentadelcadaver.Bolsa',
            'vestimentadelcadaver.Anillos',
            'vestimentadelcadaver.Reloj',
            'vestimentadelcadaver.cadena',
            'vestimentadelcadaver.collar',
            'vestimentadelcadaver.pulcera',
            'vestimentadelcadaver.cartera',
            'vestimentadelcadaver.esclava',
            'vestimentadelcadaver.aretes'
            )
        ->limit(1)  
        ->get();
    return $actadlt;
    }
    
    public function getInfoEntrevista ($cve){
        $actadlt = DB::table('actadlt')                            
        ->join('persona_diligencia','persona_diligencia.carpetainv', '=','actadlt.cve')              
        ->join('personalaei','actadlt.idrespondable', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('parentesco','persona_diligencia.parentescoPersonaDiligencia', '=','parentesco.idParentesco')
        ->join('municipio','actadlt.idMunicipio', '=','municipio.idMunicipio')
        ->join('entidad','municipio.cveEntidadM', '=','entidad.cveEntidad')
            ->where('actadlt.cve','=', $cve)
            ->select(
                'actadlt.carpeta',
                'actadlt.cve',
                'actadlt.fechadecreacion',
                'actadlt.dependencia',
                'actadlt.idLocalidad',            
                'municipio.nomMunicipio',
                'entidad.nombreEntidad',
                'persona.apPat',
                'persona.apMat',
                'persona.nombrePersona',
                'persona_diligencia.idPersonaDiligencia',
                'persona_diligencia.nombrePersonaDiligencia',
                'persona_diligencia.apPatDiligencia',
                'persona_diligencia.apMatDiligencia',
                'persona_diligencia.fechaNacimientoDiligencia',
                'persona_diligencia.curpDiligencia',
                'persona_diligencia.estadoCivilDiligencia',
                'persona_diligencia.escolaridadDiligencia',
                'persona_diligencia.ocupacionDiligencia',
                'persona_diligencia.sexoDiligencia',
                'persona_diligencia.edadAparenteDiligencia',
                'persona_diligencia.idioma',
                'persona_diligencia.lugarDeNacimiento',
                'persona_diligencia.rolentrevistado',
                'persona_diligencia.marcas_visibles',
                'persona_diligencia.aliasDiligencia',
                'persona_diligencia.telefonoDiligenciaPersona',
                'persona_diligencia.documentacionOficialEntrevistado',
                'parentesco.Descripcion',
                'persona_diligencia.relatoentrevista',
                'persona_diligencia.observaciones_entre',
                'persona_diligencia.carpetainv'
               
                )
            ->limit(1)  
            ->get();
        return $actadlt;
        }
    public function getlugarintervencion($cve){
        $lugarintervencion = DB::table('lugarintervencion')                    
        ->join('localidad','lugarintervencion.idLocalidad', '=','localidad.idLocalidad')
        ->join('municipio','lugarintervencion.idMunicipio', '=','municipio.idMunicipio')
            ->where('lugarintervencion.carpetainv','=', $cve)
            ->where( 'lugarintervencion.lugarointernvencion','=', 'LUGAR INTERVENCION')
            ->select(
                'lugarintervencion.idlugarintervencion',
                'lugarintervencion.fechalugar_intervencion',
                'lugarintervencion.cp',
                'lugarintervencion.colonia',
                'lugarintervencion.calle',
                'lugarintervencion.ni',
                'lugarintervencion.ne',
                'lugarintervencion.motivo',
                'lugarintervencion.lugarointernvencion',
                'lugarintervencion.carpetainv',
                'municipio.nomMunicipio',
                'localidad.nombreLocalidad'
                )
            ->get();
        return $lugarintervencion;
        }
        public function getlugarintervencion2($cve){
            $lugarintervencion2 = DB::table('lugarintervencion')                    
            ->join('localidad','lugarintervencion.idLocalidad', '=','localidad.idLocalidad')
            ->join('municipio','lugarintervencion.idMunicipio', '=','municipio.idMunicipio')
                ->where('lugarintervencion.carpetainv','=', $cve)
                ->where('lugarintervencion.lugarointernvencion','=','LUGAR TRASLADO')
                ->select(
                    'lugarintervencion.idlugarintervencion',
                    'lugarintervencion.fechalugar_intervencion',
                    'lugarintervencion.cp',
                    'lugarintervencion.colonia',
                    'lugarintervencion.calle',
                    'lugarintervencion.ni',
                    'lugarintervencion.ne',
                    'lugarintervencion.motivo',
                    'lugarintervencion.lugarointernvencion',
                    'lugarintervencion.carpetainv',
                    'municipio.nomMunicipio',
                    'localidad.nombreLocalidad'
                    )
                ->get();
            return $lugarintervencion2;
        }
        public function getlugarintervencion3($cve){
            $lugarintervencion2 = DB::table('lugarintervencion')                    
            ->join('localidad','lugarintervencion.idLocalidad', '=','localidad.idLocalidad')
            ->join('municipio','lugarintervencion.idMunicipio', '=','municipio.idMunicipio')
                ->where('lugarintervencion.carpetainv','=', $cve)
                ->where('lugarintervencion.lugarointernvencion','=','LUGAR ENTREVISTA')
                ->select(
                    'lugarintervencion.idlugarintervencion',
                    'lugarintervencion.fechalugar_intervencion',
                    'lugarintervencion.cp',
                    'lugarintervencion.colonia',
                    'lugarintervencion.calle',
                    'lugarintervencion.ni',
                    'lugarintervencion.ne',
                    'lugarintervencion.motivo',
                    'lugarintervencion.lugarointernvencion',
                    'lugarintervencion.carpetainv',
                    'municipio.nomMunicipio',
                    'localidad.nombreLocalidad'
                    )
                ->get();
            return $lugarintervencion2;
        }
        public function getlugarintervencion4($cve){
            $lugarintervencion2 = DB::table('lugarintervencion')                    
            ->join('localidad','lugarintervencion.idLocalidad', '=','localidad.idLocalidad')
            ->join('municipio','lugarintervencion.idMunicipio', '=','municipio.idMunicipio')
                ->where('lugarintervencion.carpetainv','=', $cve)
                ->where('lugarintervencion.lugarointernvencion','=','DOMICILIO ENTREVISTADO')
                ->select(
                    'lugarintervencion.idlugarintervencion',
                    'lugarintervencion.fechalugar_intervencion',
                    'lugarintervencion.cp',
                    'lugarintervencion.colonia',
                    'lugarintervencion.calle',
                    'lugarintervencion.ni',
                    'lugarintervencion.ne',
                    'lugarintervencion.motivo',
                    'lugarintervencion.lugarointernvencion',
                    'lugarintervencion.carpetainv',
                    'municipio.nomMunicipio',
                    'localidad.nombreLocalidad'
                    )
                ->get();
            return $lugarintervencion2;
        }
        public function savePersonaDiligencia(Request $request){
            $PersonaDiligencia= new PersonaDiligencia();
            $PersonaDiligencia -> fill($request -> all());
            $PersonaDiligencia->save();
            return $PersonaDiligencia;
        }   

}
