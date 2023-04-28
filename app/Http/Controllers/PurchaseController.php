<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Traits\DebitCreditTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class PurchaseController extends Controller
{
  use DebitCreditTrait;  
    public function index()
    {
        $data = Purchase::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
        return view('admin.purchases', ['data'=>$data]);        
    }    
    public function show($slug)
    {
        $fetch = DB::table('purchases')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('purchases')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('purchase_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  
   
      /*============================
       purchases
       ============================*/
    public function purchases()
    {     
      $data = Purchase::orderBy('id', 'desc')->where('client_id',session('client_id'))->get();
      return view('admin.purchases', ['data'=>$data]);
    } 

      public function create()
      {        
          return view('admin.purchase_add');
      }
     

      public function store(Request $request)
      {         
        //dd($request);
        $total_item = count($request->product_id);
        $total_price = $request->total_price;
        $transport_cost = $request->transport_cost;
        //$transport_cost_percent = $transport_cost/$total_price*100;
        
        $total_qty = 0;
        for ($i=0; $i < $total_item; $i++) {          
          $total_qty = $total_qty + $request->qty[$i];
        }

        $data = new Purchase;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        $data->company_id = $request->company_id;
        $data->vendor_id = $request->vendor_id;
        $data->supplier_id = $request->supplier_id;
        $data->total_item = $total_item;
        $data->total_qty = $total_qty;
        $data->transport_cost = $transport_cost;
        $data->total_price = $request->total_price;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        $data->dealer_name = $request->dealer_name;
        $data->dealer_address = $request->dealer_address;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();
        $purchase_id = $data->id;

        //dd($data);

        if($purchase_id && $request->company_id != null){
          $this->debitCompanyAc($request->company_id, $request->total_price, $purchase_id, $expense_id = null);
        }

         //purchase details table        
         for ($i=0; $i < $total_item; $i++) { 
          if($request->product_id[$i] == null){
            return redirect()->back()->with(session()->flash('alert-warning', 'Product can not be empty!'));    
          }
          
          if($transport_cost != null){            
            //$courier_pu =  $request->price[$i] * $transport_cost_percent / 100;
            //$price_c = $request->price[$i] + $courier_pu;
            $total_price_c = $request->price[$i] * $request->qty[$i] + $transport_cost;             
          }else{
            $courier_pu = null;
            $price_c = $request->price[$i];
            $total_price_c = $request->price[$i] * $request->qty[$i];
          }
        
          
          $pd=array();
          $pd['purchase_id'] = $purchase_id;
          $pd['product_id'] = $request->product_id[$i];
          $pd['qty'] = $request->qty[$i];
          $pd['price'] = $request->price[$i];
          $pd['total_price'] = $request->price[$i] * $request->qty[$i];
                    
          $pd['courier_pu'] = round($courier_pu, 2); 
          $pd['price_c'] = round($price_c, 2); 
          $pd['total_price_c'] = round($total_price_c, 2);  
          if(isset($request->product_sn[$i])){
            $pd['product_sn'] = $request->product_sn[$i]; 
          }
          DB::table('purchase_details')->insert($pd); 
          
          // imei record 
          $imei = 'imei_'.$i+1;          
          if(isset($request->$imei) && $request->$imei != null){
            $imei_array = explode(",", $request->$imei);
            //dd($imei_array[5]);
            $total_imei = count($imei_array);
            for ($j=0; $j < $total_imei; $j++) { 
              if($imei_array[$j] == null) continue;
              $psd = array();
              $psd['purchase_id'] = $purchase_id;
              $psd['product_id'] = $request->product_id[$i];
              $psd['imei'] = $imei_array[$j];
              // $psd['product_sn'] = $request->product_sn[$j]; 
              $psd['client_id'] = session('client_id'); 
              DB::table('product_stock_details')->insert($psd);               
            }
            //dd('break 2');
          }
          $this->debitProductStock($request->product_id[$i], $request->store_id, $request->qty[$i], $purchase_id);

        }
        return redirect('edit-purchase/'.$purchase_id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));   

      } 
      
      public function stockAdmustment(Request $request)
      {
        $store_id = session('client_id');
        if($request->type == 'Debit'){
          $purchase_id = 'Plus';
          $this->debitProductStock($request->product_id, $store_id, $request->qty, $purchase_id);
        }
        if($request->type == 'Credit'){
          $invoice_id = 'Minus';
          $this->creditProductStock($request->product_id, $store_id, $request->qty, $invoice_id);
        }
        return redirect()->back()->with(session()->flash('alert-success', 'Stock adjusted successfully.'));   
        
      }
      public function store2(Request $request)
      {        
        $total_item = count($request->product_sn);
        $total_price = $request->total_count;
        $qty = $request->qty;
        $transport_cost = $request->transport_cost;
        $transport_cost_percent = $transport_cost/$total_price*100;       

        $data = new Purchase;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        $data->vendor_id = $request->vendor_id;
        $data->supplier_id = $request->supplier_id;
        $data->total_item = $total_item;
        $data->total_qty = $qty;
        $data->transport_cost = $transport_cost;
        $data->total_price = $request->total_price;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        $data->dealer_name = $request->dealer_name;
        $data->dealer_address = $request->dealer_address;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();
        $purchase_id = $data->id;

       

         //Product stock details table        
         for ($i=0; $i < $total_item; $i++) { 
          if($request->product_sn[$i] == null){
            return redirect()->back()->with(session()->flash('alert-warning', 'Product serial can not be empty!'));    
          }
          //dd($request->product_id);

          $psd=array();
          $psd['purchase_id'] = $purchase_id;
          $psd['product_id'] = $request->product_id;
          $psd['product_sn'] = $request->product_sn[$i]; 
          $psd['client_id'] = session('client_id');
          DB::table('product_stock_details')->insert($psd); 
          
        }
          
        // courier cost per unit
        if($transport_cost != null){            
          $courier_pu =  $request->price * $transport_cost_percent / 100;
          $price_c = $request->price + $courier_pu;
          $total_price_c = $request->price * $request->qty + $transport_cost;             
        }else{
          $courier_pu = null;
          $price_c = $request->price;
          $total_price_c = $request->price * $request->qty;
        }
        // purchase details
        $pd=array();
        $pd['purchase_id'] = $purchase_id;
        $pd['product_id'] = $request->product_id;
        $pd['qty'] = $request->qty;
        $pd['price'] = $request->price;
        $pd['total_price'] = $request->price * $request->qty;
                  
        $pd['courier_pu'] = round($courier_pu, 2); 
        $pd['price_c'] = round($price_c, 2); 
        $pd['total_price_c'] = round($total_price_c, 2);  
        DB::table('purchase_details')->insert($pd); 
      
        $this->debitProductStock($request->product_id, $request->store_id, $request->qty, $purchase_id);

        return redirect('edit-purchase/'.$purchase_id)->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id){       
        $data = Purchase::find($id);      
        if(session('bt') == 'd' || session('bt') == 'b'){
          //dd('purchase_edit4');
          return view('admin.purchase_edit4', ['data'=>$data]);
        }
        elseif(session('bt') == 'p'){
          return view('admin.purchase_edit_p', ['data'=>$data]);
        }
        else{
          return view('admin.purchase_edit', ['data'=>$data]);
        }

      }

    public function update(Request $request)
    {       
        $purchase_id = $request->id;  
        $total_item = count($request->product_id);
        $total_price = $request->total_price;
        $transport_cost = $request->transport_cost;
        $transport_cost_percent = $transport_cost/$total_price*100;

        $total_qty = 0;
        for ($i=0; $i < $total_item; $i++) {          
          $total_qty = $total_qty + $request->qty[$i];
        }
          
        //return "Under Construction";
        $data = Purchase::find($purchase_id);
        $data->title = $request->title;
        $data->company_id = $request->company_id;
        $data->supplier_id = $request->supplier_id;
        $data->total_item = $total_item;
        $data->total_qty = $total_qty;
        $data->transport_cost = $transport_cost;
        $data->total_price = $request->total_price;
        $data->date = $request->date;
        $data->description = $request->description;
        $data->notes = $request->notes;
        $data->dealer_name = $request->dealer_name;
        $data->dealer_address = $request->dealer_address;

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


        //credit past records before purchase details delete
        $old_purchase =  DB::table('purchase_details')
            ->where('purchase_id', $request->id)
            ->get(); 
        foreach($old_purchase as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('purchase_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        //insert purchase details newly        
        for ($i=0; $i < $total_item; $i++) { 

          if($transport_cost != null){            
            $courier_pu =  $request->price[$i] * $transport_cost_percent / 100;
            $price_c = $request->price[$i] + $courier_pu;
            $total_price_c = $request->price[$i] * $request->qty[$i] + $transport_cost;             
          }else{
            $courier_pu = null;
            $price_c = $request->price[$i];
            $total_price_c = $request->price[$i] * $request->qty[$i];
          }

          $store_id = session('client_id');
          $pd=array();
          $pd['purchase_id'] = $purchase_id;
          $pd['product_id'] = $request->product_id[$i];
          $pd['qty'] = $request->qty[$i];
          $pd['price'] = $request->price[$i];
          $pd['total_price'] = $request->price[$i] * $request->qty[$i];
                    
          $pd['courier_pu'] = round($courier_pu, 2); 
          $pd['price_c'] = round($price_c, 2); 
          $pd['total_price_c'] = round($total_price_c, 2); 
          //$pd['product_sn'] = $request->product_sn[$i];  /// rabbi
          DB::table('purchase_details')->insert($pd); 

          $this->debitProductStock($request->product_id[$i], $store_id, $request->qty[$i], $purchase_id);

        } 
       

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      $store_id = session('client_id');
       //credit past records before purchase details delete
       $old_purchase =  DB::table('purchase_details')
            ->where('purchase_id', $id)
            ->get(); 
        foreach($old_purchase as $item){
          $this->creditProductStock($item->product_id, $store_id, $item->qty, $invoice_id='');
          DB::table('purchase_details')
            ->where('id', $item->id)
            ->delete();             
        }   

        DB::table('purchases')
        ->where('id',$id)
        ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Purchase has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
