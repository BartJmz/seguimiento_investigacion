<?php

namespace App\Http\Controllers;
use App\Correo;
use App\users;
use App\PersonalAEI;  
use App\Persona;  
use App\Building;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Response;
use DB;
require 'C:/xampp/htdocs/AEI2017v1/app/vendor/autoload.php';


class MailController extends Controller
{
    //
    //Funciones
    public function tipoEmailToSend($tipo, $correo, $mensaje){
        $url = 'http://localhost/AEIAngularv1/';
        switch($tipo){
            case 'token':
            $mensaje=
            '<!DOCTYPE html>
            <html>
               <head>
                  <meta charset="utf-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
               </head>
               <body>
                  <div style="background-color: white">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr class="form-inline">
                            <td>
                                <p style="height: 30px; background-color: #2F4F4F; margin: 20px 100px 20px 25px"></p>
                            </td>
                            </tr>
                            <tr class="form-inline">
                            <td>
                                <p style="margin: 10px 100px 10px 10px; font-size: 15px justify">
                                <strong>		
                                Estimado usuario.<br>
                                Hemos recibido una solicitud para cambiar tu contraseña, a través de tu dirección de correo electrónico ' .$correo .'
                                <br>
                                Tu token de verificación es:
                                </p>
                                <br>
                                </strong>
                            </td>
                            <td>
                            </td>
                            </tr>
                            <tr class="form-inline">
                            <td>
                                <h3><strong>'.$mensaje .'</strong></h3>
                                <br>
                                <br>
                                <center>
                                <strong><a href="'.$url .'#/recover">Click Aqui!!!</a></strong>
                                </center>
                            </td>
                            <td>
                            </td>
                            </tr>
                            <tr class="form-inline">
                            <td>
                            <strong>
                            <center>
                                <p>
                                Si no has solicitado este token, puede que alguien esté 
                                intentado acceder con tú cuenta de correo al sistema de la AEI.<br>
                                 No reenvíes este correo electrónico ni des el token a nadie.
                                </p>
                            </center>
                            </strong>
                            </td>
                            <td>
                            </td>
                            </tr>
                            <tr class="form-inline">
                            <td>
                                  <p style="height: 30px; background-color: #2F4F4F; margin: 20px 100px 20px 25px"></p>
                            </td>
                            </tr>
                        </tr class="form-inline">
                        <p style="color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0">AGENCIA ESTATAL DE INVESTIGACIONES DEL ESTADO DE OAXACA</p>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     </table>
                  </div>
               </body>
            </html>';
                return MailController::sendEmail($correo, $mensaje);
            break;
        }
    }
    public function sendEmail($coreo, $mensaje){
        $mail = new PHPMailer(true);
        try { 
              $cuenta = 'aeioaxacasystem@gmail.com';
              $contra = 'AgenciaAEI2018/soporte_jose';
              //Server settings
              $mail->isSMTP();//Habilitar SMTP
              //$mail->SMTPDebug = 4;
              $mail->Host = 'smtp.gmail.com';//Definir el host
              $mail->SMTPAuth = true;//Habilitar Autenticacion
              $mail->Username = $cuenta;//Correo/Username del que envia
              $mail->Password = $contra;//Password del correo del que envia
              $mail->SMTPSecure = 'ssl';//Definir el tipo de seguridad, para gmail es ssl
              $mail->Port = 465;//Definir el puerto, para gmail es el 465
              
              //$mail->Port = 587;
  
              //Configuracion del Destinatario
              $mail->setFrom($cuenta, 'Agencia Estatal De Investigaciones del Estado de Oaxaca');
              $mail->addAddress($coreo, "");          // El segundo parametro es Opcionall
              //$mail->addCC('cc@example.com');
              //$mail->addBCC('bcc@example.com');
  
              //Attachments
              //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
              //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  
              //Contenido del cuerpo del correo
              $mail->isHTML(true);
              $mail->Subject = "Alerta de seguridad AEI";
              
              //$mail->Body = file_get_contents('paginas/correo/cuerpoRestorePassword.html');
              $mail->Body = $mensaje;
              //$mail->AltBody = file_get_contents('paginas/correo/
              //cuerpoRestorePassword.html');
              $mail->AltBody = $mensaje;
              $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ));
              $mail->send();
              $salida = array((object) array('mensaje' => 'success|El Email ha sido enviado'));
          } catch (Exception $e) {
              $salida = array((object) array('mensaje' => "warning|El Email no se pudo enviar -> " .$mail->ErrorInfo));
          }
          return $salida;
      }    

    public function getEmailToken($token){
        $token = DB::table('tokenpassword')
        ->where('tokenpassword.token','=',$token)
        //->where('users.status','=',1)
        ->select(
            'tokenpassword.idtoken',
            'tokenpassword.correo',
            'tokenpassword.token')
        ->get();    
        return $token;
        }
        

        public function saveToken(Request $request){
            //$contraseña = Hash::make($request->input('password'));
            $correo = $request->all()['correo'];
            $nuevo_token = hash("sha512",$correo .Time());//Convierto a sha512 lo que sigue más el tiempo actual, para generar el token.
            $existe = DB::table('tokenpassword')//Si existe en la tabla con un correo igual
            ->where('tokenpassword.correo','=', $correo)
            ->select('tokenpassword.correo',
                    'tokenpassword.idtoken')
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
            //$salida = array((object) array('correo' => $correo, 'token'=> $nuevo_token));
            return MailController::tipoEmailToSend('token',$correo,$nuevo_token);
            //return $salida;
        }  

    //Validacion para el correo
    public function checkEmail($email){
        $user = DB::table('persona')
        ->join('personalaei','persona.idPersona','=','personalaei.personaID')
        ->join('users','personalaei.idPersonalAEI','=','users.personalaeiUser')
        ->where('users.email','=',$email)
        ->where('users.status','=', 1)
        ->join('roles','roles.idRoles','=','users.idRolesUser')
        ->select(
            'users.email',
            'persona.curp','persona.apPat','persona.apMat','persona.nombrePersona',
            'roles.nombreRoles',
            'personalaei.idPersonalAEI','personalaei.emailAEI')
        ->get();    
        return $user;

    }


    
}
