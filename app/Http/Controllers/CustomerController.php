<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
        return view('admin.customers', ['data'=>$data]);        
    }

       
      /*============================
       Customers
       ============================*/
    public function Customers()
    {     
      $data = Customer::orderBy('id', 'desc')->get();
      return view('admin.customers', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.customer_add');
      }

      public function store(Request $request)
      {        
        $data = new Customer;
        $data->title = $request->title;       
        $data->proprietor = $request->proprietor;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->type = $request->type;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->address = $request->address;
        $data->link_title = $request->link_title;
        $data->link_action = $request->link_action;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->client_id = session('client_id');
        $data->updated_by = '';
        $data->save();  
        $data->id;

        return redirect('customer-details/'.$data->id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id){
        $data = Customer::find($id);      
        return view('admin.customer_edit', ['data'=>$data]);
      }

      public function show($id){
        $data = Customer::find($id);      
        return view('admin.customer_details', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = Customer::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;
          $data->mobile = $request->mobile;
          $data->email = $request->email;
          $data->type = $request->type;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->address = $request->address;
          $data->link_title = $request->link_title;
          $data->link_action = $request->link_action;
          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('customers')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Customer has been deleted successfully.'));
    }

    public function storeOB(Request $request)
    { 
      if(!is_numeric($request->amount)) {
        return redirect()->back()->with(session()->flash('alert-warning', 'Opening balance should be a number!')); 
      }
       
      $ob = DB::table('customer_accounts')
      ->where('customer_id', $request->customer_id)
      ->where('type', 'OB')
      ->orderBy('id', 'desc')
      ->first();

      $amount = $request->amount;

      if($ob != null){
        $ob_id = $ob->id;
        $ob = CustomerAccount::find($ob_id);      
        $ob['customer_id'] = $request->customer_id;
        if($amount>0){
          $ob['amount_in'] = $amount;
          $ob['amount_out'] = 0;
        }else{
          $ob['amount_in'] = 0;
          $ob['amount_out'] = $amount;
        }
        $ob['current_balance'] = $amount;
        $ob->save();
      }
      else{
        $data = new CustomerAccount;
        $data->customer_id = $request->customer_id;       
        $data->type = 'OB';  
        if($amount>0){
          $data['amount_in'] = $amount;
          $data['amount_out'] = 0;
        }else{
          $data['amount_in'] = 0;
          $data['amount_out'] = $amount;
        }
        $data->current_balance = $amount;
    
        $data->created_by = session('user.id');
        $data->save();
      }   
      return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

    }

    /*============================
       End News Post
       ============================*/

     

}
