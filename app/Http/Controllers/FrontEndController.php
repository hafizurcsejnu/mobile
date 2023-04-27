<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
session_start(); //this will control back btn click effect

use Illuminate\Support\Facades\Mail;
use \App\Mail\SendMail;
use Barryvdh\DomPDF\Facade as PDF;

class FrontEndController
{
    public function __construct(){
        
     }
     public function authCheck()
     {
       $customer_id = Session::get('customer_id');
       $customer_name = Session::get('customer_name');
 
       if ($customer_id) {
         return;
       }else{
         return Redirect::to('/xyz')->send();
       }
     }

     public function myQuotations()
     {
       $this->authCheck();

      $fetch = DB::table('quotations')      
      ->where('customer_id', Session::get('customer_id'))
      ->orderBy('id','DESC')
      ->get();
      
      $data=view('pages.my_quotations')
      ->with('data',$fetch);

      return view('pages.master')
      ->with('main_content',$data);

      //return view('pages.my_quotations')->with('main_content');
    } 

    
    public function quotationDetails($id)
      {
        //$this->authCheck();

        $fetch = DB::table('quotations')
        ->where('id',$id)
        ->get();

        $data=view('pages.quotation_details')
        ->with('data',$fetch);

        return view('pages.master')
        ->with('main_content',$data);
      }



}
