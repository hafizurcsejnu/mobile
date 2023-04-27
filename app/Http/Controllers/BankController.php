<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class BankController extends Controller
{
    public function index()
    {
        $data = Bank::orderBy('id', 'asc')->where('client_id', session('client_id'))->get();
        return view('admin.banks', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('banks')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('banks')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('bank_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  

   
      /*============================
       banks
       ============================*/
    public function banks()
    {      
      $data = Bank::orderBy('id', 'asc')->where('client_id', session('client_id'))->get();
      return view('admin.banks', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.bank_add');
      }

      public function store(Request $request)
      {        
        $data = new Bank;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->description = $request->description;
        $data->branch = $request->branch;
        $data->address = $request->address;
        $data->ac_name = $request->ac_name;
        $data->ac_no = $request->ac_no;
        $data->banking_type = $request->banking_type;

        //dd($request->banking_type);
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->client_id = session('client_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    
 
      }

      public function edit($id){
       
        $data = Bank::find($id);      
        return view('admin.bank_edit', ['data'=>$data]);
      }

      public function bankOB($bank_id, $amount)
      {        
          $ob = DB::table('bank_accounts')
          ->where('bank_id', $bank_id)
          ->where('type', 'OB')
          ->orderBy('id', 'desc')
          ->first(); 
  
   
          if($ob != null){
            //dd('ob not null'); 
            $ob_id = $ob->id;
            $ob = BankAccount::find($ob_id);      
            $ob['bank_id'] = $bank_id;
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
          //dd($amount);

            $data = new BankAccount;
            $data->bank_id = $bank_id;       
            $data->type = 'OB';  
            if($amount>0){
              $data['amount_in'] = $amount;
              $data['amount_out'] = 0;
            }else{
              $data['amount_in'] = 0;
              $data['amount_out'] = $amount;
            }
            $data->current_balance = $amount;
        
            $data->created_by = session('user_id');
            $data->client_id = session('client_id');
            $data->save();
          }
  
      }

      public function update(Request $request)
      {       
          $data = Bank::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;
          $data->mobile = $request->mobile;
          $data->email = $request->email;
          $data->description = $request->description;
          $data->branch = $request->branch;
          $data->address = $request->address;
          $data->ac_name = $request->ac_name;
          $data->ac_no = $request->ac_no;
          $data->banking_type = $request->banking_type;

          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->Bank('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->save(); 

          if($request->ob != null){
            //dd($request->ob);
            $this->bankOB($request->id, $request->ob);
          }

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('banks')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Bank has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
