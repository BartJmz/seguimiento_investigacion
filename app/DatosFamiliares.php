<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosFamiliares extends Model
{
    //
    protected $table = 'datosfamiliares';
    protected $primaryKey= 'idDatosFamiliares';
    public $timestamps = false;
    public $incrementing = false;
 
    protected $fillable = [
        'idDatosFamiliares','nombreFamiliar',
        'apPatFamiliar','apMatFamiliar','sexo','fechaDeNacimientoFamiliar',
        'idTelefonoFamiliar','idParentescoFamiliar','responsable','cve'];
     //protected $guarded = ['idServicios'];
     
}
