<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB; 

class ProductionController extends Controller
{
  use DebitCreditTrait;  
    public function index()
    {
        $data = Production::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
        return view('admin.productions', ['data'=>$data]);        
    }    
    public function show($slug)
    {
        $fetch = DB::table('productions')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('productions')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('production_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  
   
      /*============================
       productions
       ============================*/
    public function productions()
    {     
      $data = Production::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
      return view('admin.productions', ['data'=>$data]);
    } 

    public function create()
    {        
      if(session('bt') == 'p'){
        return view('admin.production_add');
      }
      else{
        return view('admin.production_add');
      }
    }
     

    public function store(Request $request)
    {         
      
      $total_item = count($request->product_id);
      
      $raw_qty = $request->raw_qty;
      
      
      $total_qty = 0;
      for ($i=0; $i < $total_item; $i++) {          
        $total_qty = $total_qty + $request->qty[$i];
      }

      $data = new Production;
      $data->title = $request->title;  
      $data->total_item = $total_item;
      $data->total_qty = $total_qty;
      $data->raw_qty = $raw_qty;
      $data->total_price = $request->total_price;
      $data->date = $request->date;
      $data->description = $request->description;
      $data->notes = $request->notes;
      
      $data->client_id = session('client_id');
      $data->created_by = session('user_id');
      $data->updated_by = '';
      $data->save();
      $production_id = $data->id;

      
        //production details table        
        for ($i=0; $i < $total_item; $i++) { 
        if($request->product_id[$i] == null){
          return redirect()->back()->with(session()->flash('alert-warning', 'Product can not be empty!'));    
        }
        
        $pd=array();
        $pd['production_id'] = $production_id;
        $pd['date'] = $request->date[$i];
        $pd['product_id'] = $request->product_id[$i];
        $pd['qty'] = $request->qty[$i];
        // $pd['price'] = $request->price[$i];
        // $pd['total_price'] = $request->price[$i] * $request->qty[$i];
          
        DB::table('production_details')->insert($pd); 
        
        $this->debitProductStock($request->product_id[$i], $request->store_id, $request->qty[$i], $production_id);

      }
      return redirect('edit-production/'.$production_id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

    } 
 
      
    public function edit($id){       
      $data = Production::find($id);      
      
      return view('admin.production_edit', ['data'=>$data]);
      
    }

    public function update(Request $request)
    {       
        $production_id = $request->id;  
        $total_item = count($request->product_id);
        $total_price = $request->total_price;
        $raw_qty = $request->raw_qty;
        
        
        $total_qty = 0;
        for ($i=0; $i < $total_item; $i++) {          
          $total_qty = $total_qty + $request->qty[$i];
        } 
          
        //return "Under Construction";
        $data = Production::find($production_id);
        $data->title = $request->title;
        
        $data->total_item = $total_item;
        $data->total_qty = $total_qty;
        $data->raw_qty = $raw_qty;
        $data->total_price = $request->total_price;
        $data->date = $request->date;
        
        $data->notes = $request->notes;
        

        //dd($request->total_price);
        $store_id = session('client_id');
         
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        }else{
            $data->image = $request->hidden_image;
        }
        $data->active = $request->active;
        $data->updated_by = session('user_id');
        $data->save(); 


        //credit past records before production details delete
        $old_production =  DB::table('production_details')
            ->where('production_id', $request->id)
            ->get(); 
        foreach($old_production as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('production_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        //insert production details newly        
        for ($i=0; $i < $total_item; $i++) { 

          $store_id = session('client_id');
          $pd=array();
          $pd['production_id'] = $production_id;
          $pd['date'] = $request->date[$i];
          $pd['product_id'] = $request->product_id[$i];
          $pd['qty'] = $request->qty[$i];
          $pd['price'] = $request->price[$i];
          $pd['total_price'] = $request->price[$i] * $request->qty[$i];
          
           DB::table('production_details')->insert($pd); 

          $this->debitProductStock($request->product_id[$i], $store_id, $request->qty[$i], $production_id);

        } 
       

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      $store_id = session('client_id');
       //credit past records before production details delete
       $old_production =  DB::table('production_details')
            ->where('production_id', $id)
            ->get(); 
        foreach($old_production as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('production_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        DB::table('productions')
        ->where('id',$id)
        ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Production has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
