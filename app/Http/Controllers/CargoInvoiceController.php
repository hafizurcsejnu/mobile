<?php

namespace App\Http\Controllers;

use App\Models\CargoInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class CargoInvoiceController extends Controller
{
    public function index()
    {
        $data = CargoInvoice::orderBy('id', 'desc')->get();
        return view('admin.cargo_invoices', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('cargo_invoices')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('cargo_invoices')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('cargo_invoice_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  

   
      /*============================
       cargo_invoices
       ============================*/
    public function cargo_invoices()
    {     
      $data = CargoInvoice::orderBy('id', 'desc')->get();
      return view('admin.cargo_invoices', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.cargo_invoice_add');
      }

      public function store(Request $request)
      {        
        $data = new CargoInvoice;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        $data->product_id = $request->product_id;
        $data->company_id = $request->company_id;
        $data->ship_id = $request->ship_id;
        $data->sordar_id = $request->sordar_id;
        $data->description = $request->description;
        $data->notes = $request->notes;
        $data->arrival_date_time = $request->arrival_date_time;
        $data->release_date_time = $request->release_date_time;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)      {
       
        $data = CargoInvoice::find($id);      
        return view('admin.cargo_invoice_edit', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = CargoInvoice::find($request->id);
          $data->title = $request->title;
          $data->product_id = $request->product_id;
          $data->company_id = $request->company_id;
          $data->ship_id = $request->ship_id;
          $data->sordar_id = $request->sordar_id;
          $data->description = $request->description;
          $data->notes = $request->notes;
          $data->arrival_date_time = $request->arrival_date_time;
          $data->release_date_time = $request->release_date_time;

          //delete past records
          DB::table('product_unloads')
          ->where('cargo_invoice_id',$request->id)
          ->delete();

          //product upload         
          $total_item = count($request->date);
          for ($i=0; $i < $total_item; $i++) { 
            $unload=array();
            $unload['product_id'] = $request->product_id;
            $unload['cargo_invoice_id'] = $request->id;
            $unload['store_id'] = $request->store_id[$i];
            $unload['qty'] = $request->qty[$i];
            $unload['wet'] = $request->wet[$i];
            $unload['unload_date'] = $request->date[$i];           
            DB::table('product_unloads')->insert($unload); 
          }
          
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
      DB::table('cargo_invoices')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'CargoInvoice has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
