<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BankCheck;
use App\Models\CustomerAccount;
use App\Models\Payment;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class BankCheckController extends Controller
{
    use DebitCreditTrait;
    
    function make_slug($string) {
        return preg_replace('/\s+/u', '-', trim($string));
    }  

    public function index()
    {
        $data = BankCheck::orderBy('id', 'desc')->where('active', 'on')->get();
        return view('admin.bank_check', ['data'=>$data]);
    }     
    
    
    public function store(Request $request)
    {
       
        //if(ProductCategory::where('name', $request->name)->where('parent_id', $request->parent_id)->get())
        if(BankCheck::where('name', $request->name)->first())
        {
            return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        }

        $data = new BankCheck;
        $data->name = $request->name;
        $data->check_no = $request->check_no;
        $data->bank_id = $request->bank_id;
        $data->amount = $request->amount;
        $data->customer_id = $request->customer_id;
        $data->invoice_id = $request->invoice_id;
        $data->note = $request->note;
        $data->status = 'Pending';
        $data->active = 'on';
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        }

        $data['created_by'] = session('user_id');
        $data['created_at'] = date("Y-m-d h:i:s a");
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));        
    } 

    public function update(Request $request)    {        
        
        // if(ProductCategory::where('name', $request->name)->first())
        // {
        //     return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        // }
        
        $data = BankCheck::find($request->id);
        $data->name = $request->name;
        $data->check_no = $request->check_no;
        $data->bank_id = $request->bank_id;
        $data->amount = $request->amount;
        $data->customer_id = $request->customer_id;
        $data->invoice_id = $request->invoice_id;
        $check_status = $data->status;
        $data->note = $data->note;

        // no option yet, we are not accepting without invoice id, but in future it can be used... 
        if($request->invoice_id == null){
            $this->customerDivAccount($data->customer_id, $request->amount, $invoiceId = 0);
        }

        // it will not happen now as withdraw completed chck can not be updated
        if($check_status == 'Withdraw Completed' && $request->status != 'Withdraw Completed'){
            $this->removePayment($check_status, $request);
        }

        if($request->status =='Withdraw Completed' && $check_status != 'Withdraw Completed'){
            $this->addToPayment($check_status, $request);
        }
        
        $data->status = $request->status;
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        }else{
            $data->image = $request->hidden_image;
        }
        
        $data->save(); 

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    private function addToPayment($check_status, $request){
        //payment data  
        $payment=array();
        $payment['order_id'] = $request->invoice_id;
        $payment['amount']=$request->amount;
        $payment['bank_id']=$request->bank_id;
        $payment['check_id']=$request->id;
        $payment['payment_method']='Check';
        $payment['updated_by']=session('user_id');
        $payment['active']= 'on';
        // need to modify
        $payment['created_by'] = session('user_id');
        $payment['created_at'] = date("Y-m-d h:i:s a");
        $payment_id = DB::table('payments')->insertGetId($payment); 

        $this->debitCustomerAc($request->customer_id, $request->amount, $payment_id);  
    }
    
    private function removePayment($check_status, $request){
         //check if payment exist, remove that entry from payments table
            // but if date of payment table entry changes, then disable this features
            $payment_id = $request->id;
            $payment = DB::table('payments')
                ->where('check_id', $payment_id) 
                ->first();
        
            $withdraw_date = explode(" ", $payment->created_at);
            $today = date("Y-m-d");
            if(strcmp($withdraw_date[0], $today)==0){
                // remove payment data
                $payment = Payment::find($payment->id);
                $payment->delete();

                $this->creditCustomerAc($request->customer_id, $request->amount, $payment_id);  

            }else{
                return redirect()->back()->with(session()->flash('alert-danger', 'Check has been added to cash sheet. You can not change check status as one day has been passed when you marked that as "withdraw completed".'));
            }

       
    }
   

    public function destroy($id)
    {   
        //delete
        // $data = BankCheck::find($id);
        // $data->delete();
        return redirect()->back()->with(session()->flash('alert-warning', 'Check can not be deleted. Just chage the status'));
    }
  
}
