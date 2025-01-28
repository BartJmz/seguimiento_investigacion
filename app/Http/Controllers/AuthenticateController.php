<?php

namespace App\Http\Controllers;


use JWTAuth;
use Tymon\JWTAuthExcepions\JWTExcepion;
use App\Http\Requests;

use Illuminate\Http\Request;
use App\users;
use App\Persona;    
use App\PersonalAEI;
use App\Adscripcion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response;
use DB;
class AuthenticateController extends Controller
{
     //Mis funciones 
     public function getPersonal($idPersonalAEI){
        $user = DB::table('adscripcion')
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('users','users.personalaeiUser', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->where('personalaei.idPersonalAEI','=', $idPersonalAEI)
        ->select(
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.idPersona',
            'adscripcion.idComandanciaAds',
            'users.personalaeiUser',
            'users.idRolesUser'
            )
        ->get();
        return $user;
        }
    public function getPersonal2($idPersonalAEI){
        $personalAEI = DB :: table ('personalaei')
        ->join('persona','persona.idPersona','=','personalaei.PersonaID')
        ->join('domiciliopersona','domiciliopersona.idPersonaD','=','persona.idPersona')
        ->join('domicilio','domiciliopersona.idDomicilioPersonasD','=','domicilio.cve')
        ->join('localidad','domicilio.localidadDomicilio','=','localidad.idLocalidad')
        ->join('municipio','localidad.cveMunicipioL', '=','municipio.cveMunicipio')
        ->join('entidad','municipio.cveEntidadM','=','entidad.cveEntidad')
        ->where('personalaei.idPersonalAEI','=',$idPersonalAEI)
        ->select(
        'idPersona','idPersonalAEI','apPat','apMat','nombrePersona','fechaNacimiento',
        'rfc','alias','edadAparente','sexo','estadoCivil','ocupacion','escolaridad',
        'persona.observaciones','imss','tipoSanguineo','persona.curp','personalaei.cuip','personalaei.viaIngreso',
        'personalaei.cartillaSmn','personalaei.emailAEI','personalaei.operativo','personalaei.personaID',
        'domiciliopersona.FechaInformacion',
        'domiciliopersona.Tipo',
        'domiciliopersona.Fuente',
        'domiciliopersona.Observaciones',
        'domicilio.idDomicilio',
        'domicilio.codigoPostal',
        'domicilio.colonia',
        'domicilio.nInterior',
        'domicilio.nExterior',
        'domicilio.calle',
        'domicilio.referenciaDelLugar',
        'domicilio.localidadDomicilio',
        'localidad.nombreLocalidad',
        'localidad.ambito',
        'municipio.idMunicipio',
        'municipio.nomMunicipio',
        'entidad.nombreEntidad')
        ->get();
        return $personalAEI; 
    }
   
    //
    public function index()
	{
	}
    public function authenticate_signin(Request $request)
    {
        $credential = $request->only('email', 'password');
        try {
            $user_auxin= users::where('email', $request->email)->first();
            //$user_rolin= $this->pre->getPreRegistro($user_auxin->id);
            $customClaims = ['rol' => $user_auxin->idRolesUser];
        //verifique las credenciales y cree un token para el usuario
        if (! $token = JWTAuth::attempt($credential, $customClaims)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
    } catch (JWTException $e) {
        //algo salió mal
        return response()->json(['error' => 'could_not_create_token'], 500);
    }

    //Si no se encuentran errores, podemos devolver un JWT
    return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // el token es válido y hemos encontrado al usuario a través de la sub reivindicación
        return response()->json(compact('user'));
    }
//Fin
}