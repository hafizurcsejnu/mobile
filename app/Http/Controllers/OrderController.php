<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start(); //this will control back btn click effect

use Illuminate\Support\Facades\Mail;
use \App\Mail\SendMail;
use Barryvdh\DomPDF\Facade as PDF;


class OrderController
{
       
    public function __construct(){
        //echo $user_id = Session::get('user_id');
     }
     public function authCheck()
     {
       $user_id = Session::get('user_id');
       $name = Session::get('name');
 
       if ($user_id) {
         return;
       }else{
         return Redirect::to('/xyz')->send();
       }
     }
 
 
}
