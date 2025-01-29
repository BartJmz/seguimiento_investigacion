<?php

namespace App\Http\Controllers;
use App\EstadoPersonal;
use App\Fatigas;
use App\DetalleFatigas;
use App\Adscripcion;
use App\Comandancia;
use App\Persona;
use App\PersonalAEI;
use App\Permisos;
use App\Cargo;
use App\NombramientoPlacaPersonal;
use App\NombramientoDisponible;
use App\ServicioPersonal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;

class FatigaController extends Controller
{
    //
    /*
    public function index(){
        $rol = PersonalAEI::get();
        return $rol;
    }*/
    public function estados(){
        $status = EstadoPersonal::get();
        return $status;
    }
    public function allFatigas(){
            $fatigas = DB::table('detallefatiga')
            ->join('fatiga','detallefatiga.idFatigaDF', '=','fatiga.idFatiga')
            ->join('adscripcion','detallefatiga.idAdscripcionDF', '=','adscripcion.idAdscripcion')
            ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
            ->select(
            'fatiga.fechaHora',
            'comandancia.nombreComandancia',
            'fatiga.obervaciones'
            )
            //->orderBy('fatiga.fechaHora', 'asc')
            //->groupBy('comandancia.NombreComandancia')
            ->get();
            return $fatigas;

    }
    public function idResponsableFatigas($idComandancia){
        $responsable = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('adscripcion.idComandanciaAds','=',$idComandancia)        
        ->where('adscripcion.idMovimeintoPersonalAEI','=', 1)        
        ->where('adscripcion.encargado','=',1)
        ->where('adscripcion.estatus','=', 1)
        ->select(
            //'adscripcion.encargado',
            'personalaei.idPersonalAEI'
            /*'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona'*/
        )
        //->orderBy('fatiga.fechaHora', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $responsable;

    }
    public function idResponsableFatigasOp2($idComandancia){
        $responsable = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('adscripcion.idComandanciaAds','=',$idComandancia)        
        ->where('adscripcion.idMovimeintoPersonalAEI','=', 3)        
        ->where('adscripcion.encargado','=',1)
        ->where('adscripcion.estatus','=', 1)
        ->select(
            //'adscripcion.encargado',
            'personalaei.idPersonalAEI'
            /*'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona'*/
        )
        //->orderBy('fatiga.fechaHora', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $responsable;
    }
    public function idallFatigas($idComandancia){
        $fatigas = DB::table('detallefatigas')
        ->join('fatigas','detallefatigas.iddetallefatigas', '=','fatigas.clavedil')
        ->join('comandancia','fatigas.comandancia', '=','comandancia.idComandancia')
        ->where('fatigas.comandancia','=', $idComandancia)
        ->select(
            'comandancia.idComandancia',
            'fatigas.fecha_fatiga',            
            'fatigas.hora'
        )
        ->orderBy('fatigas.fecha_fatiga', 'des')
        ->groupBy('comandancia.idComandancia','fatigas.fecha_fatiga','fatigas.hora')
        ->get();
        return $fatigas;

    }
    /*
    public function idallFatigas($idComandancia){
        $fatigas = DB::table('detallefatigas')
        ->join('fatiga','detallefatigas.idFatigaDF', '=','fatiga.idFatiga')
        ->join('adscripcion','detallefatiga.idAdscripcionDF', '=','adscripcion.idAdscripcion')
        ->join('comandancia','adscripcion.idComandanciaAds', '=','comandancia.idComandancia')
        ->where('fatigas.comandancia','=', $idComandancia)
        ->select(
        'fatiga.fechaHora',
        'comandancia.nombreComandancia',
        'fatiga.obervaciones'
        )
        //->orderBy('fatiga.fechaHora', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $fatigas;

}
*/
    public function getPersonalAds($idComandanciaAds){
        @estatus;
        @iddetallefatigas;
        @idComanciaServicioFK;
        @idPersonalAEIFK;
        $tabla = DB::select('SELECT
            nombramientodisponible.placa,
            cargos.Descripcion,
            persona.nombrePersona,
            persona.apPat,
            persona.apMat,
            personalaei.cuip,
            @estatus = 1 as estado, 
            @iddetallefatigas   as  iddetallefatigas,
            @idComanciaServicioFK as  idComanciaServicioFK,
            @idPersonalAEIFK as idPersonalAEIFK
            FROM
            adscripcion
            INNER JOIN personalaei ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
            INNER JOIN nombramientodisponible ON adscripcion.placa_uso = nombramientodisponible.placa
            INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible 
            AND nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
            INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
            INNER JOIN persona ON personalaei.personaID = persona.idPersona
            WHERE
            /**
            Modificamos
            */
            nombramientoplacapersonal.estatus = 1 AND
            adscripcion.estatus = 1 AND
            adscripcion.idComandanciaAds = ?',[$idComandanciaAds]);
    	return $tabla;
    }
    public function getPermisoPersonalPorComandancia($idComandanciaAds){
        $tabla = DB::select('SELECT
        permisos.idpermisos,    
        /*
        permisos.fechaInicial,                
        permisos.canDias,
        */
        permisos.fechaTermino,
        permisos.estatus,
        permisos.idPersonalPermiso
        FROM
        permisos
        INNER JOIN personalaei ON permisos.idPersonalPermiso = personalaei.idPersonalAEI
        INNER JOIN adscripcion ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
        INNER JOIN comandancia ON adscripcion.idComandanciaAds = comandancia.idComandancia
        WHERE
        adscripcion.idComandanciaAds = ?',[$idComandanciaAds]);
    	return $tabla;
    }
    /*
    public function getPersonalAds2($idComandanciaAds){
        @estatus;
        @iddetallefatigas;
        @idComanciaServicioFK;
        @idPersonalAEIFK;
        $tabla = DB::select('SELECT
            nombramientodisponible.placa,
            cargos.Descripcion,
            persona.apPat,
            persona.apMat,
            persona.nombrePersona,
            area.nombreArea,
            servicios.nombreServicio,
            estatus.nombreEstatus,
            personalaei.idPersonalAEI,
            @estatus = 1 as estado, 
            @iddetallefatigas   as  iddetallefatigas,
            @idComanciaServicioFK as  idComanciaServicioFK,
            @idPersonalAEIFK as idPersonalAEIFK
            FROM
            adscripcion
            INNER JOIN personalaei ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
            INNER JOIN nombramientodisponible ON adscripcion.placa_uso = nombramientodisponible.placa
            INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible AND nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
            INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
            INNER JOIN persona ON personalaei.personaID = persona.idPersona
            INNER JOIN serviciopersonalaei ON serviciopersonalaei.idPersonalAEIFK = personalaei.idPersonalAEI
            INNER JOIN comandanciaservicio ON serviciopersonalaei.idComanciaServicioFK = comandanciaservicio.idComandanciaServicio
            INNER JOIN servicios ON comandanciaservicio.idtiposServicios = servicios.claveser
            INNER JOIN area ON servicios.idAreaServicio = area.idArea
            INNER JOIN detallefatiga ON detallefatiga.idAdscripcionDF = adscripcion.idAdscripcion
            INNER JOIN estatus ON detallefatiga.statusFatigaDF = estatus.idEstatus
            WHERE
            nombramientoplacapersonal.estatus = 1 AND
            adscripcion.idComandanciaAds = ?',[$idComandanciaAds]);
    	return $tabla;
    }
    */
    public function getPersonalAds2($idComandanciaAds){
        @estatus;
        @iddetallefatigas;
        @idComanciaServicioFK;
        @idPersonalAEIFK;
        $tabla = DB::select('SELECT
            nombramientodisponible.placa,
            cargos.Descripcion,
            persona.apPat,
            persona.apMat,
            persona.nombrePersona,
            area.nombreArea,
            servicios.nombreServicio,            
            personalaei.idPersonalAEI,
            @estatus = 1 as estado, 
            @idComanciaServicioFK as  idComanciaServicioFK,
            @idPersonalAEIFK as idPersonalAEIFK
            FROM
            adscripcion
            INNER JOIN personalaei ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
            INNER JOIN nombramientodisponible ON adscripcion.placa_uso = nombramientodisponible.placa
            INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible AND nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
            INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
            INNER JOIN persona ON personalaei.personaID = persona.idPersona
            INNER JOIN serviciopersonalaei ON serviciopersonalaei.idPersonalAEIFK = personalaei.idPersonalAEI
            INNER JOIN comandanciaservicio ON serviciopersonalaei.idComanciaServicioFK = comandanciaservicio.idComandanciaServicio
            INNER JOIN servicios ON comandanciaservicio.idtiposServicios = servicios.claveser
            INNER JOIN area ON servicios.idAreaServicio = area.idArea
            WHERE
            nombramientoplacapersonal.estatus = 1 AND
            adscripcion.estatus = 1 AND
            adscripcion.idComandanciaAds = ?',[$idComandanciaAds]);
    	return $tabla;
    }
    public function listaFatiga(){
        $fatigas = DB::table('serviciopersonalaei')
        ->join('adscripcion','serviciopersonalaei.idPersonalAEIFK', '=','adscripcion.idAdscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('comandanciaservicio','serviciopersonalaei.idComanciaServicioFK', '=','comandanciaservicio.idComandanciaServicio')
        ->join('servicios','comandanciaservicio.idtiposServicios', '=','servicios.idServicios')
        ->join('area','servicios.idAreaServicio', '=','area.idArea')
        ->join('detallefatiga','detallefatiga.idAdscripcionDF', '=','adscripcion.idAdscripcion')
        ->join('estatus','detallefatiga.statusFatigaDF', '=','estatus.idEstatus')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom', '=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponibleNom', '=','nombramientodisponible.idNombramientoDisponible')
        ->select(
            'nombramientodisponible.placa',
            'persona.apPat',
            'persona.apMat',
            'persona.nombrePersona',
            'servicios.nombreServicio',
            'area.nombreArea',
            'estatus.nombreEstatus'
        )
        //->orderBy('fatiga.fechaHora', 'asc')
        ->orderBy('area.nombreArea', 'asc')
        ->get();
        return $fatigas;
}
        
        public function saveFatigas(Request $request){
            $savefatigas= new Fatigas();
            $savefatigas -> fill($request -> all());
            $savefatigas->save();
            return $savefatigas;
        }
        /*
        public function saveDetalleFatigas(Request $request){
            
            $saveDetllefatigas= new DetalleFatigas();
            $saveDetllefatigas -> fill($request -> all());
            $saveDetllefatigas->save();
            return $saveDetllefatigas;
        }*/
        public function saveDetalleFatigas(Request $request){
            $arrayFatigas = $request->input('detalleFatigas');
 
              foreach ($arrayFatigas as $key => $objDetalle) {
                 DB::table('detallefatigas')->insert($objDetalle);
             }
         }
         public function saveAreaPersona(Request $request){
            $arrayFatigas2 = $request->input('area');
 
              foreach ($arrayFatigas2 as $key => $objDFatigasTecnica) {
                 DB::table('serviciopersonalaei')->insert($objDFatigasTecnica);
             }
         }
         public function updateCarpeta(Request $request){              
            $arreglo = $request->input('editarFatigas');
            //print_r($arreglo);             
             foreach ($arreglo as $key => $detalle) {        
                DB::table('detallefatigas')
                ->where([
                    ['iddetallefatigast', '=', $detalle["iddetallefatigast"] ],
                ])->update($detalle);                
        }
        }
        public function updatePermisos(Request $request){              
            $arreglo = $request->input('editarFatigas');
            //print_r($arreglo);             
             foreach ($arreglo as $key => $detalle) {        
                DB::table('permisos')
                ->where([
                    ['idpermisos', '=', $detalle["idpermisos"] ],
                ])->update($detalle);                
        }
        }
        public function updateAreaPersona(Request $request, $idservicioPersonal){
            $servicio_p = ServicioPersonal::find($idservicioPersonal);
            $servicio_p -> fill($request -> all());
            $servicio_p -> save();
            return $servicio_p;
        }
         //Estoy actualizando.
        //Nose como meter el id y el objeto, porque estoy utilizando un arreglo de objetos.
        /*
        public function updateCarpeta(){      
        
        $arreglo = Input::get('detallefatigas');
        print_r($arreglo);
         /*
         foreach ($arreglo as $key => $detalle) {        
            DB::table('detallefatigas')
            ->where([
                ['iddetallefatigast', '=', $detalle["iddetallefatigast"] ],
            ])->update($detalle);
            
        }
        
       
       }*/
         public function getFatigaComandacia($fecha_fatiga){
            $tabla = DB::select('SELECT
                fatigas.fecha_fatiga,
                fatigas.hora,
                comandancia.nombreComandancia,
                persona.nombrePersona,
                persona.apPat,
                persona.apMat,
                estatus.nombreEstatus
                FROM
                fatigas
                INNER JOIN detallefatigas ON detallefatigas.iddetallefatigas = fatigas.clavedil
                INNER JOIN personalaei ON detallefatigas.personaID = personalaei.idPersonalAEI
                INNER JOIN estatus ON detallefatigas.estado = estatus.idEstatus
                INNER JOIN comandancia ON fatigas.comandancia = comandancia.idComandancia
                INNER JOIN persona ON personalaei.personaID = persona.idPersona
                WHERE
                comandancia.idComandancia = ?',[$fecha_fatiga]);
            return $tabla;
        }
        public function getFatigas($comandancia){
            $tabla = DB::select('SELECT
                fatigas.fecha_fatiga,
                fatigas.hora
                FROM
                fatigas
                INNER JOIN comandancia ON fatigas.comandancia = comandancia.idComandancia               
                WHERE
                fatigas.comandancia = ?
                ORDER BY
                fatigas.fecha_fatiga DESC,
                fatigas.hora DESC',[$comandancia]);
            return $tabla;
        }
        //Trabajamos
        public function getFatigasCor(){
            $tabla = DB::select('SELECT
                fatigas.fecha_fatiga
                FROM
                fatigas
                GROUP BY
                fatigas.fecha_fatiga',[]);
            return $tabla;
        }
        public function getFatigasCor2($fecha_fatiga){
            $tabla = DB::select('SELECT
                fatigas.fecha_fatiga,
                comandancia.nombreComandancia,
                comandancia.idComandancia
                FROM
                fatigas
                INNER JOIN comandancia ON fatigas.comandancia = comandancia.idComandancia
                WHERE
                fatigas.fecha_fatiga = ?',[$fecha_fatiga]);
            return $tabla;
        }
        //
        public function getAreaPersona(){
            $tabla = DB::select('SELECT
            area.nombreArea,
            servicios.nombreServicio,
            persona.nombrePersona,
            persona.apPat,
            persona.apMat,
            nombramientoplacapersonal.estatus,
            nombramientodisponible.placa,
            cargos.Descripcion,            
            personalaei.idPersonalAEI,
            serviciopersonalaei.idComanciaServicioFK,
            serviciopersonalaei.idservicioPersonal
            FROM
            serviciopersonalaei
            INNER JOIN comandanciaservicio ON serviciopersonalaei.idComanciaServicioFK = comandanciaservicio.idComandanciaServicio
            INNER JOIN servicios ON comandanciaservicio.idtiposServicios = servicios.claveser
            INNER JOIN personalaei ON serviciopersonalaei.idPersonalAEIFK = personalaei.idPersonalAEI
            INNER JOIN area ON servicios.idAreaServicio = area.idArea
            INNER JOIN persona ON personalaei.personaID = persona.idPersona
            INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
            INNER JOIN nombramientodisponible ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible
            INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
            WHERE
            nombramientoplacapersonal.estatus = 1
            ORDER BY
            nombramientodisponible.placa DESC',[]);
        return $tabla;
        }
        public function getAreaPersonaExistentes(){    
            $personal_area_exist = ServicioPersonal:: get();
            return $personal_area_exist;
                       
        }
        public function getAreaPersonaID($idPersonalAEI){
            $tabla = DB::select('SELECT
            area.nombreArea,
            servicios.nombreServicio,
            persona.nombrePersona,
            persona.apPat,
            persona.apMat,
            nombramientoplacapersonal.estatus,
            nombramientodisponible.placa,
            cargos.Descripcion,
            personalaei.idPersonalAEI,
            serviciopersonalaei.idComanciaServicioFK,
            serviciopersonalaei.idservicioPersonal
            FROM
            serviciopersonalaei
            INNER JOIN comandanciaservicio ON serviciopersonalaei.idComanciaServicioFK = comandanciaservicio.idComandanciaServicio
            INNER JOIN servicios ON comandanciaservicio.idtiposServicios = servicios.claveser
            INNER JOIN personalaei ON serviciopersonalaei.idPersonalAEIFK = personalaei.idPersonalAEI
            INNER JOIN area ON servicios.idAreaServicio = area.idArea
            INNER JOIN persona ON personalaei.personaID = persona.idPersona
            INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
            INNER JOIN nombramientodisponible ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible
            INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
            WHERE
            nombramientoplacapersonal.estatus = 1 AND
            personalaei.idPersonalAEI = ?
            ORDER BY
            nombramientodisponible.placa DESC',[$idPersonalAEI]);
        return $tabla;
        }

        public function getFechaFatigas($fecha_fatiga,$comandancia){
            $tabla = DB::select('SELECT
                fatigas.fecha_fatiga,
                fatigas.hora,
                detallefatigas.iddetallefatigast,
                detallefatigas.area,
                detallefatigas.servicio,
                persona.nombrePersona,
                persona.apPat,
                persona.apMat,
                estatus.nombreEstatus,
                estatus.idEstatus,
                comandancia.nombreComandancia,                
                comandancia.email,
                /*
                agendacomandancia.numeroTelefonico,
                */
                domicilio.codigoPostal,
                domicilio.colonia,
                domicilio.calle,
                localidad.nombreLocalidad,
                municipio.nomMunicipio,
                entidad.nombreEntidad,                
                nombramientodisponible.placa,
                cargos.Descripcion,
                adscripcion.encargado
                /*Modufucamos
                servicios.nombreServicio,
                area.nombreArea
                */
                FROM
                fatigas
                INNER JOIN comandancia ON fatigas.comandancia = comandancia.idComandancia
                /*INNER JOIN agendacomandancia ON agendacomandancia.idComandanciaFK = comandancia.nombreComandancia*/
                INNER JOIN domiciliocomandancia ON domiciliocomandancia.idComandanciaDir = comandancia.idComandancia
                INNER JOIN domicilio ON domiciliocomandancia.idDireccionDomicilio = domicilio.cve
                INNER JOIN detallefatigas ON detallefatigas.iddetallefatigas = fatigas.clavedil
                INNER JOIN personalaei ON detallefatigas.personaID = personalaei.idPersonalAEI
                INNER JOIN persona ON personalaei.personaID = persona.idPersona
                INNER JOIN estatus ON detallefatigas.estado = estatus.idEstatus
                INNER JOIN localidad ON domicilio.localidadDomicilio = localidad.idLocalidad
                INNER JOIN municipio ON localidad.cveMunicipioL = municipio.cveMunicipio
                INNER JOIN entidad ON municipio.cveEntidadM = entidad.cveEntidad
                INNER JOIN nombramientoplacapersonal ON nombramientoplacapersonal.idPersonalAEINom = personalaei.idPersonalAEI
                INNER JOIN nombramientodisponible ON nombramientoplacapersonal.idNombramientoDisponibleNom = nombramientodisponible.idNombramientoDisponible
                INNER JOIN cargos ON nombramientodisponible.idCargoNom = cargos.idCargo
                INNER JOIN adscripcion ON adscripcion.idPersonalAEIAds = personalaei.idPersonalAEI
                /*Modificamos
                INNER JOIN comandanciaservicio ON comandanciaservicio.idservicioComandacia = comandancia.idComandancia
                INNER JOIN servicios ON comandanciaservicio.idtiposServicios = servicios.claveser
                INNER JOIN area ON servicios.idAreaServicio = area.idArea
                */
                /**/
                WHERE
                fatigas.fecha_fatiga = ?
                AND
                fatigas.comandancia = ?
                AND
                nombramientoplacapersonal.estatus = 1
                AND
                adscripcion.estatus = 1',[$fecha_fatiga,$comandancia]);
            return $tabla;
        }
        public function getFatigaHoy($fecha_fatiga, $comandancia){
            $existe = DB::table('fatigas')        
            ->where('fatigas.fecha_fatiga','=',$fecha_fatiga)
            ->where('fatigas.comandancia','=',$comandancia)
            ->select(        
                'fatigas.fecha_fatiga'
                )
            ->get();
            return $existe;
        }        
        

}