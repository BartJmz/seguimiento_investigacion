<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'api'], function(){
            
            Route::group(['prefix' => 'v1'], function(){
            Route::resource('authenticate','AuthenticateController',['only' => ['index']]);
            Route::post('authenticate','AuthenticateController@authenticate_signin');
            Route::get('authenticate/info','AuthenticateController@getAuthenticatedUser');

            //Route::group(['prefix' => 'usuarios','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'usuarios'], function(){
            Route::get('', ['uses' => 'UserController@index']);   
            Route::get('email/{email}', ['uses' => 'UserController@estatus_email']);
            Route::get('{id}', ['uses' => 'UserController@getUserID']);

            Route::post('/update_pass', ['uses' => 'UserController@saveUsuario2']);
            Route::put('{id}', ['uses' => 'UserController@updateUser']);       
            Route::post('', ['uses' => 'UserController@saveUsuario']);
            Route::get('/curp/{curp}',['uses'=> 'UserController@exitcurp']);
            Route::get('/status/{status}',['uses'=> 'UserController@exitstatus']);
            Route::get('/curpPersona/{curp}',['uses'=> 'UserController@exitcurpPesona']);
            Route::get('/email/{email}/ok', ['uses' => 'UserController@buscaremailUser']);
            Route::get('/buscaemail/{email}', ['uses' => 'UserController@buscaremailUser2']);
            Route::get('user_info/{idPersonalAEI}', ['uses' => 'AuthenticateController@getPersonal']);
            Route::get('/user_info2/{idPersonalAEI}', ['uses' => 'AuthenticateController@getPersonal2']);
            Route::get('/datosFamiliares/{idPersona}', ['uses' => 'PersonaController@getDatosFamiliares']);
            Route::put('updateDatosFamiliares/{idDatosFamiliares}', ['uses' => 'PersonaController@updateDatosFamiliares']);  
            Route::put('updateDatosFamiliaresTelefono/{idTelefono}', ['uses' => 'PersonaController@updateDatosFamiliaresTelefono']);  
            //Valores para el token
            //Route::get('token', ['uses' => 'UserController@getToken']);   
            Route::get('/tokens/{token}', ['uses' => 'MailController@getEmailToken']);   
            Route::post('/tokens_email_g', ['uses' => 'MailController@saveToken']);
            });
            Route::group(['prefix' => 'correo','middleware' => ['jwt.auth']], function(){  
            Route::get('/email/{email}', ['uses' => 'MailController@checkEmail']);
            // Route::post('/sendemail/{email}/{nombre}/{asunto}/{cuerpo}', ['uses' => 'MailController@sendEmail']);
            Route::get('/send/{tipo}/{correo}/{mensaje}', ['uses' => 'MailController@tipoEmailToSend']);
            }); 
            Route::group(['prefix' => 'bajas','middleware' => ['jwt.auth']], function(){  
            Route::get('', ['uses' => 'UserController@index2']); 
            Route::get('{id}', ['uses' => 'UserController@getUserID2']);
            Route::put('{id}', ['uses' => 'UserController@updateUser2']);  
            Route::put('/ActualizarUser/{id}', ['uses' => 'UserController@updateUsers']);   
            }); 
            Route::group(['prefix' => 'comandancias','middleware' => ['jwt.auth']], function(){       
            Route::get('', ['uses' => 'ComandanciaController@allComandancias']);
            Route::get('/domicilio/{idComandanciaDir}', ['uses' => 'ComandanciaController@getComandanciasDomicilio']);
            Route::get('/{idComandancia}', ['uses' => 'ComandanciaController@getComandanciasID']);
            Route::get('/getComandanciaIDAgenda/{nombreComandancia}', ['uses' => 'ComandanciaController@getComandanciaIDAgenda']);
            Route::get('/comandanciaedit/{idComandancia}', ['uses' => 'ComandanciaController@getComandanciasID2']);
            Route::post('', ['uses' => 'ComandanciaController@saveComandancia']);
            Route::post('/Agenda/', ['uses' => 'ComandanciaController@saveAgenda']);
            Route::put('{idComandancia}', ['uses' => 'ComandanciaController@updateComandancia']); 
            Route::put('update_domicilio/{idDomicilio}', ['uses' => 'ComandanciaController@updateDomicilio']);  
            Route::put('update_nombramiento/{idNombramientoDisponible}', ['uses' => 'ComandanciaController@updatePlacaCargo']);  
            Route::put('update_placa/{update_placa}', ['uses' => 'ComandanciaController@updatePlaca']);  
            Route::put('update_placa2/{idplaca}', ['uses' => 'ComandanciaController@updateVigencia']);  
            Route::put('update_placa3/{idplaca}', ['uses' => 'ComandanciaController@updateVigencia2']);  
            Route::get('{email}/email/ok', ['uses' => 'ComandanciaController@buscaremail']);
            //Route::get('nombre/{nombreComandancia}', ['uses' => 'ComandanciaController@busca']);
            Route::get('nombre2/{nombreComandancia}', ['uses' => 'ComandanciaController@buscaNombre']);
            ROute::get('cp/{codigoPostal}', ['uses' => 'ComandanciaController@busca2']);
            ROute::get('email/{email}', ['uses' => 'ComandanciaController@busca3']);
            Route::get('/tel/{numeroTelefonico}', ['uses' => 'ComandanciaController@exit_tel']);
            Route::get('destroycomand/{idComandancia}',['uses'=>'ComandanciaController@destroy']);
            });
            //Route::group(['prefix' => 'region','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'region'], function(){
            Route::get('', ['uses' => 'RegionController@getRegion']);
            Route::get('/regionalizacion/{region}', ['uses' => 'RegionController@getRegionalizacion']); 
            Route::get('/regionv2/{region}', ['uses' => 'RegionController@getRegionv2']); 
            Route::get('/distritoMunicipio/{idregionalizacion}', ['uses' => 'RegionController@getMunicipioID']);   
            Route::get('/distritoInfo/{idregionalizacion}', ['uses' => 'RegionController@getdistritoInfo']);   
            
            });
            Route::group(['prefix' => 'perfil','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'PerfilController@getPerfil']); 
            
            });
            Route::group(['prefix' => 'roles','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'RolController@getRol']);  
            });
            Route::group(['prefix' => 'cargodes','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'PlacaController@getCargo']);  
            });
            //Route::group(['prefix' => 'personalAEI','middleware' => ['jwt.auth']], function(){
             Route::group(['prefix' => 'personalAEI'], function(){
            Route::get('', ['uses' => 'PesonalAEIController@getPersonalAEI']);
            Route::get('/parentesco', ['uses' => 'PesonalAEIController@getParentesco']);
            Route::get('/municipios', ['uses' => 'PesonalAEIController@getMunicipio']);             
            Route::get('/{idPersonalAEI}', ['uses' => 'PesonalAEIController@getPersonalAEIID']);
            Route::get('/datos/{idPersonalAEI}', ['uses' => 'PesonalAEIController@getdatos']);            
            Route::get('/imagen_perfil/{idPersonalImagen}', ['uses' => 'PesonalAEIController@getImagen_perfil']);
            Route::put('/{idPersona}', ['uses' => 'PesonalAEIController@updatepersona']); 
            Route::get('/email/{emailAEI}', ['uses' => 'PesonalAEIController@id_email']);
            Route::post('/uploadImgs/{idPersonalAEI}', ['uses' => 'PesonalAEIController@uploadImgs']);  
            Route::get('/image/{idP}', ['uses' => 'PesonalAEIController@getImage']);
            Route::get('/fichatecnica/{idPersonalAEI}', ['uses' => 'PesonalAEIController@index']); 
            Route::put('/updateDomicilio/{idDomicilio}', ['uses' => 'PesonalAEIController@updateDomicilio']);
            //Probando imagenes

            });
            Route::group(['prefix' => 'persona2','middleware' => ['jwt.auth']], function(){
            Route::put('/{id}', ['uses' => 'PesonalAEIController@updatePersonalAEI']);
            Route::get('/cuip/{cuip}',['uses'=> 'PesonalAEIController@exiteCuipPesonal']);
            Route::get('/cartilla/{cartillaSmn}',['uses'=> 'PesonalAEIController@exitecartillaSmnPesonal']);
            Route::post('/domicilio', ['uses' => 'PesonalAEIController@saveDomicilioPersonal']);  
            });
            //Route::group(['prefix' => 'persona','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'persona'], function(){
            Route::get('', ['uses' => 'PersonaController@getPersona']);  
            Route::get('telefono/idTel/{numeroTel}', ['uses' => 'PersonalController@getPersonaTelefonoId']);  
            Route::get('imagen/idPersonaPhoto/{idPersonalImagen}', ['uses' => 'PersonaController@getPhotoInfo']);  
            Route::post('', ['uses' => 'PersonaController@savePersona'] );
            Route::post('/familiar/', ['uses' => 'PersonalController@saveFamiliar'] );
            Route::post('/familia/', ['uses' => 'PersonalController@saveFamilia'] );
            Route::post('/telefono/', ['uses' => 'PersonalController@saveTelefono'] );
            Route::get('/{idPersona}', ['uses' => 'PersonaController@getPersonaID']);  
            Route::put('/{idPersona}', ['uses' => 'PersonaController@updatePersona']);  
            Route::get('/curpPersona/{curp}',['uses'=> 'PersonaController@exitcurpPesona']);
            Route::get('/getclavecarp/{clavecarp}',['uses'=> 'PersonaController@getclavecarp']);
            Route::get('/curpPersona2/{curp}',['uses'=> 'PersonaController@exitcurpPesona2']);
            Route::get('/curpPersona3/{curp}',['uses'=> 'PersonaController@exitcurpPesona3']);
            Route::get('/curpPersona4/{curp}',['uses'=> 'PersonaController@exitcurpPesona4']);
            Route::get('/curpPersona5/{curp}',['uses'=> 'PersonaController@exitcurpPesona5']);
            Route::get('/idcvedom/{idcvedom}',['uses'=> 'PersonaController@infodomicilio']);
            Route::get('/nombre/{nombrePersona}', ['uses' => 'PersonaController@busca']);
            Route::get('/telefeno/{numeroTel}', ['uses' => 'PesonalAEIController@getTel']);
            Route::get('/idMunicipio/{idMunicipio}', ['uses' => 'PesonalAEIController@buscaidMunicipio']);            
            Route::get('/imss/{imss}',['uses'=> 'PersonaController@exiteimssPesona']);
            Route::get('/rfc/{rfc}',['uses'=> 'PersonaController@exiterfcPesona']);
            Route::get('/telefono/{idPersonaTel}',['uses'=> 'PersonaController@exitTelefonoPesonal']);                        
            });
            Route::group(['prefix' => 'personal','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'PersonalController@getPersonal']); 
            Route::get('/{idPersonalAEI}', ['uses' => 'PersonalController@getPersonalID']); 
            Route::post('', ['uses' => 'PersonalController@savePersonal']);
            //Comprobamos correo
            Route::get('/email/{emailAEI}', ['uses' => 'PersonalController@buscaremail']);
            });
            //Route::group(['prefix' => 'servicios','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'servicios'], function(){
            Route::get('', ['uses' =>  'ServicioController@index']);
            Route::get('area_servicio', ['uses' =>  'ServicioController@index2']);
            Route::get('/{idServicios}', ['uses' => 'ServicioController@getServicioID']);
            Route::put('/{idServicios}', ['uses' => 'ServicioController@updateServicio']);  
            Route::post('', ['uses' => 'ServicioController@saveServicio']);  
            });
            Route::group(['prefix' => 'service_comandancia','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'ServicioController@getServicioComandancia']);  
            Route::post('', ['uses' => 'ServicioController@saveServicioComandancia']);  
            });
            Route::group(['prefix' => 'area','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'AreaController@index']);  
            Route::get('/{idArea}', ['uses' => 'AreaController@getAreaID']);  
            Route::put('/{idArea}', ['uses' => 'AreaController@updateArea']);
            Route::post('', ['uses' => 'AreaController@saveArea']);  
            Route::get('/Nombre/{nombreArea}', ['uses' => 'AreaController@exitNombreArea']); 
            });
            Route::group(['prefix' => 'area2','middleware' => ['jwt.auth']], function(){
            Route::put('/{idArea}', ['uses' => 'AreaController@updateArea']);
            });
            Route::group(['prefix' => 'areaonly','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'AreaOnlyController@index']);  
            Route::get('/{idArea}', ['uses' => 'AreaOnlyController@getAreaID']);  
            Route::get('/nombre/{nombreArea}', ['uses' => 'AreaOnlyController@getAreaNombre']); 
            Route::put('/{idArea}', ['uses' => 'AreaOnlyController@updateArea']);
            Route::post('', ['uses' => 'AreaOnlyController@saveAreaOnly']);  
            Route::get('/Nombre/{nombreArea}', ['uses' => 'AreaOnlyController@exitNombreArea']); 
            Route::put('/{idArea}', ['uses' => 'AreaOnlyController@updateAreaOnly']);
            });
            Route::group(['prefix' => 'areaonly2','middleware' => ['jwt.auth']], function(){
            Route::put('/{idArea}', ['uses' => 'AreaOnlyController@updateAreaOnly2']);
            });
            Route::group(['prefix' => 'domicilio','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'DomicilioController@index']);
            });
            Route::group(['prefix' => 'domicilioComandancia','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'ComandanciaController@localidadComandancia']);
            Route::get('/{idComandancia}', ['uses' => 'ComandanciaController@getDireccionID']);
            Route::post('', ['uses' => 'ComandanciaController@saveDomicilio']);  
            Route::post('/agenda', ['uses' => 'ComandanciaController@saveAgenda']);  
             }); 
            //Route::group(['prefix' => 'domicilioComandancia2','middleware' => ['jwt.auth']], function(){
            //Busca codigo postal
            Route::group(['prefix' => 'domicilioComandancia2'], function(){
            Route::get('/{codigoPostal}', ['uses' => 'CodigoPostalController@getCpID']);
            Route::get('/municipio/{idMunicipio}', ['uses' => 'ComandanciaController@getMunicipioCVE']);
            Route::post('/domicilio/', ['uses' => 'ComandanciaController@saveDomicilioComandancia']);  
            }); 
            Route::group(['prefix' => 'cp','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'CodigoPostalController@indexCodigoPostal']);  
            Route::get('{codigoPostal}', ['uses' => 'CodigoPostalController@getCpID']);
            }); 
            Route::group(['prefix' => 'localidades','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'LocalidadController@getLocalidad']);  
            });    
            Route::group(['prefix' => 'cargo','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'CargoController@getCargo']);  
            Route::post('', ['uses' => 'CargoController@saveCargo'] );
            });
            Route::group(['prefix' => 'placa','middleware' => ['jwt.auth']], function(){
            Route::get('', ['uses' => 'PlacaController@getPlaca']);  
            Route::get('/disponible', ['uses' => 'PlacaController@disponible2']);  
            Route::get('/ocupado', ['uses' => 'PlacaController@ocupado']); 
            Route::post('/placa/', ['uses' => 'PlacaController@savePlaca']); 
            Route::post('/placacargo/', ['uses' => 'PlacaController@savePlacaCargo']); 
            Route::get('/idPlaca/{idplacapersonal}', ['uses' => 'PlacaController@getIdPlaca']);
            Route::get('/idPlacaCargo/{idplacapersonal}', ['uses' => 'PlacaController@getIdPlacaCargo']);
            Route::post('/agregarnombra', ['uses' => 'AdscripcionController@saveNomDis']);   
            Route::put('update_disponible/{idplaca}', ['uses' => 'AdscripcionController@updatePlaca']); 
            });    
            //Route::group(['prefix' => 'nombramiento','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'nombramiento'], function(){
            Route::get('', ['uses' => 'NombramientoDisponibleController@index']);    
            //Nombramiento Placa Personal
            Route::get('/nombramientopersonal', ['uses' => 'NombramientoPlacaPersonalController@index']);    
            //Adscripcion
            Route::get('adscripcion', ['uses' => 'AdscripcionController@index']); 
            Route::get('adscripcionid/{idComandanciaAds}', ['uses' => 'AdscripcionController@idadscripcion_por_comandancia']); 
            Route::get('personal_carpetaInv/{idpersonalaeicarpeta}', ['uses' => 'AdscripcionController@personal_carpetaInv']); 
            Route::get('personal_carpetaInvResponsable/{idpersonalaeicarpeta}', ['uses' => 'AdscripcionController@personal_carpetaInvResponsable']); 
            
            
            //Comandancias en general
            Route::get('/adscripcion_por_comandancia', ['uses' => 'AdscripcionController@verCatidadAdsPorComandancia']); 
            //Estado de fuerza
            Route::get('/getestadoarmas', ['uses' => 'AdscripcionController@getestadoarmas']);
            Route::get('/getestadoarmasID/{idComandanciaAds}', ['uses' => 'AdscripcionController@getestadoarmasID']); 
            Route::get('/vehiculoComandancia/{idAsignacionComandancia}', ['uses' => 'AdscripcionController@vehiculoComandancia']);  
     
            
            Route::get('/getestadovehiculos', ['uses' => 'AdscripcionController@getestadovehiculos']);        
            //Adscripcion por comandancia
            Route::get('/adscripcioncomandancia/{idComandancia}', ['uses' => 'AdscripcionController@comandanciapersonal']);    
            Route::get('/adscripcion_nombrecomandancia/{idComandancia}', ['uses' => 'AdscripcionController@nombre']);    
            //Movimiento
            Route::get('/movimiento', ['uses' => 'AdscripcionController@movimiento']);  
            //Save Ads
            Route::post('', ['uses' => 'AdscripcionController@saveAdscripcion']);  
            Route::post('/fechaAds', ['uses' => 'AdscripcionController@savefechaAds']);     
            Route::post('/permiso', ['uses' => 'AdscripcionController@savePermiso']);     
            Route::get('/curp/{curp}',['uses'=> 'AdscripcionController@exitcurp']);
            Route::get('/id/{id}',['uses'=> 'AdscripcionController@exitcurpAds']);  
            Route::get('/getAdsv1/{id}',['uses'=> 'AdscripcionController@getAdsv1']);
            Route::get('/idAds/{id}',['uses'=> 'AdscripcionController@getAdsID']);    
            Route::get('/idAds2/{id}',['uses'=> 'AdscripcionController@getAdsID2']);
            Route::get('/idAds3/{id}',['uses'=> 'AdscripcionController@getAdsID3']);  
            Route::get('/idAds4/{idPersonalPermiso}',['uses'=> 'AdscripcionController@getAdsID4']);  
            Route::get('/nombramientoDisponible/{idPersonalAEIAds}',['uses'=> 'AdscripcionController@nombramientoplaca']); 
            Route::get('/personal/{personaID}',['uses'=> 'AdscripcionController@exitpersonalaei']);  
            Route::get('/idNombramientoDisponible/{idNombramientoDisponible}',['uses'=> 'AdscripcionController@exiteplacaNom']);  
            Route::get('/idNombramientoDisponible2/{idNombramientoDisponible}',['uses'=> 'AdscripcionController@buscaplacadis']);  
            Route::put('/{idAdscripcion}', ['uses' => 'AdscripcionController@updateAdscripcion']); 
            Route::put('/updateDisponibleADS/{idAdscripcion}', ['uses' => 'AdscripcionController@updateDisponibleADS']);
            Route::put('/asignarEncargado/{idAdscripcion}', ['uses' => 'AdscripcionController@asignarEncargado']);
            //Route::get('mov/', ['uses' => 'AdscripcionController@getMov']);  
            });
            Route::group(['prefix' => 'cargo','middleware' => ['jwt.auth']], function(){
            Route::put('/editar_cargo_placa/{idNombramientoPersonal}', ['uses' => 'AdscripcionController@updateNombramientoPlaca']); 
            Route::get('/comandanciaads', ['uses' => 'AdscripcionController@getComandanciaads']);
            
            //Route::put('{idplacapersonal}', ['uses' => 'PlacaController@updateVigencia']);
            });
            Route::group(['prefix' => 'nombremientodisponible','middleware' => ['jwt.auth']], function(){
            //Route::get('', ['uses' => 'NombramientoDisponibleController@index']);    
            });
            //Comenxzamos con fatigas!!
            //Route::group(['prefix' => 'fatigas','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'fatigas'], function(){
            Route::get('', ['uses' => 'FatigaController@estados']);
            Route::get('fatigas', ['uses' => 'FatigaController@allFatigas']);
            Route::get('idfatigas/{idComandancia}', ['uses' => 'FatigaController@idallFatigas']);            
            Route::get('idResponsableFatigas/{idComandancia}', ['uses' => 'FatigaController@idResponsableFatigas']);
            Route::get('idResponsableFatigasOp2/{idComandancia}', ['uses' => 'FatigaController@idResponsableFatigasOp2']);
            Route::get('listafatigas', ['uses' => 'FatigaController@listaFatiga']);
            Route::get('getPersonalAds/{idComandanciaAds}', ['uses' => 'FatigaController@getPersonalAds']);
            Route::get('getPersonalAds2/{idComandanciaAds}', ['uses' => 'FatigaController@getPersonalAds2']);
            Route::get('getPermisoPersonalPorComandancia/{idComandanciaAds}', ['uses' => 'FatigaController@getPermisoPersonalPorComandancia']);            
            Route::get('getFatigaComandacia/{idComandanciaAds}{fecha_fatiga}', ['uses' => 'FatigaController@getFatigaComandacia']);
            Route::get('getFatigas/{comandancia}', ['uses' => 'FatigaController@getFatigas']);
            Route::get('getFatigaCor', ['uses' => 'FatigaController@getFatigasCor']);            
            Route::get('getFatigaCor2/{fecha_fatiga}', ['uses' => 'FatigaController@getFatigasCor2']);            
            Route::get('getAreaPersona', ['uses' => 'FatigaController@getAreaPersona']);
            Route::get('getAreaPersonaExistentes', ['uses' => 'FatigaController@getAreaPersonaExistentes']);
            Route::get('getAreaPersonaID/{idPersonalAEI}', ['uses' => 'FatigaController@getAreaPersonaID']);            
            Route::get('getFechaFatigas/{fecha_fatiga}, {comandancia}', ['uses' => 'FatigaController@getFechaFatigas']);
            Route::get('getFatigaHoy/{fecha_fatiga}, {comandancia}', ['uses' => 'FatigaController@getFatigaHoy']);                        
            Route::post('saveFatiga', ['uses' => 'FatigaController@saveFatigas']);  
            Route::post('saveDetalleFatigas', ['uses' => 'FatigaController@saveDetalleFatigas']);  
            Route::post('saveAreaPersona', ['uses' => 'FatigaController@saveAreaPersona']);               
            Route::put('updateCarpeta', ['uses' => 'FatigaController@updateCarpeta']);  
            Route::put('updatePermisos', ['uses' => 'FatigaController@updatePermisos']);                         
            Route::put('updateAreaPersona/{idservicioPersonal}', ['uses' => 'FatigaController@updateAreaPersona']);                             
            });
            //Valores para el armamento
            //Route::group(['prefix' => 'armamento','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'armamento'], function(){
            Route::get('armas', ['uses' => 'ArmaCogetFatigaHoyntroller@getArma']);
            Route::get('clase_armas', ['uses' => 'ArmaController@getClaseArma']);
            Route::get('calibre_armas', ['uses' => 'ArmaController@getCalibreArma']);
            Route::get('marcas_armas', ['uses' => 'ArmaController@getMarcaArma']);
            Route::get('estadofisicoarma', ['uses' => 'ArmaController@getEstadoFisicoArma']);
            //Route::get('tipo_funcionamiento/', ['uses' => 'ArmaController@getTipoArmaFuncionamiento']);
            Route::get('tipo_armas', ['uses' => 'ArmaController@getTipoArma']);
            //Hubicacion
            //Route::get('municipio/', ['uses' => 'ArmaController@getMunicipio']);
            //Route::get('localidad/', ['uses' => 'ArmaController@getLocalidad']); 
            //Muestra armas.     
            Route::get('/show_armas', ['uses' => 'ArmaController@all_armas']);
            //Muestra armas por asignacion
            Route::get('/show_asignacion', ['uses' => 'ArmaController@personalmovimientoarma']);
            //Guardar arma
            Route::post('', ['uses' => 'ArmaController@saveArma']);
            Route::post('/CambioArma', ['uses' => 'ArmaController@CambioArma']);            
            //Route::post('ubicacion/', ['uses' => 'ArmaController@saveUbicacionArm']);
            Route::post('/adquisicion', ['uses' => 'ArmaController@saveAdquisicionArm']);
            Route::post('/asignacion', ['uses' => 'ArmaController@saveAsignacionArm']);
            Route::get('/idMatricula/{matricula}',['uses'=> 'ArmaController@getMatriculaArma']);
            Route::get('/idMatricula2/{matricula}',['uses'=> 'ArmaController@getMatriculaArma2']);
            Route::get('/idMatricula3',['uses'=> 'ArmaController@getMatriculaArma3']);
            Route::get('/PersonalArmaMovimeinto/{idPersonalAEI}',['uses'=> 'ArmaController@idpersonalmovimientoarma']);
            Route::get('/HistorialPersonalArmaMovimeinto/{idPersonalAEI}',['uses'=> 'ArmaController@idHistorialpersonalmovimientoarma']);
            Route::get('/PersonalArmaMovimeinto2/{idPersonalAEI}',['uses'=> 'ArmaController@idpersonalmovimientoarma2']);
            Route::get('/PersonalArmaMovimeinto3/{idPersonalArmaMovimeinto}',['uses'=> 'ArmaController@idpersonalmovimientoarma3']);
            Route::get('/ArmaID/{matricula}',['uses'=> 'ArmaController@armaID']);
            Route::get('/ArmaID2/{matricula}',['uses'=> 'ArmaController@armaID2']);
            Route::get('/ArmaID3/{aux}',['uses'=> 'ArmaController@armaID3']);
            Route::get('/armaDisponible/{matricula}',['uses'=> 'ArmaController@armaDisponible']);
            Route::get('/tipoadquisicion',['uses'=> 'ArmaController@getTipoAdquisicion']);
            Route::get('/idPersonalAEIArma/{idPersonalAEIArma}',['uses'=> 'ArmaController@getidPersonalAEIArma']);
            Route::put('update_disponibleArma/{idArma}', ['uses' => 'ArmaController@updateArmaDisponible']); 
            Route::put('update_disponibleArma2/{idArma}', ['uses' => 'ArmaController@updateArmaDisponible2']); 
            Route::put('update_disponibleArma3/{idPersonalArmaMovimeinto}', ['uses' => 'ArmaController@updateArmaDisponible3']); 
            Route::put('updateArma/{idArma}', ['uses' => 'ArmaController@updateArma']); 
            });
            //Route::group(['prefix' => 'vehiculos','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'vehiculos'], function(){
            Route::get('/allvehiculos', ['uses' => 'PlantillaVehiculoController@getAllVehiculo']);
            Route::get('/idplantillavehicular/{numeroSerie}', ['uses' => 'PlantillaVehiculoController@getIDPlantilaVehiculo']);            
            Route::get('/vehiculos', ['uses' => 'PlantillaVehiculoController@getVehiculo']);
            Route::get('/vehiculos2', ['uses' => 'PlantillaVehiculoController@getVehiculo2']);
            Route::get('/vehiculo_disponibles', ['uses' => 'PlantillaVehiculoController@vehiculoDisponible']);
            Route::get('/comandancia', ['uses' => 'PlantillaVehiculoController@getComandancia']);
            Route::get('/idVehiculo/{numeroSerie}',['uses'=> 'PlantillaVehiculoController@getIDVehiculo']);
            Route::get('/idVehiculo2/{numeroSerie}',['uses'=> 'PlantillaVehiculoController@getIDVehiculo2']);
            Route::get('/idVehiculo3/{numeroSerie}',['uses'=> 'PlantillaVehiculoController@getIDVehiculo3']);
            Route::get('/getIDPlantillaVehiculo/{numeroSerie}',['uses'=> 'PlantillaVehiculoController@getIDPlantillaVehiculo']);            
            Route::post('', ['uses' => 'PlantillaVehiculoController@saveVehiculo']);
            Route::post('AsignacionVehiculo', ['uses' => 'PlantillaVehiculoController@saveAsiganacionVehiculo']);
            Route::post('/AsignacionVehiculo3', ['uses' => 'PlantillaVehiculoController@saveAsiganacionVehiculo3']);
            Route::put('/updateVehiculo/{numeroSerie}', ['uses' => 'PlantillaVehiculoController@updateVehiculo']); 
            Route::put('/updateVehiculo2/{numeroSerie}', ['uses' => 'PlantillaVehiculoController@updateVehiculo2']); 
            Route::put('/updateVehiculo3/{numeroSerie}', ['uses' => 'PlantillaVehiculoController@updateVehiculo3']); 
            Route::put('/updatePlantillaVehiculo/{idplantillaVehiculo}', ['uses' => 'PlantillaVehiculoController@updatePlantillaVehiculo']);             
            });
            //Route::group(['prefix' => 'carpetas','middleware' => ['jwt.auth']], function(){
            Route::group(['prefix' => 'carpetas'], function(){
            Route::get('/diligencias',['uses'=> 'CarpetaInvestigacion@getDiligencias']);
            Route::get('/comandancias/{idComandancia}',['uses'=> 'CarpetaInvestigacion@index']);
            Route::get('/comandancias1/{idComandancia}',['uses'=> 'CarpetaInvestigacion@index1']);
            Route::get('/notificación_activa/{idPersonalAEI}',['uses'=> 'CarpetaInvestigacion@notificación_activa']);                        
            Route::get('/lista_prioridad/{idPersonalAEI}',['uses'=> 'CarpetaInvestigacion@lista_prioridad']); 
            Route::get('/lista_prioridad2/{idpersonalaeicarpeta}',['uses'=> 'CarpetaInvestigacion@lista_prioridad2']); 
            Route::get('/muestrainfo/{idComandancia}',['uses'=> 'CarpetaInvestigacion@indexV1']); 
            Route::get('/muestrainfo2/{idComandancia}',['uses'=> 'CarpetaInvestigacion@indexV2']);                        
            Route::get('/SinResponsable/{idComandancia}',['uses'=> 'CarpetaInvestigacion@SinResponsable']);      
            Route::get('/idpersonalaeicarpeta/{idpersonalaeicarpeta}',['uses'=> 'CarpetaInvestigacion@index2']);
            Route::get('/getPlaneacionTotal',['uses'=> 'CarpetaInvestigacion@getPlaneacionTotal']);            
            Route::get('/idpersonalaeicarpetaconcluidas/{idpersonalaeicarpeta}',['uses'=> 'CarpetaInvestigacion@index2Concluidas']);
            //Route::get('/idpersonalaeicarpeta/{idComandancia}',['uses'=> 'CarpetaInvestigacion@index2']);
            Route::get('idCarpetaInvestigacion/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@index3']);
            Route::get('carpestasDiligencias/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@index4']);
            Route::get('carpestasDiligenciasP/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@index5']);
            Route::get('carpestasConcluidasDiligencias/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@index6']);   
            Route::get('carpestaCoor/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@index7']);                    
            Route::get('delitos', ['uses' => 'CarpetaInvestigacion@getDelito']);
            Route::get('tipomododelitos', ['uses' => 'CarpetaInvestigacion@getTipoModoDelito']);
            Route::get('personalComandancia/{idComandancia}', ['uses' => 'CarpetaInvestigacion@getPersonalComandancia']);
            Route::get('personalComandanciaCarpeta/{idComandancia}', ['uses' => 'CarpetaInvestigacion@getpersonalComandanciaCarpeta']);
            Route::post('', ['uses' => 'CarpetaInvestigacion@saveCarpetaInv']); 
            Route::post('carpPersona', ['uses' => 'CarpetaInvestigacion@saveCarpetaInvPersona']); 
            Route::post('carpetainvdiligencias', ['uses' => 'CarpetaInvestigacion@saveCarpetaInvDiligencias']); 
            Route::post('hechoscarperta', ['uses' => 'CarpetaInvestigacion@saveHechos']);  
            Route::post('inputadovictima', ['uses' => 'CarpetaInvestigacion@saveInputadoVictima']);  
            Route::get('graficas/{comandaciacapinv}', ['uses' => 'CarpetaInvestigacion@getTotalDelitos']);
            Route::get('totalDelitosComandancia/{comandaciacapinv}', ['uses' => 'CarpetaInvestigacion@getCantidadDeDelitos']); 
            Route::get('totalEstadosComandancia/{comandaciacapinv}', ['uses' => 'CarpetaInvestigacion@getCantidadCarpetasEstatus']);   
            //Prueba
            Route::get('/progress', ['uses' => 'CarpetaInvestigacion@getProgress']);                         
            //Route::get('/progress2', ['uses' => 'CarpetaInvestigacion@getProgress2']);                         
            //Route::get('/graficas/{nombredelito},{comandaciacapinv},{idRegion}', ['uses' => 'CarpetaInvestigacion@getTotalDelitos']); 
            Route::get('/graficas2', ['uses' => 'CarpetaInvestigacion@getTotalDelitos2']); 
            Route::get('/graficas3/{idpersonalaeicarpeta}', ['uses' => 'CarpetaInvestigacion@getTotalDelitos3']); 
            Route::get('/exitecarpetadeinvestigacion/{carpetadeinvestigacion}',['uses'=> 'CarpetaInvestigacion@exiteCarpetaInv']);
            Route::get('/InfoCarpeta/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@getInfoCarpeta']);    
            
            Route::put('update_carpeta/{CarpetaInvestigacion}', ['uses' => 'CarpetaInvestigacion@updateCarpeta']); 
            Route::put('update_Notificacion/{idCarpetaInvestigacion}', ['uses' => 'CarpetaInvestigacion@update_Notificacion']);  
            Route::put('update_hechos_carpeta/{idhechos}', ['uses' => 'CarpetaInvestigacion@update_hechos_carpeta']);  
            Route::put('update_responsable_carpeta/{idcarpetainvpersonal}', ['uses' => 'CarpetaInvestigacion@update_responsable_carpeta']);  
            Route::put('update_responsable_carpeta2', ['uses' => 'CarpetaInvestigacion@update_responsable_carpeta2']); 
            Route::post('saveResponsableCarpeta', ['uses' => 'CarpetaInvestigacion@saveResponsableCarpeta']); 
            Route::put('update_inputado_victima/{idinputado_victima}', ['uses' => 'CarpetaInvestigacion@update_inputado_victima']);  
            Route::put('updateEstatusDiligencia/{idcarpetadiligencias}', ['uses' => 'CarpetaInvestigacion@updateEstatusDiligencia']);  
            

            Route::get('inputado/{carpetaInvestigacionPersona}',['uses'=> 'CarpetaInvestigacion@getInfoPersonaCarpeta']);
            Route::get('victima/{carpetaInvestigacionPersona}',['uses'=> 'CarpetaInvestigacion@getInfoPersonaCarpeta2']);  
            //Funcion que me hace el bakup de la BD.
            Route::get('PRUEBITA/ok',['uses'=> 'MySQLDumController@prueba']);  
            //Metodos para la planeacion.
            
            Route::get('info_planeacion/{idplaneacion_des}',['uses'=> 'CarpetaInvestigacion@info_planeacion']);            
            Route::get('rol_acta/{idCarpetaInvDiligenciaPlaneacion}',['uses'=> 'CarpetaInvestigacion@rol_acta']);
            Route::post('/savePlaneacion', ['uses' => 'CarpetaInvestigacion@savePlaneacion']); 
            Route::post('/savePlaneacionDes', ['uses' => 'CarpetaInvestigacion@savePlaneacionDes']);         
            //Metodos para las diligencias.
            Route::post('/saveActaDLT', ['uses' => 'CarpetaInvestigacion@saveActaDLT']); 
            Route::post('/saveActaDLTlugarintervencion', ['uses' => 'CarpetaInvestigacion@saveActaDLTlugarintervencion']); 
            Route::post('/saveActaDLTMinisterio', ['uses' => 'CarpetaInvestigacion@saveActaDLTMinisterio']); 
            Route::post('/saveSenalVisiblesCadaver', ['uses' => 'CarpetaInvestigacion@saveSenalVisiblesCadaver']);
            Route::post('/saveVestimentaCadaver', ['uses' => 'CarpetaInvestigacion@saveVestimentaCadaver']);            
            Route::get('/getcvedlt/{cve}',['uses'=> 'CarpetaInvestigacion@getcveDLT']);
            Route::put('update_carpetadiligencias/{idcarpetadiligencias}', ['uses' => 'CarpetaInvestigacion@update_carpetadiligencias']);  
            Route::put('update_planeacion/{idplaneacion}', ['uses' => 'CarpetaInvestigacion@update_planeacion']);  
            Route::get('/getIdDiligencia1/{idCarpetaInvDiligencia}',['uses'=> 'CarpetaInvestigacion@getIdDiligencia1']);  
            Route::get('/getIdDiligencia/{idCarpetaInvDiligencia}',['uses'=> 'CarpetaInvestigacion@getIdDiligencia']);  
            Route::get('/getActaDLT/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@getActaDLT']); 
            Route::get('/getEntrevista/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@getEntrevista']); 
            Route::get('/getInventarioBienes/{CarpetaInvestigacion}',['uses'=> 'CarpetaInvestigacion@getInventarioBienes']);    
            Route::get('/getInfoDiligenciaDLT/{cve}',['uses'=> 'CarpetaInvestigacion@getInfoDiligenciaDLT']);
            Route::get('/getInfoEntrevista/{cve}',['uses'=> 'CarpetaInvestigacion@getInfoEntrevista']);
            Route::get('/getlugarintervencion/{cve}',['uses'=> 'CarpetaInvestigacion@getlugarintervencion']);  
            Route::get('/getlugarintervencion2/{cve}',['uses'=> 'CarpetaInvestigacion@getlugarintervencion2']);
            Route::get('/getlugarintervencion3/{cve}',['uses'=> 'CarpetaInvestigacion@getlugarintervencion3']);
            Route::get('/getlugarintervencion4/{cve}',['uses'=> 'CarpetaInvestigacion@getlugarintervencion4']);
            Route::post('/savePersonaDiligencia', ['uses' => 'CarpetaInvestigacion@savePersonaDiligencia']);                  
        });   
         //
        });
    });