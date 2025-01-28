<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\users;
use App\PersonalAEI;  
use App\Persona;  
use App\Token;
use DB;
class UserController extends Controller
{
    //
    public function index(){
        $user = DB::table('persona')
        ->join('personalaei','persona.idPersona','=','personalaei.personaID')
        ->join('users','personalaei.idPersonalAEI','=','users.personalaeiUser')
        ->where('users.status','=',1)
        ->join('roles','roles.idRoles','=','users.idRolesUser')
        ->select(
            'users.id','users.email','persona.curp','persona.apPat','persona.apMat','persona.nombrePersona','roles.nombreRoles','personalaei.idPersonalAEI','personalaei.emailAEI')
        ->get();    
        return $user;
    }
    public function index2(){
        $user = DB::table('persona')
        ->join('personalaei','persona.idPersona','=','personalaei.personaID')
        ->join('users','personalaei.idPersonalAEI','=','users.personalaeiUser')
        ->where('users.status','=',0)
        ->join('roles','roles.idRoles','=','users.idRolesUser')
        ->select(
            'users.id','users.email','persona.curp','persona.apPat','persona.apMat','persona.nombrePersona','roles.nombreRoles','personalaei.idPersonalAEI','personalaei.emailAEI')
        ->get();    
        return $user;
    }
    public function getUserID($id){
        $user = DB::table('persona')
        ->join('personalaei','persona.idPersona','=','personalaei.personaID')
        ->join('users','personalaei.idPersonalAEI','=','users.personalaeiUser')
        //Modificamos
        ->join('adscripcion','adscripcion.idPersonalAEIAds','=','personalaei.idPersonalAEI')
        ->where('users.id','=',$id)
        ->where('users.status','=',1)
        ->select('users.id','users.email','users.status','users.idRolesUser','persona.curp','persona.apPat','persona.apMat','persona.nombrePersona','personalaei.idPersonalAEI','personalaei.emailAEI','adscripcion.idAdscripcion')
        ->get();    
        return $user;
    }
    public function getUserID2($id){
        $user = DB::table('persona')
        ->join('personalaei','persona.idPersona','=','personalaei.personaID')
        ->join('users','personalaei.idPersonalAEI','=','users.personalaeiUser')
        ->where('users.id','=',$id)
        ->where('users.status','=',0)
        ->select(
            'users.id','users.email','users.status','persona.curp','persona.apPat','persona.apMat','persona.nombrePersona','personalaei.idPersonalAEI','personalaei.emailAEI')
        ->get();    
        return $user;
    }
    public function updateUser(Request $request, $id){
        $user = users::find($id);
        $user ->fill($request -> all());
        $user -> status = 0;
        $user -> save();
        return $user;
    }
    public function updateUser2(Request $request, $id){
        $user = users::find($id);
        $user -> fill($request -> all());
        $user -> status = 1;
        $user -> save();
        return $user;
    }
    public function updateUsers(Request $request, $id){
        $user = users::find($id);
        $user -> fill($request -> all());
        $user -> save();
        return $user;
    }

    public function exitcurp($curp){
        $user = DB::table('users')
        ->where('users.personalaeiUser','=',$curp)
        ->get();
        return $user;
    }
    //Vamos a modificar esta consulta para agregar lo siguiente en adscripción y se pueda actualizar.
    /*
    public function exitcurpPesona($curp){
        $user = DB::table('persona')
        ->where('persona.curp','=',$curp)
        ->get();
        return $user;
    }*/
    public function exitcurpPesona($curp){
        $ads = DB::table('adscripcion')                    
        ->join('personalaei','adscripcion.idPersonalAEIAds', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('nombramientoplacapersonal','nombramientoplacapersonal.idPersonalAEINom', '=','personalaei.idPersonalAEI')
        ->join('nombramientodisponible','nombramientoplacapersonal.idNombramientoDisponibleNom', '=','nombramientodisponible.idNombramientoDisponible')
        ->join('cargos','nombramientodisponible.idCargoNom', '=','cargos.idCargo')
        ->where('persona.curp','=',$curp)
        ->where('nombramientoplacapersonal.estatus','=', 1)
        ->where('adscripcion.vigente','=',1)
        ->select('persona.nombrePersona','persona.idPersona','persona.apPat','persona.apMat','persona.fechaNacimiento','persona.curp','persona.rfc','persona.imss','persona.estadoCivil','persona.escolaridad','persona.ocupacion','persona.sexo','persona.tipoSanguineo','persona.edadAparente','persona.alias','persona.observaciones','persona.lugarDeNacimiento','adscripcion.idAdscripcion')
        ->get();
        return $ads;
    }
    // Validando usuario
    public function exitstatus($status){
        $user = DB::table('users')
        ->where('users.status','=',$status)
        ->get();
        return $user;
    }
    public function estatus_email($status_email){
        $user = DB::table('users')
        ->select('users.status')
        ->where('users.email','=',$status_email)
        ->where('users.status','=',1)
        ->get();
        return $user;
    }
    //    
    public function saveUsuario(Request $request){
        $contraseña = Hash::make($request->input('password'));
        $user= new users();
        $user -> status =1;
        $user -> fill($request -> all());
        $user->password=$contraseña;
        $user->save();
        return $user;
    }
    public function saveUsuario2(Request $request){
        $id =(int)$request->all()['id'];
        $password = $request->all()['password'];
        $user = users::find($id);
        $user ->password = Hash::make($password);
        $user -> save();
        return $user;
    }
    //Valida correo
    public function buscaremailUser($email){
        $user = DB::table('users')
       ->where('email','=', $email)
       ->get();
        //return Response::json($comandancias->email, 200);
        return $user;
    }
    public function buscaremailUser2($email){
        $user = DB::table('users')
       ->where('email','=', $email)
       ->select('users.id')
       ->get();
        //return Response::json($comandancias->email, 200);
        return $user;
    }
   //Validacion tokens
    public function getToken(){
    $token = Token::get();
    return $token;
    }
   public function getEmailToken($token){
    $token = DB::table('tokenpassword')
    ->where('tokenpassword.token','=',$token)
    //->where('users.status','=',1)
    ->select(
        'tokenpassword.idtoken','tokenpassword.correo','tokenpassword.token')
    ->get();    
    return $token;
    }
    public function saveToken(Request $request){
        //$contraseña = Hash::make($request->input('password'));
        $correo = $request->all()['correo'];
        $nuevo_token = hash("sha512",$correo .Time());//Convierto a sha512 lo que sigue más el tiempo actual, para generar el token.
        $existe = DB::table('tokenpassword')//Si existe en la tabla con un correo igual
        ->where('tokenpassword.correo','=', $correo)
        ->select('tokenpassword.correo','tokenpassword.idtoken')
        ->get();
        if(count($existe) == 0){//Si no existe crei el token y si si existe cambio el token.
            $token = new Token();
            $token -> token = $nuevo_token; 
            $token -> fill($request -> all());
            $token->save();
        }
        else{ 
            $token = Token::find($existe[0]->idtoken);
            $token -> token = $nuevo_token; 
            $token -> fill($request -> all());
            $token->save();
        }
        $salida = array((object) array('correo' => $correo, 'token'=> $nuevo_token));
        return $salida;
    }
}
