<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use Stripe;
session_start();

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use Stripe\Error\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe_CardError;
use Stripe\Stripe_InvalidRequestError;
use Stripe_Error;


class PaymentController extends Controller
{
    public function testMail(){
        MailController::orderEmail('Hafiz', 'hafizur.csejnu@gmail.com', 106);
        return 'done';
    }
    public function createPayment()
    {         
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                ENV('PAYPAL_CLIENT'),     // ClientID
                ENV('PAYPAL_SECRET')      // ClientSecret
            )
        );
        
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // $item1 = new Item();
        // $item1->setName('Ground Coffee 40 oz')
        //     ->setCurrency('USD')
        //     ->setQuantity(1)
        //     ->setSku("123123") // Similar to `item_number` in Classic API
        //     ->setPrice(7.5);

        // $item2 = new Item();
        // $item2->setName('Granola bars')
        //     ->setCurrency('USD')
        //     ->setQuantity(5)
        //     ->setSku("321321") // Similar to `item_number` in Classic API
        //     ->setPrice(2);

        // $itemList = new ItemList();
        // $itemList->setItems(array($item1, $item2));


        $items = array();
        $subtotal = 0;
        $tax = 0;

        $cart = session()->get('cart');
        //dd($cart);
          $total = 0;
        foreach($cart as $item){
            $total = $total + ($item['quantity']*$item['price']);
              //dd($item['name']);
        }        
        $currency = 'USD';
        //dd($cart);
        
        foreach($cart as $product){
           
            $item = new Item();
            $item->setName($product['name'])
            ->setDescription($product['id'])
            ->setCurrency($currency)
            ->setQuantity($product['quantity'])
            ->setPrice($product['price']);

            $items[] = $item;  

            //$subtotal += $product['quantity'] * $product['price']; //quantity has issues from cart page
            $subtotal += $product['price'];
            //$tax += $product->tax;
            $tax += 0;
        } 
        $itemList = new ItemList();
        $itemList->setItems($items);

        $total=$subtotal+$tax;

        if(session('coupon_discount')>0){
            $total = $total-session('coupon_discount');
        }
        
        $details = new Details();
        $details->setShipping(0)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        //$baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(ENV('APP_URL').'/execute-payment')
            ->setCancelUrl(ENV('APP_URL').'/cancel-payment');

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);

        return redirect($approvalUrl = $payment->getApprovalLink());


    }
    
    public function execute()
    {
        // After Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                ENV('PAYPAL_CLIENT'),     // ClientID
                ENV('PAYPAL_SECRET') 
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        //dd($payment);
       
        $items = array();
        $subtotal = 0;
        $tax = 0;
        
        $cart = session()->get('cart');
        //dd($cart);
        $currency = 'USD';
        
        foreach($cart as $product){            
            $item = new Item();            
            $item->setName($product['name'])
            ->setDescription($product['id'])
            ->setCurrency($currency)
            ->setQuantity($product['quantity'])
            ->setPrice($product['price']);

            $items[] = $item;
            //$subtotal += $product['quantity'] * $product['price']; //quantity has issues from cart page
            $subtotal += $product['price'];
            //$tax += $product->tax;
            $tax += 0;
        }
        $itemList = new ItemList();
        $itemList->setItems($items);

        $total=$subtotal+$tax;
        if(session('coupon_discount')>0){
            $total = $total-session('coupon_discount');
        }

        $details = new Details();
        $details->setShipping(0)
            ->setTax($tax)
            ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);
            
        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $apiContext);

        //return "<pre>".$result."</pre>";        
        $data = json_decode($result,true);              
       
        //$product_qty = sizeof($items);
        $sub_total = $data['transactions'][0]['amount']['details']['subtotal'];
        $tax = $data['transactions'][0]['amount']['details']['tax'];
        $total_price = $data['transactions'][0]['amount']['total'];
        $item_list = $data['transactions'][0]['item_list']['items'];
        $payment_method = $data['payer']['payment_method'];
        $item_qty = sizeof($item_list);
        
        //orders table
        $order_data=array();
        $order_data['user_id']=session('user_id');
        $order_data['total_item']=$item_qty;
        $order_data['sub_total']=$sub_total;
        $order_data['tax']=$tax;
        $order_data['total_price']=$total_price;
        $order_data['payment_method']=$payment_method;
        $order_data['payment_id']=$data['id'];
        $order_data['status']='Recieved';
        if(session('coupon_discount')>0){
            $order_data['discount_amount']=session('coupon_discount');
            $order_data['total_price']=$total_price-session('coupon_discount');
        }
        $order_id = DB::table('orders')->insertGetId($order_data);

        //order details table 
        foreach($item_list as $item){
            $order_details=array();
            $order_details['user_id'] = session('user_id');
            $order_details['order_id'] = $order_id;
            $order_details['product_id'] = $item['description'];
            $order_details['quantity'] = $item['quantity'];
            $order_details['price'] = $item['price'];
            $order_details['sub_total'] = $item['price']*$item['quantity'];             
            $order_details['tax'] = $item['tax']; 
            $order_details['total_price'] = $order_details['sub_total'] + $item['tax']; 
            DB::table('order_details')->insert($order_details);          
        }


        unset($cart);
        session()->put('cart', '');

        //unset($cart);
        session()->put('coupon_discount', '');

        $user_id = session('user_id');
        $user = DB::table('users')
        ->where('id', $user_id)
        ->orderBy('id','asc')
        ->first();
        
        MailController::orderEmail($user->name, $user->email, $order_id);
        
        return redirect('my-account')->with(session()->flash('alert-success', 'You payment has been done successfully.'));  
        


    }

    public function stripeCheckout(Request $request)
    {              
        //require 'vendor/autoload.php';
        // This is a public sample test API key.
        // To avoid exposing it, don't submit any personally identifiable information through requests with this API key.
        // Sign in to see your own test API key embedded in code samples.
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'https://ready3dmodels.com';

        $cart = session()->get('cart');
        $currency = 'USD';
        $i=0;
        $sub_total = 0;
        $tax = 0;
        foreach($cart as $product){
            $i++;
            $sub_total += $product['quantity'] * $product['price'];
            $tax += 0;
        } 
        $item_qty = $i;
        $total_price = $sub_total + $tax;
        $payment_method ='Stripe';

        if(session('coupon_discount')>0){            
            $total_price = $total_price-session('coupon_discount');
        }
        if($total_price<10){           
            return redirect()->back()->with('success', 'Total amount can not be less than $10.');  
        }
        
        

        $checkout_session = \Stripe\Checkout\Session::create([            
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price_data' => [
                'currency' => 'USD',
                'product_data' => [
                    'name' => 'Payments of 3D Models.',
                ], 
                'unit_amount' => $total_price * 100, 
            ], 
            'quantity' => 1,   
        ]], 
        'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/payment-success',
            'cancel_url' => $YOUR_DOMAIN . '/cancel',
        ]);

        return Redirect($checkout_session->url); 
    } 

    public function paymentSuccess(){
        
        $cart = session()->get('cart');
        $currency = 'USD';
        $i=0;
        $sub_total = 0;
        $tax = 0;
        foreach($cart as $product){
            $i++;
            $sub_total += $product['quantity'] * $product['price'];
            $tax += 0;
        }  
        $item_qty = $i;
        $total_price = $sub_total + $tax;
        $payment_method ='Stripe';
        
        //orders table
        $order_data=array();
        $order_data['user_id']=session('user_id');
        $order_data['total_item']=$item_qty;
        $order_data['sub_total']=$sub_total;
        $order_data['tax']=$tax;
        $order_data['total_price']=$total_price;
        $order_data['payment_method']=$payment_method;
        //$order_data['payment_id']=$data['id'];
        $order_data['status']='Completed';
        if(session('coupon_discount')>0){
            $order_data['discount_amount']=session('coupon_discount');
            $order_data['total_price']=$total_price-session('coupon_discount');
        }
        $order_id = DB::table('orders')->insertGetId($order_data);


        //order details table   
        foreach($cart as $item){
            $order_details=array();
            $order_details['user_id'] = session('user_id');
            $order_details['order_id'] = $order_id;
            $order_details['product_id'] = $item['id'];
            $order_details['quantity'] = $item['quantity'];
            $order_details['price'] = $item['price'];
            $order_details['tax'] = 0; 
            $order_details['sub_total'] = $item['price']*$item['quantity'];  
            DB::table('order_details')->insert($order_details);          
        } 

        unset($cart);
        session()->put('cart', '');

        $user_id = session('user_id');
        $user = DB::table('users')
        ->where('id', $user_id)
        ->orderBy('id','asc')
        ->first();
        
        MailController::orderEmail($user->name, $user->email, $order_id);

        return redirect('my-account')->with(session()->flash('alert-success', 'You payment has been done successfully.')); 
        
    }
    public function stripePayment(Request $request)
    {              
        $cart = session()->get('cart');
        $currency = 'USD';
        $i=0;
        $sub_total = 0;
        $tax = 0;
        foreach($cart as $product){
            $i++;
            $sub_total += $product['quantity'] * $product['price'];
            $tax += 0;
        }
        $item_qty = $i;
        $total_price = $sub_total + $tax;
        $payment_method ='Stripe';

        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $total_price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment From Ready3dmodels.com" 
        ]);

        //orders table
        $order_data=array();
        $order_data['user_id']=session('user_id');
        $order_data['total_item']=$item_qty;
        $order_data['sub_total']=$sub_total;
        $order_data['tax']=$tax;
        $order_data['total_price']=$total_price;
        $order_data['payment_method']=$payment_method;
        //$order_data['payment_id']=$data['id'];
        $order_data['status']='Completed';
        if(session('coupon_discount')>0){
            $order_data['discount_amount']=session('coupon_discount');
            $order_data['total_price']=$total_price-session('coupon_discount');
        }
        $order_id = DB::table('orders')->insertGetId($order_data);


        //order details table   
        foreach($cart as $item){
            $order_details=array();
            $order_details['user_id'] = session('user_id');
            $order_details['order_id'] = $order_id;
            $order_details['product_id'] = $item['id'];
            $order_details['quantity'] = $item['quantity'];
            $order_details['price'] = $item['price'];
            $order_details['tax'] = 0; 
            $order_details['sub_total'] = $item['price']*$item['quantity'];  
            DB::table('order_details')->insert($order_details);          
        } 

        unset($cart);
        session()->put('cart', '');

        $user_id = session('user_id');
        $user = DB::table('users')
        ->where('id', $user_id)
        ->orderBy('id','asc')
        ->first();
        
        MailController::orderEmail($user->name, $user->email, $order_id);

        return redirect('my-account')->with(session()->flash('alert-success', 'You payment has been done successfully.')); 
       
    }


}
