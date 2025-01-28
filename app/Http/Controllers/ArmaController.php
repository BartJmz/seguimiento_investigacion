<?php

namespace App\Http\Controllers;
use App\Arma;
use App\TipoArma; 
use App\UbicacionArma;
use App\ClaseArma;
use App\CalibreArma;
use App\MarcaArma;
use App\CambioArma;
use App\EstadoFisicoArma;
use App\AdquisicionArma;
use App\TipoAdquisicionArma;
use App\PersonalMovimientoArma;
use App\Municipio;
use App\Localidad;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;
use Illuminate\Http\Request;

class ArmaController extends Controller
{
    //
    public function getArma(){
        $arma = Arma::get();
        return $arma;
    }
    public function getClaseArma(){
        $ClaseArma = ClaseArma::get();
        return $ClaseArma;
    }
    public function getCalibreArma(){
        $CalibreArma = CalibreArma::get();
        return $CalibreArma;
    }
    public function getMarcaArma(){
        $MarcaArma = MarcaArma::get();
        return $MarcaArma;
    }
    public function getEstadoFisicoArma(){
        $EstadoFisicoArma = EstadoFisicoArma::get();
        return $EstadoFisicoArma;
    }
    public function getTipoArma(){
        $TipoArma = TipoArma::get();
        return $TipoArma;
    }

    /*
    public function getMunicipio(){
        $Municipio = Municipio::get();
        return $Municipio;
    }
    public function getLocalidad(){
        $Localidad = Localidad::get();
        return $Localidad;
    }
    */
    //Mostrar todas las armas
    public function all_armas(){
         $allarmas = DB::table('arma')
         ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
         ->join('calibrearma','arma.calibre', '=','calibrearma.idCalibre')
         ->join('marcaarma','arma.marca', '=','marcaarma.idMarcaArma')
         ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
         ->join('estadofisicoarma','arma.estadoFisico', '=','estadofisicoarma.idEstadoFisicoArma')
         ->join('tipoadquisicionarma','arma.tipoCompra', '=','tipoadquisicionarma.idtipoadquisicion')
         ->select(
            'arma.idArma',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.coloresArma',
            'arma.adquisicion',
            'arma.observacionesArma',
            'arma.status',
            'clasearma.claseArma',
            'calibrearma.calibre',
            'marcaarma.marca',
            'tipoarma.tipoArama',
            'estadofisicoarma.estodofisico',
            'tipoadquisicionarma.tipoadquisicion'
         )
         ->orderBy('arma.fechaRegistroArma', 'asc')
         //->groupBy('comandancia.NombreComandancia')
         ->get();
         return $allarmas;
     }
     public function armaID($matricula){
        $allarmas = DB::table('arma')
        ->where( 'arma.matricula','=', $matricula)
        ->select(
            'arma.idArma',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.coloresArma',
            'arma.adquisicion',
            'arma.observacionesArma',
            'arma.status',
            'arma.clase_arma',
            'arma.calibre',
            'arma.marca',
            'arma.tipoArma',
            'arma.estadoFisico',
            'arma.tipoCompra'
         )
        ->orderBy('arma.fechaRegistroArma', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $allarmas;
    }
    public function armaID2($matricula){
        $allarmas = DB::table('arma')
        ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
        ->join('calibrearma','arma.calibre', '=','calibrearma.idCalibre')
        ->join('marcaarma','arma.marca', '=','marcaarma.idMarcaArma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        ->join('estadofisicoarma','arma.estadoFisico', '=','estadofisicoarma.idEstadoFisicoArma')
        ->join('tipoadquisicionarma','arma.tipoCompra', '=','tipoadquisicionarma.idtipoadquisicion')
        ->where( 'arma.matricula','=', $matricula)
        ->select(
            'arma.idArma',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.coloresArma',
            'arma.adquisicion',
            'arma.observacionesArma',
            'arma.status',
            'clasearma.claseArma',
            'calibrearma.calibre',
            'marcaarma.marca',
            'tipoarma.tipoArama',
            'estadofisicoarma.estodofisico',
            'tipoadquisicionarma.tipoadquisicion'
         )
        ->orderBy('arma.fechaRegistroArma', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $allarmas;
    }
    public function armaID3($aux){
        //1 - Arma corta
        //2 - Arma larga
        $allarmas = DB::table('arma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        ->where('arma.tipoArma','=', $aux)
        ->where('arma.status','=', 1)
        ->select(
            'arma.idArma',
            'arma.matricula'            
         )  
        ->orderBy('arma.fechaRegistroArma', 'asc')
        //->groupBy('comandancia.NombreComandancia')
        ->get();
        return $allarmas;
    }
    public function armaDisponible($matricula){
        $armaDisponible = DB::table('arma')
        ->where( 'arma.matricula','=', $matricula)
        ->select(
           'arma.idArma',
           'arma.status'
        )
        ->get();
        return $armaDisponible;
    }
     public function personalmovimientoarma(){
        $personalmovimientoarma = DB::table('personalmovimientoarma')
        ->join('movimientoarma','personalmovimientoarma.idTipoMovimeintoArma', '=','movimientoarma.idmovimientoarma')
        ->join('personalaei','personalmovimientoarma.idPersonalAEIArma', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        /*
        ->join('arma','personalmovimientoarma.idArmaMovimiento', '=','arma.idArma')
        ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        */
        ->select(
            'personalmovimientoarma.idPersonalArmaMovimeinto',
            'personalmovimientoarma.estatusdelarma',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.tipoSanguineo',
            'persona.curp',
            'persona.rfc',
            'persona.imss',
            'persona.sexo'
            /*
            'arma.calibre',
            'arma.marca',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.estadoFisico',
            'arma.coloresArma',
            'arma.status',
            'tipoarma.tipoArama',
            'clasearma.claseArma'
            'personalmovimientoarma.fechaMovimientoArma',
            'personalmovimientoarma.motivoMovimiento',
            'personalmovimientoarma.CarpetaDeInvsArma',
            'movimientoarma.descripcion'
            */
        )
        ->get();
        return $personalmovimientoarma;
    }
    public function idpersonalmovimientoarma($idPersonalAEI){
        $personalmovimientoarma = DB::table('personalmovimientoarma')
        ->join('movimientoarma','personalmovimientoarma.idTipoMovimeintoArma', '=','movimientoarma.idmovimientoarma')
        ->join('personalaei','personalmovimientoarma.idPersonalAEIArma', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('arma','personalmovimientoarma.idArmaMovimiento', '=','arma.matricula')
        ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
        ->join('calibrearma','arma.calibre', '=','calibrearma.idCalibre')
        ->join('marcaarma','arma.marca', '=','marcaarma.idMarcaArma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        ->join('estadofisicoarma','arma.estadoFisico', '=','estadofisicoarma.idEstadoFisicoArma')
        ->join('tipoadquisicionarma','arma.tipoCompra', '=','tipoadquisicionarma.idtipoadquisicion')
        ->where('personalaei.idPersonalAEI','=', $idPersonalAEI)
        ->where('personalmovimientoarma.status_arma','=', 1)
        ->select(
            'personalmovimientoarma.idPersonalArmaMovimeinto',
            'personalmovimientoarma.estatusdelarma',
            'personalaei.cuip',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.tipoSanguineo',
            'persona.curp',
            'persona.rfc',
            'persona.imss',
            'persona.sexo',
            'arma.calibre',
            'arma.marca',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.estadoFisico',
            'arma.coloresArma',
            'arma.adquisicion',
            'arma.status',
            'clasearma.claseArma',
            'calibrearma.calibre',
            'marcaarma.marca',
            'tipoarma.tipoArama',
            'estadofisicoarma.estodofisico',
            'tipoadquisicionarma.tipoadquisicion',
            'personalmovimientoarma.fechaMovimientoArma',
            'personalmovimientoarma.motivoMovimiento',
            'personalmovimientoarma.CarpetaDeInvsArma',
            'movimientoarma.descripcion'
        )
        ->get();
        return $personalmovimientoarma;
    }
    public function idHistorialpersonalmovimientoarma($idPersonalAEI){
        $personalmovimientoarma = DB::table('personalmovimientoarma')
        ->join('movimientoarma','personalmovimientoarma.idTipoMovimeintoArma', '=','movimientoarma.idmovimientoarma')
        ->join('personalaei','personalmovimientoarma.idPersonalAEIArma', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('arma','personalmovimientoarma.idArmaMovimiento', '=','arma.matricula')
        ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
        ->join('calibrearma','arma.calibre', '=','calibrearma.idCalibre')
        ->join('marcaarma','arma.marca', '=','marcaarma.idMarcaArma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        ->join('estadofisicoarma','arma.estadoFisico', '=','estadofisicoarma.idEstadoFisicoArma')
        ->join('tipoadquisicionarma','arma.tipoCompra', '=','tipoadquisicionarma.idtipoadquisicion')
        ->where('personalaei.idPersonalAEI','=', $idPersonalAEI)
        ->select(
            'personalmovimientoarma.idPersonalArmaMovimeinto',
            'personalmovimientoarma.estatusdelarma',
            'personalaei.cuip',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.tipoSanguineo',
            'persona.curp',
            'persona.rfc',
            'persona.imss',
            'persona.sexo',
            'arma.calibre',
            'arma.marca',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.estadoFisico',
            'arma.coloresArma',
            'arma.adquisicion',
            'arma.status',
            'clasearma.claseArma',
            'calibrearma.calibre',
            'marcaarma.marca',
            'tipoarma.tipoArama',
            'estadofisicoarma.estodofisico',
            'tipoadquisicionarma.tipoadquisicion',
            'personalmovimientoarma.fechaMovimientoArma',
            'personalmovimientoarma.motivoMovimiento',
            'personalmovimientoarma.CarpetaDeInvsArma',
            'movimientoarma.descripcion'
        )
        ->orderBy('arma.fechaRegistroArma', 'asc')
        ->get();
        return $personalmovimientoarma;
    }
    public function idpersonalmovimientoarma2($idPersonalAEI){
        $personalmovimientoarma = DB::table('personalmovimientoarma')
        ->join('movimientoarma','personalmovimientoarma.idTipoMovimeintoArma', '=','movimientoarma.idmovimientoarma')
        ->join('personalaei','personalmovimientoarma.idPersonalAEIArma', '=','personalaei.idPersonalAEI')
        ->join('persona','personalaei.personaID', '=','persona.idPersona')
        ->join('arma','personalmovimientoarma.idArmaMovimiento', '=','arma.matricula')
        ->join('clasearma','arma.clase_arma', '=','clasearma.idClaseArma')
        ->join('calibrearma','arma.calibre', '=','calibrearma.idCalibre')
        ->join('marcaarma','arma.marca', '=','marcaarma.idMarcaArma')
        ->join('tipoarma','arma.tipoArma', '=','tipoarma.idtipoArma')
        ->join('estadofisicoarma','arma.estadoFisico', '=','estadofisicoarma.idEstadoFisicoArma')
        ->join('tipoadquisicionarma','arma.tipoCompra', '=','tipoadquisicionarma.idtipoadquisicion')
        ->where('personalaei.idPersonalAEI','=', $idPersonalAEI)
        ->where('arma.status','=', 0)
        ->select(
            'personalmovimientoarma.idPersonalArmaMovimeinto',
            'personalmovimientoarma.estatusdelarma',
            'personalaei.idPersonalAEI',
            'personalaei.cuip',
            'persona.nombrePersona',
            'persona.apPat',
            'persona.apMat',
            'persona.tipoSanguineo',
            'persona.curp',
            'persona.rfc',
            'persona.imss',
            'persona.sexo',
            'arma.calibre',
            'arma.marca',
            'arma.modelo',
            'arma.matricula',
            'arma.foliosREGFED_C',
            'arma.foliosREGFED_D',
            'arma.fechaRegistroArma',
            'arma.materialesCompoArma',
            'arma.estadoFisico',
            'arma.coloresArma',
            'arma.status',
            'clasearma.claseArma',
            'calibrearma.calibre',
            'marcaarma.marca',
            'tipoarma.tipoArama',
            'estadofisicoarma.estodofisico',
            'tipoadquisicionarma.tipoadquisicion',
            'personalmovimientoarma.fechaMovimientoArma',
            'personalmovimientoarma.motivoMovimiento',
            'personalmovimientoarma.CarpetaDeInvsArma',
            'movimientoarma.descripcion',
            'personalmovimientoarma.fechaMovimientoArma',
            'personalmovimientoarma.motivoMovimiento',
            'personalmovimientoarma.CarpetaDeInvsArma',
            'movimientoarma.descripcion'
        )
        ->get();
        return $personalmovimientoarma;
    }
    public function idpersonalmovimientoarma3($idPersonalArmaMovimeinto){
        $PersonalArmaMovimeinto = DB::table('personalmovimientoarma')
        ->where('personalmovimientoarma.idPersonalArmaMovimeinto','=', $idPersonalArmaMovimeinto)
        //->where('arma.status','=', 0)
        ->select(
            'personalmovimientoarma.idPersonalArmaMovimeinto',
            'personalmovimientoarma.status_arma',
            'personalmovimientoarma.idPersonalAEIArma'
        )
        ->get();
        return $PersonalArmaMovimeinto;
    }
    public function saveArma(Request $request){
        $armas= new Arma();
        $armas -> fill($request -> all());
        $armas -> status =1;
        $armas -> adquisicion ="SEDENA";
        $armas->save();
        return $armas;
    }
    public function CambioArma(Request $request){
        $cambioarmas= new CambioArma();
        $cambioarmas -> fill($request -> all());
        $cambioarmas->save();
        return $cambioarmas;
    }
    /*
    public function saveUbicacionArm(Request $request){
        $ubicacion_armas= new UbicacionArma();
        $ubicacion_armas -> fill($request -> all());
        $ubicacion_armas->save();
        return $ubicacion_armas;
    }
   */ 
    public function saveAdquisicionArm(Request $request){
        $AdquisicionArma= new AdquisicionArma();
        $AdquisicionArma -> fill($request -> all());
        $AdquisicionArma->save();
        return $AdquisicionArma;
    }
    public function saveAsignacionArm(Request $request){
        $AsignacionArma= new PersonalMovimientoArma();
        $AsignacionArma -> fill($request -> all());
        $AsignacionArma->save();
        return $AsignacionArma;
    }
    public function updateArmaDisponible(Request $request, $idArma){
        $Actulizar = Arma::find($idArma);
        $Actulizar -> fill($request -> all());
        $Actulizar -> status =0;
        $Actulizar -> save();
        return $Actulizar;
       // return var_dump($comandancias);
    }
    public function updateArmaDisponible2(Request $request, $idArma){
        $Actulizar2 = Arma::find($idArma);
        $Actulizar2 -> fill($request -> all());
        $Actulizar2 -> status =1;
        $Actulizar2 -> save();
        return $Actulizar2;
       // return var_dump($comandancias);
    }
    public function updateArmaDisponible3(Request $request, $idPersonalArmaMovimeinto){
        $Actulizar3 = PersonalMovimientoArma::find($idPersonalArmaMovimeinto);
        $Actulizar3 -> fill($request -> all());
        $Actulizar3 -> status_arma =0;
        $Actulizar3 -> save();
        return $Actulizar3;
       // return var_dump($comandancias);
    }
    
    public function updateArma(Request $request, $idArma){
        $Actulizar = Arma::find($idArma);
        $Actulizar -> fill($request -> all());
        $Actulizar -> save();
        return $Actulizar;
       // return var_dump($comandancias);
    }
    public function getMatriculaArma($matricula){
        $area = DB::table('arma')
        ->where('arma.matricula','=', $matricula)
        ->select('arma.idArma')
        ->get();
        return $area;
    }
    public function getMatriculaArma2($matricula){
        $area = DB::table('arma')
        ->where('arma.matricula','=', $matricula)
        ->where('arma.status','=', 1)
        ->select('arma.idArma')
        ->get();
        return $area;
    }
    public function getMatriculaArma3(){
        $area = DB::table('arma')
        ->where('arma.status','=', 1)
        ->select(
            'arma.idArma',
            'arma.matricula'
        )
        ->get();
        return $area;
    }
    
    public function getTipoAdquisicion(){
        $TipoAdquisicionArma = TipoAdquisicionArma::get();
        return $TipoAdquisicionArma;
    }
    public function getidPersonalAEIArma($idPersonalAEIArma){
        $personalmovimientoarma = DB::table('personalmovimientoarma')
        ->where('personalmovimientoarma.idPersonalAEIArma','=', $idPersonalAEIArma)
        ->select('personalmovimientoarma.idPersonalAEIArma')
        ->get();
        return $personalmovimientoarma;
    }
   
}
