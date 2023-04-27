<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\CashFlow;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
 
class CashFlowController extends Controller
{
    use DebitCreditTrait;
    
    public function index()
    { 
        $data = CashFlow::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
        return view('admin.cashflows', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('expenses')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('expenses')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('Expense_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  

   
      /*============================
       Expenses
       ============================*/
    public function expenses()
    {     
      $data = Expense::orderBy('id', 'desc')->get();
      return view('admin.expenses', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.cashflow_add');
      }

      public function store(Request $request)
      {        
        $data = new CashFlow;
        $data->title = $request->title;       
        $data->cashflow_type = $request->cashflow_type;
        $data->received_by = $request->received_by;
        $data->payment_method = $request->payment_method;
        
        
        if($request->cashflow_type == 'Bank Withdraw'){
          if($request->bank_id == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Bank account selection is must for bank withdraw!'));
          }
          $data->bank_id = $request->bank_id;
          $data->payment_method = 'Cash';
        }
 

        if($request->cashflow_type == 'Company Expense Bill'){
          if($request->company_id == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Company selection is must for company expense bill!'));
          }
          $data->company_id = $request->company_id;
        }


        if($request->cashflow_type == 'Investment'){
          if($request->investor_id == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Investor selection is must for Investment!'));
          }
          $data->investor_id = $request->investor_id;
        }
        
        if($request->payment_method == 'Bank'){
          if($request->bank_id_pm == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Bank account selection is must for bank payment!'));
          }
          $data->bank_id = $request->bank_id_pm;
          $data->payment_method = 'Bank';
        }
        if($request->payment_method == 'MFS'){
          if($request->bank_id_mfs == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'MFS account selection is must for MFS payment!'));
          }
          $data->bank_id = $request->bank_id_mfs;
          $data->payment_method = 'MFS';
        }
        $amount = $request->amount;

        $cf = DB::table('cash_flows')
          ->orderBy('id', 'DESC')
          ->first();
        if($cf){
            $current_balance = $cf->current_balance + $amount;  
        }else{
            $current_balance = $amount;
        } 

        $data->type = 'Debit';  
        $data->amount_in = $amount;
        $data->current_balance = $current_balance;
              
        $data->reference = $request->reference;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        
        $data->created_by = session('user.id');
        $data->client_id = session('client_id');
        $data->save();
        $cashflow_id = $data->id;

        if($cashflow_id && $request->cashflow_type == 'Bank Withdraw'){
          $this->creditBankAc($request->bank_id, $request->amount, $cashflow_id, $expense_id = null);
        }
        if($cashflow_id && $request->payment_method == 'Bank'){
          $this->debitBankAc($request->bank_id_pm, $request->amount, $expense_id=null, $invoice_id=null, $cashflow_id); 
        }
        if($cashflow_id && $request->payment_method == 'MFS'){
          $this->debitBankAc($request->bank_id_mfs, $request->amount, $expense_id=null, $invoice_id=null, $cashflow_id); 
        }
        //dd($cashflow_id);
        if($cashflow_id && $request->cashflow_type == 'Investment'){
          //dd('test');
          $this->debitCustomerAc($request->investor_id, $request->amount, $cashflow_id);   
        }
        //dd('no');

       return redirect('add-cashflow')->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)      {
        $data = CashFlow::find($id);      
        return view('admin.cashflow_edit', ['data'=>$data]);
      }

      public function update(Request $request) 
      {       
          //return "Under Construction";
          $data = CashFlow::find($request->id);
          $data->title = $request->title;       
          //$data->cashflow_type = $request->cashflow_type;
          $data->received_by = $request->received_by;
          //$data->payment_method = $request->payment_method;

          if($request->cashflow_type == 'Bank Withdraw'){
            if($request->bank_id == null){
              return redirect()->back()->with(session()->flash('alert-danger', 'Bank account selection is must for bank withdraw!'));
            }
            $data->bank_id = $request->bank_id;
            $data->payment_method = 'Cash';
          }
   
          if($request->cashflow_type == 'Company Expense Bill'){
            if($request->company_id == null){
              return redirect()->back()->with(session()->flash('alert-danger', 'Company selection is must for company expense bill!'));
            }
            $data->company_id = $request->company_id;
          }
  
          if($request->cashflow_type == 'Investment'){
            if($request->investor_id == null){
              return redirect()->back()->with(session()->flash('alert-danger', 'Investor selection is must for Investment!'));
            }
            $data->investor_id = $request->investor_id;
          }
          
          if($request->payment_method == 'Bank'){
            //dd($request->bank_id_pm);
            if($request->bank_id_pm == null){
              return redirect()->back()->with(session()->flash('alert-danger', 'Bank account selection is must for bank payment!'));
            }
            $data->bank_id = $request->bank_id_pm;
            $data->payment_method = 'Bank';
          }
          $amount = $request->amount;
  
          $cf = DB::table('cash_flows')
            ->orderBy('id', 'DESC')
            ->first();
          if($cf){
              $current_balance = $cf->current_balance + $amount;  
          }else{
              $current_balance = $amount;
          } 
  
          $data->type = 'Debit';  
          //$data->amount_in = $amount;
          //$data->current_balance = $current_balance;
                
          $data->reference = $request->reference;
          $data->date = $request->date;
          $data->description = $request->description;
          $data->notes = $request->notes;
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;          
          $data->updated_by = session('user.id');
          $data->save();
          $cashflow_id = $data->id;
  
          if($cashflow_id && $request->cashflow_type == 'Bank Withdraw'){
            //$this->creditBankAc($request->bank_id, $request->amount, $cashflow_id);
          }
          if($cashflow_id && $request->payment_method == 'Bank'){
            //$this->debitBankAc($request->bank_id_pm, $request->amount, $expense_id=null, $invoice_id=null, $cashflow_id); 
          }

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {

          $cashflow = CashFlow::find($id);         

          if($cashflow->cashflow_type == 'Bank Withdraw'){
            //return redirect()->back()->with(session()->flash('alert-warning', 'Under construction yet. Pls wait'));
           
          }    
   
          elseif($cashflow->cashflow_type == 'Company Expense Bill'){
            //return redirect()->back()->with(session()->flash('alert-warning', 'Under construction yet. Pls wait'));
            
          }
  
          elseif($cashflow->cashflow_type == 'Investment'){
            return redirect()->back()->with(session()->flash('alert-warning', 'Under construction yet. Pls wait'));  
           
             
          }
          else{
            DB::table('cash_flows')
            ->where('id',$id)
            ->delete();
      
            return redirect()->back()->with(session()->flash('alert-success', 'Cash reveive has been deleted successfully.'));
          }
          
          


     
    }

    /*============================
     reports
       ============================*/

 

     

}
