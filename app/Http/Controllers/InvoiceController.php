<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{   

    use DebitCreditTrait;  
    public function find_product(Request $request){
        $product = DB::table('products')
            ->where('id', $request->productId)
            ->first();
        $serials = DB::table('product_stock_details')
            ->where('product_id', $request->productId)
            ->get();
        // dd($product);
        return response()->json(['success'=>true,'data'=>$product, 'serials'=>$serials]);
        return $product;
    }
    public function find_product_sn(Request $request){
        if(session('bt') == 'c'){
          $product = DB::table('products')
          ->where('barcode', $request->product_sn)
          ->where('client_id', session('client_id'))
          ->first();
        } 
        else if(session('bt') == 'd' || session('bt') == 'b'){
          $product = DB::table('products')
          ->where('product_code', $request->product_sn)
          ->where('client_id', session('client_id'))
          ->first();
        }
        else{
          $product_stock = DB::table('product_stock_details')
          ->where('product_sn', $request->product_sn)
          ->where('client_id', session('client_id'))
          ->first();

          $product = DB::table('products')
          ->where('id', $product_stock->product_id)
          ->first();
        }
        
        // dd($product);
        if($product){
          return response()->json(['success'=>true,'data'=>$product]);
        }else{
          return response()->json(['success'=>false,'data'=>'404']);
        }        
    }
    public function find_imei(Request $request){       
        $product_stock = DB::table('product_stock_details')
        ->where('imei', $request->imei)
        ->where('client_id', session('client_id'))
        ->first();

        $product = DB::table('products')
        ->where('id', $product_stock->product_id)
        ->first();
        
        
        // dd($product);
        if($product){
          return response()->json(['success'=>true,'data'=>$product]);
        }else{
          return response()->json(['success'=>false,'data'=>'404']);
        }        
    }
    
    public function find_customer(Request $request){
        $customer = DB::table('customers')
            ->where('id', $request->customerId)
            ->first();
        // dd($product);
        return response()->json(['success'=>true,'data'=>$customer]);
        return $customer;
    }    
    
    public function find_employee(Request $request){
        $employee = DB::table('employees')
            ->where('id', $request->employeeId)
            ->first();
        // dd($product);
        return response()->json(['success'=>true,'data'=>$employee]);
        return $employee;
    }
    
    public function find_discount(Request $request){
        $discount = DB::table('coupons')
            ->where('code', $request->coupon_code)
            ->where('active', 'on')
            ->first();
        if($discount){
          $discount_type = $discount->discount_type;
          $total_price = $request->total_price;
          if($discount_type == 'Percentage'){
            $discount_amount = floor($total_price * $discount->discount_amount / 100);
          }else{
            $discount_amount = $discount->discount_amount;
          }
        }
        else{
          $discount_amount = 0;
          $data = 'Invalid';
        }       
        // dd($product);
        return response()->json(['success'=>true,'data'=>$discount_amount]);
        return $discount;
    }

    public function index()
    {
        $orderData = DB::table('orders')
        ->join('customers', 'orders.customer_id', '=', 'customers.id')       
        ->select('orders.*', 'customers.title as customer', 'customers.mobile as mobile')
        ->where('orders.client_id', session('client_id'))
        ->where('orders.active', 'on')
        ->orderby('orders.id', 'desc')
        ->get();        

        $orders=view('admin.invoices')
        ->with('order',$orderData);

        return view('admin.master')
        ->with('main_content',$orders);      
    }
    public function dueInvoices()
    {
        $orderData = DB::table('orders')
        ->join('customers', 'orders.customer_id', '=', 'customers.id')       
        ->select('orders.*', 'customers.title as customer', 'customers.mobile as mobile')
        ->where('orders.client_id', session('client_id'))
        ->where('orders.status', 'due')
        ->where('orders.active', 'on')
        ->orderby('orders.id', 'desc')
        ->get();        

        $orders=view('admin.due_invoices')
        ->with('order',$orderData);

        return view('admin.master')
        ->with('main_content',$orders);      
    }

    public function show($id)
    {
        $order = DB::table('orders')
                ->where('id',$id)
                ->first();

        $customer = DB::table('customers')
                ->where('id',$order->customer_id)
                ->first();       

        $products = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name as product_name')
                ->where('order_id',$id)
                ->get();     
     
        return view('admin.invoice_details', ['order' => $order, 'products' => $products, 'customer' => $customer]);
        // return \Response::json($post_data);        
    }       

      public function create()
      {    
        return view('admin.invoice_add'); 
      }  
      public function create2()
      {    
        return view('admin.invoice_add_m'); 
      }  
      
      public function invoiceStock()
      {    
          return view('admin.invoice_stock');
      }
      public function createInvoice()
      {    
        if(session('bt') == 'd' || session('bt') == 'b'){
          return view('admin.invoice_create');
        }
        else if(session('bt') == 'm'){
          return view('admin.invoice_add_m');          
        }
        else if(session('bt') == 'c'){
          return view('admin.invoice_add3');
        }
        else{
          return view('admin.invoice_add');
        }        
      }
      public function createWholesale()
      {   
        if(session('bt') == 'm'){
          return view('admin.invoice_add_m_wholesale');          
        } 
      }  

      public function sftToAkijBoxAndPcs($product_id, $qty){
        $not_found =0;
        $product = DB::table('products')
                ->where('id',$product_id)
                ->first();
        $size = $product->model;
        //dd($size);

        if($size == '8x12'){
          $unit_sft = 8*12 / 144;
          $box_pcs = 25;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10x16'){
          $unit_sft = 10*16 / 144;
          $box_pcs = 15;
          $box_sft = $box_pcs * $unit_sft;
        }        
        else if($size == '12x12'){
          $unit_sft = 12*12 / 144;
          $box_pcs = 13;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x20'){
          $unit_sft = 12*20 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x24'){
          $unit_sft = 12*24 / 144;
          $box_pcs = 6;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x12'){
          $unit_sft = 12*12 / 144;
          $box_pcs = 13;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '16x16'){
          $unit_sft = 16*16 / 144;
          $box_pcs = 10;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x24'){
          $unit_sft = 24*24 / 144;
          $box_pcs = 4;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x48'){
          $unit_sft = 24*48 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '32x32'){
          $unit_sft = 32*32 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }
        else{
          $unit_sft = 1;
          $box_pcs = 1;
          $box_sft = $box_pcs * $unit_sft;
          $not_found = 1;
        }

        $number_of_box = $qty/$box_sft;
        $box = floor($number_of_box);    // int
        $box_fraction = $number_of_box - $box; // fraction
        $pcs = floor($box_pcs * $box_fraction); 
        
        if($not_found == 1){
          return "-_-";
        }else{
          return $box.'_'.$pcs;
        }
      } 
      public function akij(){
        $product_id = 576;
        $qty = 500;
        $not_found =0;
        $product = DB::table('products')
                ->where('id',$product_id)
                ->first();
        $size = $product->model;
        //dd($size);

        if($size == '8x12'){
          $unit_sft = 8*12 / 144;
          $box_pcs = 25;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10.5x12'){
          $unit_sft = 10.5*12 / 144;
          $box_pcs = 19;
          $box_sft = $box_pcs * $unit_sft;
        } 
        else if($size == '10x16'){
          $unit_sft = 10*16 / 144;
          $box_pcs = 10;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10x12'){
          $unit_sft = 10*12 / 144;
          $box_pcs = 19;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x12'){
          $unit_sft = 12*12 / 144;
          $box_pcs = 16;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x20'){
          $unit_sft = 12*20 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x24'){
          $unit_sft = 12*24 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '16x16'){
          $unit_sft = 16*16 / 144;
          $box_pcs = 9;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x24'){
          $unit_sft = 24*24 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x48'){
          $unit_sft = 24*48 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '32x32'){
          $unit_sft = 32*32 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }else{
          $unit_sft = 1;
          $box_pcs = 1;
          $box_sft = $box_pcs * $unit_sft;
          $not_found = 1;
        }

        //dd($qty);

        $number_of_box = $qty/$box_sft;
        $box = floor($number_of_box);    // int
        $box_fraction = $number_of_box - $box; // fraction
        $pcs = floor($box_pcs * $box_fraction); 

        if($not_found == 1){
          echo "-_-";
        }else{
          echo $box.'_'.$pcs;
        } 
        
      }  
      
      public function sftToFreshBoxAndPcs($product_id, $qty){

        $not_found =0;
        $product = DB::table('products')
                ->where('id',$product_id)
                ->first();
        $size = $product->model;
        //dd($size);

        if($size == '8x12'){
          $unit_sft = 8*12 / 144;
          $box_pcs = 25;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10.5x12'){
          $unit_sft = 10.5*12 / 144;
          $box_pcs = 19;
          $box_sft = $box_pcs * $unit_sft;
        } 
        else if($size == '10x16'){
          $unit_sft = 10*16 / 144;
          $box_pcs = 10;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10x12'){
          $unit_sft = 10*12 / 144;
          $box_pcs = 19;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x12'){
          $unit_sft = 12*12 / 144;
          $box_pcs = 16;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x20'){
          $unit_sft = 12*20 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x24'){
          $unit_sft = 12*24 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '16x16'){
          $unit_sft = 16*16 / 144;
          $box_pcs = 9;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x24'){
          $unit_sft = 24*24 / 144;
          $box_pcs = 8;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x48'){
          $unit_sft = 24*48 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '32x32'){
          $unit_sft = 32*32 / 144;
          $box_pcs = 2;
          $box_sft = $box_pcs * $unit_sft;
        }else{
          $unit_sft = 1;
          $box_pcs = 1;
          $box_sft = $box_pcs * $unit_sft;
          $not_found = 1;
        }

        $number_of_box = $qty/$box_sft;
        $box = floor($number_of_box);    // int
        $box_fraction = $number_of_box - $box; // fraction
        $pcs = ceil($box_pcs * $box_fraction); 

        if($not_found == 1){
          return "-_-";
        }else{
          return $box.'_'.$pcs;
        }
        
      } 
      public function sftToAtiBoxAndPcs($product_id, $qty){
        $not_found =0;
        $product = DB::table('products')
                ->where('id',$product_id)
                ->first();
        $size = $product->model;
        //dd($size);

        if($size == '8x12'){
          $unit_sft = 8*12 / 144;
          $box_pcs = 25;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '10x16'){
          $unit_sft = 10*16 / 144;
          $box_pcs = 15;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x12'){
          $unit_sft = 12*12 / 144;
          $box_pcs = 16;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '12x24'){
          $unit_sft = 12*24 / 144;
          $box_pcs = 6;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '24x24'){
          $unit_sft = 24*24 / 144;
          $box_pcs = 4;
          $box_sft = $box_pcs * $unit_sft;
        }
        else if($size == '16x16'){
          $unit_sft = 16*16 / 144;
          $box_pcs = 9;
          $box_sft = $box_pcs * $unit_sft;
        }

        // else if($size == '10.5x12'){
        //   $unit_sft = 10.5*12 / 144;
        //   $box_pcs = 19;
        //   $box_sft = $box_pcs * $unit_sft;
        // } 
        // else if($size == '10x12'){
        //   $unit_sft = 10*12 / 144;
        //   $box_pcs = 19;
        //   $box_sft = $box_pcs * $unit_sft;
        // }
    
        // else if($size == '12x20'){
        //   $unit_sft = 12*20 / 144;
        //   $box_pcs = 8;
        //   $box_sft = $box_pcs * $unit_sft;
        // }               
  
        // else if($size == '24x48'){
        //   $unit_sft = 24*48 / 144;
        //   $box_pcs = 2;
        //   $box_sft = $box_pcs * $unit_sft;
        // }
        // else if($size == '32x32'){
        //   $unit_sft = 32*32 / 144;
        //   $box_pcs = 2;
        //   $box_sft = $box_pcs * $unit_sft;
        // }
        
        else{
          $unit_sft = 1;
          $box_pcs = 1;
          $box_sft = $box_pcs * $unit_sft;
          $not_found = 1;
        }

        $number_of_box = $qty/$box_sft;
        $box = floor($number_of_box);    // int
        $box_fraction = $number_of_box - $box; // fraction
        $pcs = ceil($box_pcs * $box_fraction); 

        if($not_found == 1){
          return "-_-";
        }else{
          return $box.'_'.$pcs;
        }
        
      }

      public static function payment($amount){

        $order = DB::table('orders')
        ->where('client_id', session('client_id'))
        ->orderBy('id', 'DESC')
        ->first();
        $order_id = $order->id;
        $customer_id = $order->customer_id;

        //payment data
      $payment = array();
      $payment['order_id']= $order_id;
      $payment['amount']= $amount;
      $payment['customer_id']= $customer_id;
      $payment['active'] = 'on';

      // if ($request->payment_method == 'Cash') {
      //   $payment['payment_method'] = 'Cash';
      // }
      // if ($request->payment_method == 'Bank') {
      //   $payment['payment_method'] = 'Bank';
      //   $payment['bank_id'] = $request->bank_id;
      // }
      // if ($request->payment_method == 'Check') {
      //   $payment['payment_method'] = 'Check';
      //   $payment['active'] = null;
      // }
      // if ($request->payment_method == 'Due') {
      //   $payment['payment_method'] = 'Due';
      // }

      if ($request->payment_cash != null) {
        $payment['payment_method'] = 'Cash';
        $payment['bank_id'] = $request->bank_id;
      } 
      if ($request->payment_bank != null) {
        $payment['payment_method'] = 'Bank';
        $payment['bank_id'] = $request->bank_id;
      
      }if ($request->payment_mfs != null) {
        $payment['payment_method'] = 'bKash';
        $payment['bank_id'] = $request->bank_id_bkash;
      } 
      
      $payment['client_id'] = session('client_id');
      $payment['created_at'] = date("Y-m-d h:i:s a");        
      $payment_id = DB::table('payments')->insertGetId($payment);
     } 

      public function store(Request $request)
      {      
        $date = $request->date . date(" h:i:s a");
        $total_item = count($request->product_id);
        $total_price = $request->total_price;    
        
        $discount_amount = 0;
        $discount_percentage = 0;
        
        if($request->discount_amount != null){
          $discount_amount = $request->discount_amount;

          $discount = DB::table('coupons')
          ->where('code', $request->coupon_code)
          ->where('active', 'on')
          ->first();
          if($discount != null){
            $discount_type = $discount->discount_type;
            $discount_amount = $request->discount_amount;
            if($discount_type == 'Percentage'){
              $discount_percentage = $discount->discount_amount.'%';
            }else{
              $discount_percentage = $discount->discount_amount.'Tk';
            }
          }else{
            $discount_amount = 0;
            $discount_percentage = 0;
          }

        }else{
          $discount_amount = 0;
          $discount_percentage = 0;
        }

        $net_amount = $request->net_amount;       
        $previous_due = $request->previous_due;
        $total_bill = $request->total_bill;
        $paid_amount = $request->paid_amount;
        $customer_id = $request->customer_id;

         // validation 
        if ($request->customer_id == null) {
          return redirect()->back()->with(session()->flash('alert-danger', 'Please select a customer or create new customer.'));
        }
        if ($total_bill < $paid_amount) {
          return redirect()->back()->with(session()->flash('alert-danger', 'Amount can not be bigger than total bill !'));
        }
        if ($paid_amount < 0) {
          //return redirect()->back()->with(session()->flash('alert-danger', 'Amount can not be less than 0!'));
        }
    
        if ($request->payment_method == 'Bank') {
          if ($request->bank_id == null) {
            return redirect()->back()->with(session()->flash('alert-danger', 'Bank can not be empty!'));
          }
        }
        
        if($customer_id == 'New'){
            $customer = new Customer;
            $customer->title = $request->customer_name;       
            $customer->slug = Str::slug($request->title);
            $customer->mobile = $request->mobile;
            $customer->address = $request->address;
            $customer->customer_type = 'New';
            $customer->active = 'on';
            $customer->client_id = session('client_id');
            $customer->created_by = session('user_id');
            $customer->updated_by = '';
            $customer->save();         
            $customer_id = $customer->id;    
        }else{
          $customer = Customer::find($request->customer_id);
          if($customer->mobile == null or $customer->address == null){
            $customer->mobile = $request->mobile;
            $customer->address = $request->address;
            $customer->save();
          }
        }
        
        if($total_price == 0){
          return redirect()->back()->with(session()->flash('alert-warning', 'Please add a product.'));    
        }

        $total_profit = 0;        
        // profit calculation
        for ($i=0; $i < $total_item; $i++) { 
            if($request->product_id[$i] == null){
              continue; // skip empty product details
            }

            $product = Product::find($request->product_id[$i]);
            $tp = $product->tp;
            if($tp > 0){
              $price = $request->price[$i];
              $profit_unit = $price - $tp;
              $profit = $profit_unit * $request->qty[$i];
              $total_profit = $total_profit + $profit;
            }              
        }
        // end profit calculation
        
        // getting inv_id of last order
        $order = DB::table('orders')
        ->where('client_id', session('client_id'))
        ->orderBy('id', 'DESC')
        ->first();
        if($order){
          $inv_id = $order->inv_id + 1;
        }else{
          $inv_id = 1;
        }          

        //orders table
        $order_data=array();
        $order_data['inv_id']=$inv_id;
        $order_data['customer_id']=$customer_id;
        $order_data['total_item']=$total_item;
        $order_data['sub_total']=$total_price;
        $order_data['tax']=0;
        $order_data['discount_amount']=$discount_amount;
        $order_data['discount_percentage']=$discount_percentage;
        $order_data['total_price']=$total_price - $discount_amount;       
        $order_data['payable_price']=$net_amount;
        $order_data['previous_due']=$previous_due; 
        $order_data['total_bill']=$total_bill;
        $order_data['paid_amount']=$request->paid_amount;
        $order_data['due_amount']=$request->due_amount;
        $order_data['note']=$request->note;
        //dd($request->due_amount);     
        
        if (session('bt') == 'fd') {
          $order_data['profit'] = $total_profit;
        }

        $order_data['payment_id']='';

        if($request->due_amount == 0){
          $order_data['status']='Paid';
        }else{
          $order_data['status']='Due';
        }
        $order_data['invoice_type'] = $request->invoice_type;
        //$order_data['invoice_type'] = $request->invoice_type ? 1 : 0 ?? 0;
        $order_data['client_id'] = session('client_id');
        $order_data['created_by'] = session('user_id');
        
        $order_data['invoice_date'] = $request->date;
        if($request->additional_1 != null) $order_data['additional_1'] = $request->additional_1;
        if($request->additional_2 != null) $order_data['additional_2'] = $request->additional_2;
        $order_data['created_at'] = date("Y-m-d h:i:s a");
        if($request->date != date("Y-m-d")){
          $order_data['created_at'] = $request->date . date(" h:i:s a");
        }
        $order_data['active'] = 'on';
        $order_id = DB::table('orders')->insertGetId($order_data);
        
        // business logic dependency(bld) 
        if($order_id){
          $this->creditCustomerAc($customer_id, $total_price, $order_id);
        }

      if($request->payment_cash != null) {
          //payment data
          $payment = array();
          $payment['order_id']= $order_id;
          $payment['amount']= $request->payment_cash;
          $payment['customer_id']= $customer_id;
          $payment['active'] = 'on';
          $payment['payment_method'] = 'Cash';
          $payment['client_id'] = session('client_id');
          $payment['created_at'] = $request->date . date(" h:i:s a");    
          $payment_id = DB::table('payments')->insertGetId($payment);

      }
      if($request->payment_bank != null) {
         // dd($request->bank_id_general);
         if($request->bank_id_general == null){
            return redirect()->back()->with(session()->flash('alert-warning', 'Bank selection is missing'));    
          }
          $this->debitBankAc($request->bank_id_general, $request->payment_bank, $expense_id = null, $order_id, $date);

          //payment data
          $payment = array();
          $payment['order_id']= $order_id;
          $payment['amount']= $request->payment_bank;
          $payment['customer_id']= $customer_id;
          $payment['active'] = 'on';
          
          $payment['payment_method'] = 'Bank';
          $payment['bank_id'] = $request->bank_id_general;
          
          $payment['client_id'] = session('client_id');
          $payment['created_at'] = $request->date . date(" h:i:s a");    
          $payment_id = DB::table('payments')->insertGetId($payment);
          
      }
      if($request->payment_mfs != null) {
          //dd($request->payment_mfs);
          if($request->bank_id_mfs == null){
            return redirect()->back()->with(session()->flash('alert-warning', 'MFS selection is missing!'));    
          }
          $this->debitBankAc($request->bank_id_mfs, $request->payment_mfs, $expense_id = null, $order_id, $date);
          
          //payment data
          $payment = array();
          $payment['order_id']= $order_id;
          $payment['amount']= $request->payment_mfs;
          $payment['customer_id']= $customer_id;
          $payment['active'] = 'on';

          $payment['payment_method'] = 'MFS';
          $payment['bank_id'] = $request->bank_id_mfs; 
         
          $payment['client_id'] = session('client_id');
          $payment['created_at'] = $request->date . date(" h:i:s a"); 
          //$payment['created_at'] = date("Y-m-d h:i:s a");        
          $payment_id = DB::table('payments')->insertGetId($payment);

      }
      if($request->payment_cash == null && $request->payment_bank == null && $request->payment_mfs == null) {
          //payment data
          $payment = array();
          $payment['order_id']= $order_id;
          $payment['amount']= $request->paid_amount;
          $payment['payment_method'] = 'Cash';
          $payment['customer_id']= $customer_id;
          $payment['active'] = 'on';
          $payment['client_id'] = session('client_id');
          $payment['created_at'] = $request->date . date(" h:i:s a");    
          $payment_id = DB::table('payments')->insertGetId($payment);

      }
        

      if($payment_id){
        $this->debitCustomerAc($customer_id, $request->paid_amount, $payment_id);
      }

       
        
      
    
      //order details table       
      for ($i=0; $i < $total_item; $i++) { 
          if($request->product_id[$i] == null){
            continue;
          }
          // profit calculation
          $product = Product::find($request->product_id[$i]);
          $tp = $product->tp;
          if($tp > 0){
            $price = $request->price[$i];
            $profit_unit = $price - $tp;
            $profit = $profit_unit * $request->qty[$i];
          } 
          // end profit calculation      
          

          $order_details=array();
          $store_id = session('client_id'); 
          $order_details['customer_id'] = $customer_id;
          $order_details['order_id'] = $order_id;
          $order_details['product_id'] = $request->product_id[$i];
          if(isset($request->product_sn[$i])){
            $order_details['product_sn'] = $request->product_sn[$i];
          }
          $order_details['qty'] = $request->qty[$i];

          $product = Product::find($request->product_id[$i]);
          //dd($product->brand);

          if($product->brand != null ){
            if($product->brand == 'Akij Ceramics'){
              $order_details['qty_box_pcs'] = $this->sftToAkijBoxAndPcs($request->product_id[$i], $request->qty[$i]);
            }
            if($product->brand == 'Fresh Ceramics' or $product->brand == 'Sheltech Ceramics'){
              $order_details['qty_box_pcs'] = $this->sftToFreshBoxAndPcs($request->product_id[$i], $request->qty[$i]);
            }
            //dd('none');
          }

          if ($request->product_id[$i] == 1) {
            $product_type = 'Advance';
          }
          elseif ($request->product_id[$i] == 2) {
            $product_type = 'Due';
          }else{
            $product_type = 'Product';
          }    
          $order_details['product_type'] = $product_type;
          $order_details['price'] = $request->price[$i];
          $order_details['sub_total'] = $request->price[$i]*$request->qty[$i];             
          $order_details['tax'] = 0; 
          $order_details['client_id'] = session('client_id'); 
          $order_details['active'] = 'on'; 
          $order_details['total_price'] = $order_details['sub_total'] + $order_details['tax'];
      
          if ($tp > 0) {
            $order_details['tp'] = $tp;
            $order_details['profit_unit'] = $profit_unit;
            $order_details['profit'] = $profit;
          }         

          $order_details['created_at'] = date("Y-m-d h:i:s a");
          if($request->date != date("Y-m-d")){
            $order_details['created_at'] = $request->date . date(" h:i:s a");
          }

          DB::table('order_details')->insert($order_details); 
          
          if ($request->product_id[$i]>0) {
            $this->creditProductStock($request->product_id[$i], $store_id, $request->qty[$i], $order_id);
          }
          //$this->updateProductStockStatus($request->product_id[$i], $request->product_sn[$i]);
      }

       // business logic dependency(bld) 
      // if ($order_id && $product_type != 'Advance' && $product_type != 'Due') {}

      if ($order_id) {
        $this->creditCustomerAc($customer_id, $total_price, $order_id);
      }

      
      return redirect('invoice-preview/' . $order_id);
     
        //return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id){       
          $orderData = DB::table('orders')
          ->where('id',$id)
          ->first();

          $edit_order=view('admin.invoice_edit')
          ->with('order',$orderData);

          return view('admin.master')
          ->with('main_content', $edit_order);
      }

      public function update(Request $request)
      {
        $order_id = $request->order_id;
        $data = Order::find($request->order_id);
        $past_due = $data->due_amount;
        $past_paid = $data->paid_amount;
        $paid_amount = $request->paid_amount;

        // validation 
        if($past_due < $paid_amount){
          //return redirect()->back()->with(session()->flash('alert-danger', 'Amount can not be bigger than due!'));
        }
        if($paid_amount < 0){
          return redirect()->back()->with(session()->flash('alert-danger', 'Amount can not be less than 0!'));
        }
        
        //payment data     
        if($past_due > 0 && $paid_amount > 0){
          $payment=array();
          $payment['order_id']=$request->order_id;
          $payment['customer_id']=$request->customer_id;
          $payment['amount']=$request->paid_amount;
          $payment['active'] = 'on';
          
          if($request->payment_method == 'Cash'){
            $payment['payment_method']='Cash';
          } 
          if($request->payment_method == 'Bank'){
            $payment['payment_method']='Bank';
            $payment['bank_id']=$request->bank_id;
          } 
          if($request->payment_method == 'Due'){
            $payment['payment_method']='Due';
          }
          $payment['created_at'] = date("Y-m-d h:i:s a");
          $payment['client_id'] = session('client_id');
          $payment['created_by'] = session('user_id');      
          DB::table('payments')->insert($payment); 
        }   
        
      //return details  
      $total_item = count($request->product_id);  
      $total_return_qty = 0;  
      $total_return_profit = 0;  
      $total_return_total_price = 0;  

      for ($i=0; $i < $total_item; $i++) { 
        if($request->return_qty[$i] == null){
          continue; // skip those who has no return
        }
        // profit calculation
        $product = Product::find($request->product_id[$i]);
        $tp = $product->tp;
        $profit = 0;
        if($tp > 0){
          $price = $request->price[$i];
          $profit_unit = $price - $tp;
          $profit = $profit_unit * $request->return_qty[$i];
        } 
        // end profit calculation      
        

        $return_details=array();
        $store_id = session('client_id'); 
        $return_details['customer_id'] = $request->customer_id;
        $return_details['order_id'] = $request->order_id;
        $return_details['product_id'] = $request->product_id[$i];
        if(isset($request->product_sn[$i])){
          $return_details['product_sn'] = $request->product_sn[$i];
        }
        $return_details['qty'] = -$request->return_qty[$i];

        $product = Product::find($request->product_id[$i]);
        if($product->brand != null ){
          if($product->brand == 'Akij Ceramics'){
            $return_details['qty_box_pcs'] = $this->sftToAkijBoxAndPcs($request->product_id[$i], $request->qty[$i]);
          }
          if($product->brand == 'Fresh Ceramics' or $product->brand == 'Sheltech Ceramics'){
            $return_details['qty_box_pcs'] = $this->sftToFreshBoxAndPcs($request->product_id[$i], $request->qty[$i]);
          }
          //dd('none');
        }

        if ($request->product_id[$i] == 1) {
          $product_type = 'Advance';
        }
        elseif ($request->product_id[$i] == 2) {
          $product_type = 'Due';
        }else{
          $product_type = 'Product';
        }    
        $return_details['product_type'] = $product_type;
        $return_details['price'] = $request->price[$i];
        $return_details['sub_total'] = $request->price[$i]*$request->return_qty[$i];             
        $return_details['tax'] = 0; 
        $return_details['client_id'] = session('client_id'); 
        $return_details['active'] = 'on'; 
        $return_details['total_price'] = $return_details['sub_total'] + $return_details['tax'];
    
        if ($tp > 0) {
          $return_details['tp'] = $tp;
          $return_details['profit_unit'] = $profit_unit;
          $return_details['profit'] = -$profit;
        }         

        $return_details['created_at'] = date("Y-m-d h:i:s a");
        // if($request->date != date("Y-m-d")){
        //   $return_details['created_at'] = $request->date . date(" h:i:s a");
        // }
        $total_return_profit = $total_return_profit + $profit;
        $total_return_qty = $total_return_qty + $request->return_qty[$i];
        $total_return_total_price = $total_return_total_price + $return_details['total_price'];

        DB::table('order_details')->insert($return_details); 
        
        if ($request->product_id[$i]>0) {
          $this->debitProductStock($request->product_id[$i], $store_id, $request->return_qty[$i], $order_id);
        }
        
        
      }
      //dd($total_return_profit);
      //dd($total_return_qty);
      //dd($total_return_total_price);

        
        // order update
        if($past_due != 0){
          $data->paid_amount = $past_paid + $paid_amount;
          $data->due_amount = $data->total_price - $data->paid_amount;          
          if($data->due_amount == 0){
            $data['status']='Paid';
          }else{
            $data['status']='Due';
          }
        }
       
        $data['note'] = $request->note;
        //order update for return
        $data['total_price'] = $data->total_price - $total_return_total_price;
        $data['payable_price'] = $data->payable_price - $total_return_total_price;
        $data['total_bill'] = $data->total_bill - $total_return_total_price;
        $data['profit'] = $data->profit - $total_return_profit;
        $data['total_item'] = $data->total_item - $total_return_qty;

        $data['note'] = $request->note;
        $data['updated_at'] = date("Y-m-d h:i:s a");
        $data['updated_by'] = session('user_id');
        $data->save();              
        return redirect('invoice-preview/' . $order_id); 

        //return redirect('/invoices')->with(session()->flash('alert-success', 'Data has been updated successfully.'));
      }


      public function destroy($id)
      {
        //check same day or not.
        //if same day then case one
        //if not case another
        //order details table     
        $store_id = session('client_id');
        $od = DB::table('order_details')
         ->where('order_id', $id)
         ->get();
        foreach($od as $item){ 
          $product_id = $item->product_id;
          $qty= $item->qty;
          $order_id = $id;
          $this->returnProductStock($product_id, $store_id, $qty, $order_id);  
          
          //order details delete
          $data['active'] = 'deleted';
          DB::table('order_details')
            ->where('id', $item->id)
            ->update($data);
        }

        //soft delete of order
        $data['active'] = 'deleted';
        DB::table('orders')
          ->where('id', $id)
          ->update($data);

        //soft delete of payment
        DB::table('payments')
          ->where('order_id', $id)
          ->update($data);

        //r&d
        // need to show in expense if day goes different.
        // if return partially then what will be the way???       

        return redirect()->back()->with(session()->flash('alert-success', 'Invoice has been deleted successfully.'));
      }

      public function invoice($id)
      {  
        $order = DB::table('orders')
        ->where('id', $id)
        ->where('client_id', session('client_id'))
        ->first();
        if($order == null){
          return redirect()->back()->with(session()->flash('alert-warning', 'Nothing Found!'));
        }

        //dd($order->customer_id);
        $customer = DB::table('customers')
            ->where('id', $order->customer_id)
            ->first();       

        $products = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name as product_name')
                ->where('order_id',$id)
                ->get();    

        if (session('bt') == 'c') {
          if($order->invoice_type != 'on'){
            return view('admin.invoice_pos', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);    
          }
        }
        if (session('lang') == 'bn') {
          return view('admin.invoice_preview_bn', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);     
        }else{
          return view('admin.invoice_preview', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);     
        }

             
      } 
      
      public function invoicePos($id)
      {  
        $order = DB::table('orders')
        ->where('id',$id)
        ->where('client_id', session('client_id'))
        ->first();
        if($order == null){
          return redirect()->back()->with(session()->flash('alert-warning', 'Nothing Found!'));
        } 

        $customer = DB::table('customers')
            ->where('id',$order->customer_id)
            ->first();       

        $products = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name as product_name')
                ->where('order_id',$id)
                ->get();     

        if (session('bt') == 'c') {
          return view('admin.invoice_pos', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);    
        }
        else{
          return view('admin.invoice_preview', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);    
        }
             
      } 
      
      public function deliveryOrder($id)
      {  
        $order = DB::table('orders')
        ->where('id',$id)
        ->first();

        $customer = DB::table('customers')
            ->where('id',$order->customer_id)
            ->first();       

        $products = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name as product_name')
                ->where('order_id',$id)
                ->get();    

                
          return view('admin.delivery_order', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);   
             
      }
     

      public function pdf($id)
      {  
        $order = DB::table('orders')
        ->where('id',$id)
        ->first();

        $customer = DB::table('customers')
            ->where('id',$order->customer_id)
            ->first();       

        $products = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('order_details.*', 'products.name as product_name')
            ->where('order_id',$id)
            ->get();     

          //return view('pdf.invoice', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);
          $pdf = PDF::loadView('pdf.invoice', ['order' => $order, 'products' => $products, 'customer' => $customer, 'invoice_id'=>$id ]);
  
          return $pdf->download('invoice_'.$id.'.pdf');
  
      }

     

}