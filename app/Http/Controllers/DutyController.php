<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Employee;
use App\Traits\DebitCreditTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class DutyController extends Controller
{
  use DebitCreditTrait;  
    public function index()
    {
        $data = Duty::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
        return view('admin.duties', ['data'=>$data]);        
    }    
    public function show($slug)
    {
        $fetch = DB::table('duties')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('duties')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('duty_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  
   
      /*============================
       duties
       ============================*/
    public function duties()
    {     
      $data = Duty::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
      return view('admin.duties', ['data'=>$data]);
    } 

      public function create()
      {        
          return view('admin.duty_add');
      }
     

      public function store(Request $request)
      {         
        //dd($request->customer_id);
        $total_item = count($request->particular);
        $total_payment = $request->total_payment;
        $equipement_id = $request->equipement_id;
        $equipement = DB::table('products')
                ->where('id', $equipement_id)
                ->first();

        $customer_id = $request->customer_id;
        $employee_id = $request->employee_id;

        if($customer_id == 'New'){
            $customer = new Customer;
            $customer->title = $request->customer_name;       
            $customer->slug = Str::slug($request->title);
            $customer->mobile = $request->customer_mobile;       
            $customer->address = $request->customer_address;  
            $customer->customer_type = 'Indivisual';
            $customer->active = 'on';
            $customer->client_id = session('client_id');
            $customer->created_by = session('user_id');
            $customer->updated_by = '';
            $customer->save();         
            $customer_id = $customer->id;    
        }else{}

        if($employee_id == 'New'){
          $employee = new Employee;
          $employee->title = $request->employee_name;       
          $employee->slug = Str::slug($request->title);
          $employee->mobile = $request->employee_mobile;
          $employee->address = $request->employee_address;
          $employee->designation = 'Driver';
          $employee->active = 'on';
          $employee->client_id = session('client_id');
          $employee->created_by = session('user_id');
          $employee->updated_by = '';
          $employee->save();         
          $employee_id = $employee->id;    
        }else{}

        $total_payment = $request->payment_receive + $request->fuel_qty * $request->fuel_rate;
        $bill = $request->total_hours * $request->rate;

        $data = new Duty;
        $data->equipement_id = $request->equipement_id;       
        $data->customer_id = $customer_id;
        $data->employee_id = $employee_id;
        $data->date = $request->date;

        $data->start_reading = $request->start_reading;
        $data->stop_reading = $request->stop_reading;
        $data->total_hours = $request->total_hours;
        $data->rate = $request->rate;
        $data->bill = $bill;
        $data->tracking_hours = $request->tracking_hours;

        $data->payment_receive = $request->payment_receive;
        $data->fuel_type = $request->fuel_type;
        $data->fuel_qty = $request->fuel_qty;
        $data->fuel_rate = $request->fuel_rate;
        $data->fuel_cost = $request->fuel_qty * $request->fuel_rate;
        $data->total_payment = $total_payment;
        $data->total_expense = $request->total_price;
        $data->notes = $request->notes;
        $data->date= $request->date;

        $data->active = 'on';
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();
        $duty_id = $data->id;

        //dd($total_item);

        //duty details/ expense entry 
        if ($request->total_price > 0) {
            for ($i=0; $i < $total_item; $i++) { 
                if($request->expense_type[$i] == null){
                  //return redirect()->back()->with(session()->flash('alert-warning', 'Expense type can not be empty!'));    
                }
                $ed = array();
                $ed['duty_id'] = $duty_id;
                $ed['equipement_id'] = $equipement_id;
                if ($request->particular[$i] != null) {
                  $ed['title'] = $equipement->name.': '.$request->particular[$i];
                }else{
                  $ed['title'] = $equipement->name.': '. $request->expense_type[$i];
                  //$ed['title'] = $request->expense_type[$i];
                }   
                $ed['payment_method'] = 'Due';
                $ed['expense_type'] = 'Ex Expenses';
                $ed['expense_type_sub'] = $request->expense_type[$i];
                $ed['qty'] = $request->qty[$i];
                $ed['price'] = $request->price[$i];
                $ed['amount'] = $request->price[$i] * $request->qty[$i];
                $ed['date'] = $request->date;

                $ed['client_id'] = session('client_id');
                $ed['active'] = 'on';
                $ed['expensed_by'] = session('user_id');    
                $ed['created_at'] = date("Y-m-d h:i:s a");     
                DB::table('expenses')->insert($ed); 
            }        
        }

      

        // create invoice or order_id if new duty in a new month
        $duty_exist = Duty::orderBy('id', 'desc')
                ->where('equipement_id', $equipement_id)
                ->where('customer_id', $customer_id)
                ->get();
        //dd($duty_exist);
                // ** month is missing here. need to add
        $duty_count = $duty_exist->count();
        //dd($duty_count);
        if($duty_count == 1 && $duty_count !=0){
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
            $order_data['total_item']=1;
            $order_data['sub_total']=$total_payment;
            $order_data['discount_amount']=0;
            $order_data['total_price']=$total_payment;       
            $order_data['payable_price']=$bill;
            $order_data['total_bill']=$bill;
            $order_data['paid_amount']=$total_payment;
            $order_data['due_amount']=0;
            $order_data['note']='Contact started.';
            //dd($request->due_amount); 
            $order_data['status']='Due';
            $order_data['invoice_type'] = 'Advance';
            $order_data['client_id'] = session('client_id');
            $order_data['created_by'] = session('user_id');
            $order_data['invoice_date'] = $request->date;
            $order_data['created_at'] = date("Y-m-d h:i:s a");
            if($request->date != date("Y-m-d")){
              $order_data['created_at'] = $request->date . date(" h:i:s a");
            }
            $order_data['active'] = 'on';
            $order_id = DB::table('orders')->insertGetId($order_data);
            
            // business logic dependency(bld) 
            if($order_id){
              $this->creditCustomerAc($customer_id, $total_payment, $order_id);
            } 
          } 
          // get order id if not first duty
          else{
            //dd($customer_id);

            $order = DB::table('orders')
                ->where('customer_id', $customer_id)
                ->orderBy('id', 'DESC')
                ->first();
            //dd($order);
            if($order != null){
              $order_id = $order->id;
            }
          }
          // end order_id create

        //payment data
        $payment=array();
        $payment['order_id']=$order_id;
        $payment['amount']=$request->payment_receive;
        $payment['customer_id']=$customer_id;
        $payment['active'] = 'on';
        $payment['payment_method'] = 'Cash';
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
        $payment['client_id'] = session('client_id');
        $payment['created_at'] = date("Y-m-d h:i:s a");        
        $payment_id = DB::table('payments')->insertGetId($payment); 

        if($payment_id){
          $this->debitCustomerAc($customer_id, $request->paid_amount, $payment_id);
        }
        
    
          //order details table       
          $order_details = array();
          $store_id = session('client_id'); 
          $order_details['customer_id'] = $customer_id;
          $order_details['order_id'] = $order_id;
          $order_details['product_id'] = $equipement_id;
          $order_details['qty'] = $request->total_hours;
          $order_details['product_type'] = 'Service';
          $order_details['price'] = $request->rate;
          $order_details['sub_total'] = $request->total_hour * $request->rate;             
          $order_details['tax'] = 0; 
          $order_details['client_id'] = session('client_id'); 
          $order_details['active'] = 'on'; 
          $order_details['total_price'] = $bill;
          $order_details['created_at'] = date("Y-m-d h:i:s a");
          if($request->date != date("Y-m-d")){
            $order_details['created_at'] = $request->date . date(" h:i:s a");
          }
          DB::table('order_details')->insert($order_details); 
       
        // end invoice creation
        
        return redirect('edit-duty/'.$duty_id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));   

      } 
      
      public function stockAdmustment(Request $request)
      {
        $store_id = session('client_id');
        if($request->type == 'Debit'){
          $duty_id = 'Plus';
          $this->debitProductStock($request->product_id, $store_id, $request->qty, $duty_id);
        }
        if($request->type == 'Credit'){
          $invoice_id = 'Minus';
          $this->creditProductStock($request->product_id, $store_id, $request->qty, $invoice_id);
        }
        return redirect()->back()->with(session()->flash('alert-success', 'Stock adjusted successfully.'));   
        
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

   
      public function edit($id){       
        $data = Duty::find($id);      
        if(session('bt') == 'd' || session('bt') == 'b'){
          return view('admin.duty_edit4', ['data'=>$data]);
        }
        elseif(session('bt') == 'p'){
          return view('admin.duty_edit_p', ['data'=>$data]);
        }
        else{
          return view('admin.duty_edit', ['data'=>$data]);
        }

      }

    public function update(Request $request)
    {       
        $duty_id = $request->id;  
        $total_item = count($request->product_id);
        $total_payment = $request->total_payment;
        $transport_cost = $request->transport_cost;
        $transport_cost_percent = $transport_cost/$total_payment*100;

        $total_qty = 0;
        for ($i=0; $i < $total_item; $i++) {          
          $total_qty = $total_qty + $request->qty[$i];
        }

                
  
          
        //return "Under Construction";
        $data = Duty::find($duty_id);
        $data->equipement_id = $request->equipement_id;
        $data->customer_id = $request->customer_id;
        $data->employee_id = $request->operator;
        $data->total_item = $total_item;
        $data->total_qty = $total_qty;
        $data->transport_cost = $transport_cost;
        $data->rate = $rate;
        $data->total_payment = $request->total_payment;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        $data->dealer_name = $request->dealer_name;
        $data->dealer_address = $request->dealer_address;

        //dd($request->total_payment);
        $store_id = session('client_id');
         
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        }else{
            $data->image = $request->hidden_image;
        }
        $data->active = $request->active;
        $data->updated_by = session('user_id');
        $data->save(); 


        //credit past records before duty details delete
        $old_duty =  DB::table('duty_details')
            ->where('duty_id', $request->id)
            ->get(); 
        foreach($old_duty as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('duty_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        //insert duty details newly        
        for ($i=0; $i < $total_item; $i++) { 

          if($transport_cost != null){            
            $courier_pu =  $request->price[$i] * $transport_cost_percent / 100;
            $price_c = $request->price[$i] + $courier_pu;
            $total_payment_c = $request->price[$i] * $request->qty[$i] + $transport_cost;             
          }else{
            $courier_pu = null;
            $price_c = $request->price[$i];
            $total_payment_c = $request->price[$i] * $request->qty[$i];
          }

          $store_id = session('client_id');
          $pd=array();
          $pd['duty_id'] = $duty_id;
          $pd['product_id'] = $request->product_id[$i];
          $pd['qty'] = $request->qty[$i];
          $pd['price'] = $request->price[$i];
          $pd['total_payment'] = $request->price[$i] * $request->qty[$i];
                    
          $pd['courier_pu'] = round($courier_pu, 2); 
          $pd['price_c'] = round($price_c, 2); 
          $pd['total_payment_c'] = round($total_payment_c, 2); 
          //$pd['product_sn'] = $request->product_sn[$i];  /// rabbi
          DB::table('duty_details')->insert($pd); 

          $this->debitProductStock($request->product_id[$i], $store_id, $request->qty[$i], $duty_id);

        } 
       

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function find_equipement_rate(Request $request){
        $product = DB::table('products')
            ->where('id', $request->equipement_id)
            ->first();

        $duty = DB::table('duties')
            ->where('equipement_id', $request->equipement_id)
            ->where('client_id', session('client_id'))
            ->orderBy('id', 'desc')
            ->first();

        $customer = DB::table('customers')
            ->where('id', $duty->customer_id)
            ->first();
        
        $employee = DB::table('employees')
            ->where('id', $duty->employee_id)
            ->first();

        return response()->json(['success'=>true,'rate'=>$product->price, 'customer_id'=>$duty->customer_id, 'customer_name'=>$customer->title, 'employee_id'=>$duty->employee_id, 'employee_name'=>$employee->title]);
    }

    public function destroy($id)
    {
      $store_id = session('client_id');
       //credit past records before duty details delete
       $old_duty =  DB::table('duty_details')
            ->where('duty_id', $id)
            ->get(); 
        foreach($old_duty as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('duty_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        DB::table('duties')
        ->where('id',$id)
        ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Duty has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
