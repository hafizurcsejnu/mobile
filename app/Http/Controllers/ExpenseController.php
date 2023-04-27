<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class ExpenseController extends Controller
{
    use DebitCreditTrait;
    
    public function index()
    {
        $data = Expense::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
        return view('admin.expenses', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('expenses')
                ->where('client_id', session('client_id'))
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
      $data = Expense::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
      return view('admin.expenses', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.expense_add');
      }

      public function store(Request $request)
      {        
        if (!is_numeric($request->amount)) {
          return redirect()->back()->with(session()->flash('alert-warning', 'Amount should be a number!'));
        } 
        $data = new Expense;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        $data->expense_type = $request->expense_type;
        $data->expensed_by = $request->expensed_by;
        $data->payment_method = $request->payment_method;
        $data->product_id = $request->product_id;
        $data->company_id = $request->company_id;
        $data->purchase_id = $request->purchase_id;
        $data->equipement_id = $request->equipement_id;
        $data->amount = $request->amount;
        $data->boucher_no = $request->boucher_no; 
        $data->reference = $request->reference;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->client_id = session('client_id');
        $data->created_at = $request->date . date(" h:i:s a"); 
        $data->updated_by = '';
        $data->save();
        $expense_id = $data->id;

        $date = $request->date . date(" h:i:s a");

        if($expense_id && $request->expense_type == 'Product Purchase'){
          $this->creditCompanyAc($request->company_id, $request->amount, $expense_id);
        }
        if($expense_id && $request->expense_type == 'Advance Payment'){
          $this->creditCompanyAc($request->company_id, $request->amount, $expense_id);
        } 
        //dd($request->payment_method);
        if($expense_id && $request->payment_method == 'Bank'){
          $this->creditBankAc($request->bank_id, $request->amount, $cashflow_id = null, $expense_id, $date);
        } 
        if($expense_id && $request->payment_method == 'MFS'){
          $this->creditBankAc($request->bank_id_mfs, $request->amount, $cashflow_id = null, $expense_id, $date);
        }        

        return redirect('expenses')->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id){
        $data = Expense::find($id); 
        if($data->client_id == session('client_id')){
          return view('admin.expense_edit', ['data'=>$data]);
        }else{
          return redirect('expenses')->with(session()->flash('alert-warning', 'Not Found!'));  
        }     
        
      }

    public function update(Request $request)
    {       
          if (!is_numeric($request->amount)) {
            return redirect()->back()->with(session()->flash('alert-warning', 'Amount should be a number!'));
          } 
          //return "Under Construction";
          $data = Expense::find($request->id); 
          $data->title = $request->title;
          $data->expense_type = $request->expense_type;
          $data->product_id = $request->product_id;
          $data->company_id = $request->company_id;
          $data->purchase_id = $request->purchase_id;
          $data->expensed_by = $request->expensed_by;
          $data->payment_method = $request->payment_method;
          // $data->amount = $request->amount;
          $data->boucher_no = $request->boucher_no;
          $data->reference = $request->reference;
          $data->description = $request->description;
          $data->notes = $request->notes;

                  
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          //dd($request->date);
          $data->date = $request->date;  
          $data->created_at = $request->date . date(" h:i:s a");  
          $data->updated_at = $request->date . date(" h:i:s a"); 
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('expenses')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Expense has been deleted successfully.'));
    }

    /*============================
     reports
       ============================*/

 

     

}
