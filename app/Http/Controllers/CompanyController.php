<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::orderBy('id', 'desc')->where('client_id', session('user.client_id'))->get();
        return view('admin.companies', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('companies')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('companies')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('company_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  

   
      /*============================
       companies
       ============================*/
    public function companies()
    {     
      $data = Company::orderBy('id', 'desc')->where('client_id', session('user.client_id'))->get();
      return view('admin.companies', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.company_add');
      }

      public function store(Request $request)
      {        
        $data = new Company;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->company_type = $request->company_type;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->website = $request->website;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->address = $request->address;
        $data->link_title = $request->link_title;
        $data->link_action = $request->link_action;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->Company('images');
        } 
        $data->active = $request->active;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)      {
       
        $data = Company::find($id);      
        return view('admin.company_edit', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = Company::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;
          $data->company_type = $request->company_type;
          $data->mobile = $request->mobile;
          $data->email = $request->email;
          $data->website = $request->website;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->address = $request->address;
          $data->link_title = $request->link_title;
          $data->link_action = $request->link_action;
          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->Company('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->client_id = session('client_id');
          $data->save(); 

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('companies')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Company has been deleted successfully.'));
    }

    public function update_company_ob(Request $request)
    {   
      $company_id = $request->company_id;
      $amount = $request->amount;
      if(!is_numeric($request->amount)) {
        return response()->json(['success'=>false,'data'=>'nan']);
      }

        //delete past records
        DB::table('company_accounts')
        ->where('company_id',$company_id)
        ->where('type', 'OB')
        ->delete();

      
        $ca = DB::table('company_accounts')
          ->where('company_id', $company_id)
          ->orderBy('id', 'DESC')
          ->first();
        if($ca){
            $current_balance = $ca->current_balance + $amount;  
        }else{
            $current_balance = $amount;
        } 
        
        $data = new CompanyAccount;
        $data->company_id = $company_id;        
        $data->type = 'OB';  
        $data->amount_in = $amount;
        $data->current_balance = $current_balance;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();
        $id = $data->id;

        if($id){
          return response()->json(['success'=>true,'data'=>$amount]);
        }else{
          return response()->json(['success'=>false,'data'=>'404']);
        }  
    }
     

}
