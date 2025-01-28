<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaComandancia extends Model
{
    //
    protected $table ='agendacomandancia';
    protected $primaryKey = 'idAgendaComandancia';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable=[
    'idAgendaComandancia','numeroTelefonico','ext','idComandanciaFK'
];
}
