<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
        return view('admin.employees', ['data'=>$data]);        
    }

       
      /*============================
       Employees
       ============================*/
    public function Employees()
    {     
      $data = Employee::orderBy('id', 'desc')->get();
      return view('admin.employees', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.employee_add');
      }

      public function store(Request $request)
      {        
        $data = new Employee;
        $data->title = $request->title;       
        $data->designation = $request->designation;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->salary_type = $request->salary_type;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->address = $request->address;
        $data->joining_date = $request->joining_date;
        $data->salary_amount = $request->salary_amount;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->client_id = session('client_id');
        $data->updated_by = '';
        $data->save();  
        $data->id;

        return redirect('employees')->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    
        //return redirect('employee-details/'.$data->id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id){
        $data = Employee::find($id);      
        return view('admin.employee_edit', ['data'=>$data]);
      }

      public function show($id){
        $data = Employee::find($id);      
        return view('admin.employee_details', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = Employee::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;
          $data->mobile = $request->mobile;
          $data->email = $request->email;
          $data->salary_type = $request->salary_type;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->address = $request->address;
          $data->joining_date = $request->joining_date;
          $data->salary_amount = $request->salary_amount;
          
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
      DB::table('employees')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Employee has been deleted successfully.'));
    }

    public function storeOB(Request $request)
    { 
      if(!is_numeric($request->amount)) {
        return redirect()->back()->with(session()->flash('alert-warning', 'Opening balance should be a number!')); 
      }
       
      $ob = DB::table('employee_accounts')
      ->where('employee_id', $request->employee_id)
      ->where('type', 'OB')
      ->orderBy('id', 'desc')
      ->first();

      $amount = $request->amount;

      if($ob != null){
        $ob_id = $ob->id;
        $ob = EmployeeAccount::find($ob_id);      
        $ob['employee_id'] = $request->employee_id;
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
        $data = new EmployeeAccount;
        $data->employee_id = $request->employee_id;       
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
