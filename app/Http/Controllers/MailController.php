<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SignupEmail;
use App\Mail\ResetPasswordEmail;
use App\Mail\ContactEmail;
use App\Mail\CustomServiceEmail;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function signupEmail($name, $email, $verification_code){
        $data = [
            'name' => $name,
            'verification_code' => $verification_code
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }

    public static function resetPasswordEmail($email, $reset_pass_code){
        $data = [
            'email' => $email,
            'reset_pass_code' => $reset_pass_code
        ];
        Mail::to($email)->send(new ResetPasswordEmail($data));
    }

    public static function contactEmail($name, $email, $phone, $subject, $message, $source){
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message
        ];
        Mail::to('admin@ordevs.com')->send(new CustomServiceEmail($data));

        // if($source == 'contact_page'){
        //     Mail::to('admin@ready3dmodels.com')->send(new ContactEmail($data));
        // }elseif($source == 'service_page'){
        //     //Mail::to('admin@ready3dmodels.com')->send(new CustomServiceEmail($data));
        //     Mail::to('hafizur.csejnu@gmail.com')->send(new CustomServiceEmail($data));
        // }
        
    }

    public static function orderEmail($name, $email, $order_id){
        $data = [
            'name' => $name,
            'order_id' => $order_id
        ];
        Mail::to($email)->send(new OrderEmail($data));
    }

}
