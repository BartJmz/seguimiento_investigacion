<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Response;

class MySQLDumController extends Controller
{
    //
    public function prueba(){
    Artisan::call('db:dump');
    return response()->json(['sucessfull' => 'OK'], 200);
    }
}