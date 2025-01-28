<?php

namespace App\Http\Controllers;


use App\Persona;
use App\Familiar;
use App\DatosFamiliares;
use App\Telefonos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

use Illuminate\Support\Facades\Response;
use DB;
class PersonaController extends Controller
{
    //
    public function getPersona(){
        $persona = Persona::get();
        return $persona;
    }
    
    public function savePersona(Request $request){
        $persona= new Persona();
        $persona -> fill($request -> all());
        $persona->save();
        return $persona;
    }
    
    public function getPersonaID($id){
        $persona = Persona::find($id);
        return $persona;
    }
    public function updatePersona(Request $request, $id){
        $persona = Persona::find($id);
        $persona -> fill($request -> all());
        $persona -> save();
        return $persona;
       // return var_dump($comandancias);
    }
    public function updateDatosFamiliares(Request $request, $idDatosFamiliares){
        $DatosFamiliares = DatosFamiliares::find($idDatosFamiliares);
        $DatosFamiliares -> fill($request -> all());
        $DatosFamiliares -> save();
        return $DatosFamiliares;
       // return var_dump($comandancias);
    }    
    public function updateDatosFamiliaresTelefono(Request $request, $idTelefono){
        $DatosFamiliaresTel = Telefonos::find($idTelefono);
        $DatosFamiliaresTel -> fill($request -> all());
        $DatosFamiliaresTel -> save();
        return $DatosFamiliaresTel;
       // return var_dump($comandancias);
    }
    //Experimentando
    public function exitcurpPesona($curp){
        $user = DB::table('persona')
        ->where('persona.curp','=',$curp)
        ->select('idPersona','nombrePersona')
        ->get();
        return $user;
    }
    public function getclavecarp($clavecarp){
        $userclavecarp = DB::table('persona')
        ->where('persona.clavecarp','=',$clavecarp)
        ->select('idPersona','nombrePersona')
        ->get();
        return $userclavecarp;
    }
    public function exitcurpPesona2($curp){
        $personaArma = DB::table('personalaei')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->where('persona.curp','=',$curp)
        ->select(
            'persona.curp',
            'personalaei.idPersonalAEI'
        )
        ->get();
        return $personaArma;
    }
    
    public function exitcurpPesona3($curp){
        $personaArma = DB::table('persona_diligencia')
        ->where('persona_diligencia.curpDiligencia','=',$curp)
        ->select(
            'idPersonaDiligencia',
            'nombrePersonaDiligencia',
            'apPatDiligencia',
            'apMatDiligencia',
            'fechaNacimientoDiligencia',
            'curpDiligencia',
            'estadoCivilDiligencia',
            'escolaridadDiligencia',
            'ocupacionDiligencia',
            'sexoDiligencia',
            'edadAparenteDiligencia',
            'idioma',
            'lugarDeNacimiento',
            'rolentrevistado',
            'marcas_visibles',
            'aliasDiligencia',
            'telefonoDiligenciaPersona',
            'documentacionOficialEntrevistado',
            'parentescoPersonaDiligencia',
            'relatoentrevista',
            'observaciones_entre'
        )
        ->get();
        return $personaArma;
    }
    public function exitcurpPesona4($curp){
        $personaexit = DB::table('persona')
        ->where('persona.curp','=',$curp)
        ->select(
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
            'persona.lugarDeNacimiento'            
        )
        ->get();
        return $personaexit;
    }
    public function exitcurpPesona5($idPersona){
        $personaexit = DB::table('inputado_victima')
        ->where('inputado_victima.idPersona','=',$idPersona)
        ->select(
            'inputado_victima.idinputado_victima',
            'inputado_victima.idPersona',
            'inputado_victima.idcvedom',
            'inputado_victima.distrito',
            'inputado_victima.ubicacion',
            'inputado_victima.nexos',
            'inputado_victima.tipopersona',
            'inputado_victima.carpetaInvestigacionPersona'        
        )
        ->get();
        return $personaexit;
    }
    public function infodomicilio($cve){
        $personaexit = DB::table('domicilio')
        ->where('domicilio.cve','=',$cve)
        ->select(
            'domicilio.idDomicilio',
            'domicilio.codigoPostal',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.latitud',
            'domicilio.longitud',
            'domicilio.calle',
            'domicilio.referenciaDelLugar',
            'domicilio.localidadDomicilio',
            'domicilio.cve',
            'domicilio.fechaSistemaDomicilio'                            
        )
        ->get();
        return $personaexit;
    }
    //Nombre
    public function busca($nombrePersona){
        $idper= DB::table('persona')
        ->where('nombrePersona','=',$nombrePersona)
        ->select(
            'persona.idPersona'
        )
        ->get();
        return $idper;
    }
    public function exiteimssPesona($imss){
        $user = DB::table('persona')
        ->where('persona.imss','=',$imss)
        ->select('idPersona')
        ->get();
        return $user;
    }
    public function exiterfcPesona($rfc){
        $user = DB::table('persona')
        ->where('persona.rfc','=',$rfc)
        ->select('idPersona')
        ->get();
        return $user;
    }
    public function exitTelefonoPesonal($idPersonaTel){
        $user = DB::table('telefono')
        ->where('telefono.idPersonaTel','=',$idPersonaTel)
        ->select('numeroTel')
        ->get();
        return $user;
    }
    public function getPhotoInfo($idPersonalImagen){
        $imagen = DB::table('imagen')
        ->where('imagen.idPersonalImagen','=',$idPersonalImagen)
        ->get();
        return $imagen;
    }
    public function getDatosFamiliares($idPersona){
        $datosFamiliares = DB :: table ('familiar')
        ->join('datosfamiliares','familiar.idDatosFamiliaresF','=','datosfamiliares.idDatosFamiliares')
        ->join('parentesco','datosfamiliares.idParentescoFamiliar','=','parentesco.idParentesco') 
        ->join('telefono','datosfamiliares.idTelefonoFamiliar','=','telefono.idTelefono') 
        ->where('familiar.idPersonaFamiliarF','=',$idPersona)
        ->select(
            'familiar.idFamiliar',
            'familiar.idPersonaFamiliarF',
            'datosfamiliares.idDatosFamiliares',
            'datosfamiliares.nombreFamiliar',
            'datosfamiliares.apPatFamiliar',
            'datosfamiliares.apMatFamiliar',
            'datosfamiliares.sexo',
            'datosfamiliares.fechaDeNacimientoFamiliar',
            'datosfamiliares.idTelefonoFamiliar',
            'datosfamiliares.idParentescoFamiliar',
            'datosfamiliares.responsable',
            'parentesco.Descripcion',
            'telefono.idTelefono',
            'telefono.numeroTel')
        ->get();
        return $datosFamiliares; 
    }

    //

}
