<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Auth;
use DB;

class CheckoutController extends Controller
{   
     
        // checkout section
        public function index()
        {
            if (session('user.user_type')){
              $cart = session()->get("cart"); 
              if(empty($cart)){
                //dd($cart );
                return redirect('/3dmodels')->with(session()->flash('alert-warning', 'Please add product into cart to proceed!'));
              }               
              return view('checkout');   
    
            }else{ 
              session()->put('source', 'cart');            
              return redirect('login');
            }
            
         }
         
        public function AddToCart(Request $request){
          $product = Product::where('id',$request->prod_id)->first();        
          $id = $product->id; 
          $qty = 1;
          $cart = session()->get('cart');
          // if cart is empty then this the first product
          if(!$cart) {
            $cart = [
              $id => [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $qty,
                "price" => $product->price,
                'image' => $product->image
              ]
            ];
            session()->put('cart', $cart);
            // return redirect()->back()->with('success', 'Product added to cart successfully!');
            $cart_item = session()->get('cart');
            return count($cart_item);
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {   
          $cart[$id]['quantity']++;       
          session()->put('cart', $cart);
          // return redirect()->back()->with('success', 'Product added to cart successfully!');
          $cart_item = session()->get('cart');
          return count($cart_item);
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
          "id" => $product->id,
          "name" => $product->name,
          "quantity" => 1,
          "price" => $product->price,
          'image' => $product->image
        ];
        session()->put('cart', $cart);
        $cart_item = session()->get('cart');
        return count($cart_item);
  
      }

     
  
      public function getCartProduct(){
        
      }
  
      public function updateCartItem(Request $request)
      {
        if($request->id and $request->quantity)
        {
          $cart = session()->get('cart');
          $cart[$request->id]["quantity"] = $request->quantity;
          session()->put('cart', $cart);
          session()->flash('success', 'Cart updated successfully');
        }
      }
      public function removeCartItem(Request $request)
      {
        if($request->id) {
          $cart = session()->get('cart');
          if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
          }
          session()->flash('success', 'Product removed successfully');
        }
      }
      public function getCartTotal(){
          $cart = session()->get('cart');
          $total = 0;
          foreach($cart as $item){
            $product = DB::table('products')->where('id', $item['id'])->first();
            $product_price = $product->price;
            $total += $product_price * 1 ;
          }
          return $total;
      }
      public function payment(){      
        $user = Auth::user();
        if($user){
          $cart = session()->get("cart");
          //dd($cart);
        }
        else{
          dd("Login Required");
        }
      }


 
  
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function customerRegistration(Request $request)
      {
          $data=array();
          $data['name']=$request->name;
          $data['email']=$request->email;
          $data['password']=md5($request->password);
  
          $customer_id = DB::table('customers')->insertGetId($data);
  
          if ($customer_id) {
              Session::put('customer_id',$customer_id);
              Session::put('customer_name',$request->name);
  
              return Redirect::to('/payment');
          }
      }
      
      public function customerSignin(Request $request)
      {
          $email= $request->email;
          $password= $request->password;
            
  
          $result = DB::table('customers')
          ->where('email', $email)
          ->where('password', md5($password))
          ->first();
          //var_dump($_POST);
  
          if ($result) {
              Session::put('customer_name', $result->name);
              Session::put('customer_id', $result->id);
              Session::put('message', 'Login Successfully!');
              return Redirect::to('/payment');
          }else{
              
              Session::put('exception', 'Invalid user id or password!');
              return Redirect::to('/login');
  
          }
      }
  
     
      
      public function payment1()
      {
          $payment=view('pages.payment');
          return view('pages.master')
              ->with('main_content',$payment);
      }
   
      
      public function savePayment(Request $request)
      {
      //     $data=array();
      //     $data['id']=$request->customer_id;
      //     $data['name']=$request->name;
      //     $data['email']=$request->email;
      //     $data['mobile']=$request->mobile;
      //     $data['address']=$request->address;
      //     $data['city']=$request->city;
      //     $data['zip']=$request->zip;
      //     $data['country']=$request->country;
  
      //    $shipping_id = DB::table('shipping')->insertGetId($data);
      //    Session::put('shipping_id', $shipping_id);
  
      //     return Redirect::to('/payment');
  
      $checkout=view('pages.save_payment');
      return view('pages.master')
              ->with('main_content',$checkout);
          
      }
  

}
