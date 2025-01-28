<?php

namespace App\Http\Controllers;

use App\PersonalAEI;
use App\Persona;
use App\Parentesco;


use App\Domicilio;
use App\Localidad;
use App\Municipio;
use App\CodigoPostal;
use App\Entidad;
use App\DomicilioPersona; 
use App\Telefonos;
use App\Imagen;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;



use Illuminate\Support\Facades\Response;
//use DB;

class PesonalAEIController extends Controller
{
    //
    public function index($idPersonalAEI){
        $fichaTecnica = DB :: table ('personalaei')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->join('telefono','telefono.idPersonaTel','=','persona.idPersona')
        //->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom','=','personalaei.idPersonalAEI')        
        ->join('adscripcion','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds','=','comandancia.idComandancia')
        ->join('nombramientodisponible','adscripcion.placa_uso', '=','nombramientodisponible.placa')
        ->join('cargos','nombramientodisponible.idCargoNom','=','cargos.idCargo')
        ->join('movimientopersonal','adscripcion.idMovimeintoPersonalAEI','=','movimientopersonal.idMovimientoPersonal')        
        ->join('domiciliopersona','domiciliopersona.idPersonaD','=','persona.idPersona')
        ->join('domicilio','domiciliopersona.idDomicilioPersonasD','=','domicilio.cve')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL','=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->where('personalaei.idPersonalAEI','=',$idPersonalAEI)
        ->where('movimientopersonal.idMovimientoPersonal','!=', 4)
        ->select(
            'adscripcion.observaciones',
            'adscripcion.fechaIngreso',
            'telefono.numeroTel',
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
            'persona.lugarDeNacimiento',
            'adscripcion.fechaMovimiento',
            'nombramientodisponible.placa',
            'cargos.Descripcion',
            'personalaei.operativo',
            'personalaei.cuip',
            'personalaei.viaIngreso',
            'personalaei.cartillaSmn',
            'personalaei.emailAEI',
            'adscripcion.fechaMovimiento',
            'comandancia.nombreComandancia',
            'movimientopersonal.movimiento',
            'domicilio.codigoPostal',
            'domicilio.colonia',
            'domicilio.nInterior',
            'domicilio.nExterior',
            'domicilio.latitud',
            'domicilio.longitud',
            'domicilio.calle',
            'domicilio.referenciaDelLugar',
            'localidad.nombreLocalidad',
            'municipio.nomMunicipio',
            'entidad.cveEntidad'
        )
        ->orderBy('adscripcion.fechaMovimiento', 'asc')
        ->get();
        return $fichaTecnica;   
    }
    public function getPersonalAEI(){
        $personalAEI = DB :: table ('personalaei')        
        ->join('persona','persona.idPersona','=','personalaei.PersonaID')
        ->join('domiciliopersona','domiciliopersona.idPersonaD','=','persona.idPersona')
        ->join('domicilio','domiciliopersona.idDomicilioPersonasD','=','domicilio.cve')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->select('idPersona','idPersonalAEI','apPat','apMat','nombrePersona','fechaNacimiento','rfc','alias','edadAparente','sexo','estadoCivil','ocupacion','escolaridad','persona.observaciones','imss','tipoSanguineo','persona.curp','personalaei.cuip','personalaei.viaIngreso',  'personalaei.cartillaSmn','personalaei.emailAEI','personalaei.operativo','personalaei.personaID','domiciliopersona.FechaInformacion','domiciliopersona.Tipo','domiciliopersona.Fuente','domiciliopersona.Observaciones','domicilio.codigoPostal','domicilio.colonia','domicilio.nInterior','domicilio.nExterior','domicilio.calle','domicilio.referenciaDelLugar','localidad.nombreLocalidad','localidad.ambito','municipio.nomMunicipio','entidad.nombreEntidad')
        ->get();
        return $personalAEI;    
        }

        public function getMunicipio(){
             $municipio = DB :: table ('municipio')
             ->select(
             'municipio.idMunicipio',
             'municipio.nomMunicipio'
             )
             ->get();
             return $municipio;    
             }
        public function getTel($numeroTel){
        $tel = DB :: table ('telefono')
        ->where('telefono.numeroTel','=',$numeroTel)
        ->select(
            'telefono.numeroTel'
        )
        ->get();
        return $tel;    
        }
    public function getPersonalAEIID($idPersonalAEI){
        /*
        $personalAEI = PersonalAEI::find($idPersonalAEI);
        return $personalAEI;*/
        $personalAEI = DB :: table ('personalaei')
        ->join('persona','persona.idPersona','=','personalaei.PersonaID')
        ->join('domiciliopersona','domiciliopersona.idPersonaD','=','persona.idPersona')
        ->join('domicilio','domiciliopersona.idDomicilioPersonasD','=','domicilio.cve')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->join('adscripcion','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')
        ->join('comandancia','adscripcion.idComandanciaAds','=','comandancia.idComandancia')
        ->where('personalaei.idPersonalAEI','=',$idPersonalAEI)
        ->select('idPersona','idPersonalAEI','apPat','apMat','nombrePersona','fechaNacimiento',
        'rfc','alias','edadAparente','sexo','estadoCivil','ocupacion','escolaridad',
        'persona.observaciones','imss','tipoSanguineo','persona.curp','personalaei.cuip','personalaei.viaIngreso',
        'personalaei.cartillaSmn','personalaei.emailAEI','personalaei.operativo','personalaei.personaID',
        'domiciliopersona.FechaInformacion',
        'domiciliopersona.Tipo',
        'domiciliopersona.Fuente',
        'domiciliopersona.Observaciones',
        'domicilio.codigoPostal',
        'domicilio.colonia',
        'domicilio.nInterior',
        'domicilio.nExterior',
        'domicilio.calle',
        'domicilio.referenciaDelLugar',
        'localidad.nombreLocalidad',
        'localidad.ambito',
        'municipio.nomMunicipio',
        'entidad.nombreEntidad',
        'comandancia.idComandancia')
        ->get();
        return $personalAEI; 

        }
        public function getdatos($idPersonalAEI){
            $personalAEI = DB :: table ('personalaei')
            ->join('persona','personalaei.personaID','=','persona.idPersona')            
            ->join('adscripcion','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')            
            ->where('personalaei.idPersonalAEI','=',$idPersonalAEI)
            ->select(
                'personalaei.idPersonalAEI',              
                'persona.nombrePersona',
                'persona.apPat',
                'persona.apMat',
                'persona.fechaNacimiento',               
                'adscripcion.idComandanciaAds'
            )
            ->get();
            if(!$personalAEI){
                return;
            }
           
            return Response::json($personalAEI, 200); 
    
            }
        public function getImagen_perfil($idPersonalImagen){
            $imagen_profile = DB :: table ('imagen')
            ->join('persona','imagen.idPersonalImagen','=','persona.idPersona')
            ->where('imagen.idPersonalImagen','=',$idPersonalImagen)
            ->select(
                'persona.idPersona',
                'imagen.imagen',
                'imagen.mimeimagen',
                'imagen.idPersonalImagen',
                'imagen.fechaImagen',
                'imagen.imagen_id',
                'imagen.nombre_imagen'
            )
            ->get();
            return $imagen_profile; 
    
            }
    public function updatePersona(Request $request, $idPersona){
        $personalAEI = Persona::find($idPersona);
        $personalAEI -> fill($request -> all());
        $personalAEI -> save();
        return $personalAEI;
        // return var_dump($comandancias);
    }
    public function updatePersonalAEI(Request $request, $idPersonalAEI){
        $personalAEI = PersonalAEI::find($idPersonalAEI);
        $personalAEI -> fill($request -> all());
        $personalAEI -> save();
        return $personalAEI;
        // return var_dump($comandancias);
    }    
    public function updateDomicilio(Request $request, $idDomicilio){
        $Domicilio = Domicilio::find($idDomicilio);
        $Domicilio -> fill($request -> all());
        $Domicilio -> save();
        return $Domicilio;
        // return var_dump($comandancias);
    }
    public function exiteCuipPesonal($cuip){
        $personalAEI = DB::table('personalaei')
        ->where('personalaei.cuip','=',$cuip)
        ->select('idPersonalAEI')
        ->get();
        return $personalAEI;
    }
    public function buscaidMunicipio($idMunicipio){
        $personalAEI = DB::table('municipiocodigopostal')
        ->where('municipiocodigopostal.idMunicipio','=',$idMunicipio)
        ->select('codigoPostal')
        ->get();
        return $personalAEI;
    }
    
    public function exitecartillaSmnPesonal($cartillaSmn){
        $personalAEI = DB::table('personalaei')
        ->where('personalaei.cartillaSmn','=',$cartillaSmn)
        ->select('idPersonalAEI')
        ->get();    
        return $personalAEI;
    }
    public function saveDomicilioPersonal(Request $request){
        $domicilioPersonal= new DomicilioPersona();
        $domicilioPersonal -> fill($request -> all());
        $domicilioPersonal->save();
        return $domicilioPersonal;
    }
    public function getParentesco(){
        /*
        $placa = Parentesco::get();
        //return $placa;
        if(!$placa){
            return;
        }
       
        return Response::json($placa, 200);  */
        $placa = DB::table('parentesco')
        ->select('parentesco.idParentesco','parentesco.Descripcion')
        ->orderBy('parentesco.Descripcion', 'asc')
        ->get();    
        return $placa;

    }
    //Buscar id por email
    public function id_email($emailAEI){
        $personalAEI = DB::table('personalaei')
        ->join('persona','personalaei.personaID','=','persona.idPersona')
        ->where('personalaei.emailAEI','=',$emailAEI)
        ->select('personalaei.idPersonalAEI','persona.idPersona')
        ->get();
        return $personalAEI;
    }
    /*
    public function uploadImgs(Request $request, $idPersonalAEI){
        $salida = "";
            $input = Input::all();
            foreach ($input as $key => $element) {
                $descriptionImagen = $element->getClientOriginalName();
                $imgContent = base64_encode(file_get_contents($element));
                $imgNormal = file_get_contents($element);
                $mimeImagen = $element->getMimeType();
            }
            $carpeta = '../uploadImgs';               
            if (!file_exists($carpeta ."/" .$descriptionImagen)) {
                //var_dump("NO EXISTE LA IMAGEN");
                file_put_contents($carpeta ."/" .$descriptionImagen, $imgNormal);
                $salida = "Imagen Cargada Exitosamente";
            }else {
                //var_dump("YA EXISTE LA IMAGEN");
                $salida = "El nombre de la imagen ya existe";
            }               
            return $salida;
        }
*/
            public function uploadImgs(Request $request, $idPersonalAEI){
            $salida = "";
                $input = Input::all();
                foreach ($input as $key => $element) {
                    $descriptionImagen = $element->getClientOriginalName();
                    $imgContent = base64_encode(file_get_contents($element));
                    $imgNormal = file_get_contents($element);
                    $mimeImagen = $element->getMimeType();
                }
                $carpeta = '../uploadImgs';
                /*
                if (!file_exists($carpeta)) {

                    mkdir($carpeta, 0777, true);
                    var_dump("SE CREO CARPETA");
                }else{
                    var_dump("YA EXISTE LA CARPETA");
                }
                */

                if (!file_exists($carpeta ."/" .$descriptionImagen)) {
                    //var_dump("NO EXISTE LA IMAGEN");
                    file_put_contents($carpeta ."/" .$descriptionImagen, $imgNormal);
                    DB::table('imagen')->insert(['nombre_imagen' => $descriptionImagen, 'imagen' => 'prueba', 'mimeimagen' => $mimeImagen, 'idPersonalImagen' => $idPersonalAEI]);
                    $salida = "Imagen Cargada Exitosamente";
                }else {
                    //var_dump("YA EXISTE LA IMAGEN");
                    $salida = "El nombre de la imagen ya existe";
                }

                //var_dump($descriptionImagen);
                //DB::table('imagen')->insert(['nombre_imagen' => $descriptionImagen, 'imagen' => $imgContent, 'mimeimagen' => $mimeImagen, 'idPersonalImagen' => $idPersonalAEI]);
                return $salida;
            }
            public function getImage($idP){
                $carpeta = '../uploadImgs';
                $getNameImage = DB::table('imagen')->where('idPersonalImagen', $idP)->first();
                $img = base64_encode(file_get_contents($carpeta ."/" .$getNameImage->nombre_imagen));
   
                $arr = array('base64Photo' => 'data:'.$getNameImage->mimeimagen.';base64,'.$img);
                return json_encode($arr);
           }

    //
    //Fin
}

    