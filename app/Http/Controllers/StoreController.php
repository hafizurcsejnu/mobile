<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class StoreController extends Controller
{
    public function index()
    {
        $data = Store::orderBy('id', 'desc')->where('client_id', session('client_id'))->get();
        return view('admin.stores', ['data'=>$data]);        
    }

    public function show($id)
    {
        $fetch = DB::table('stores')
                ->where('id',$id)
                ->first();      
        return view('admin.store_details', ['data' => $fetch]);
    }   
    public function stock($id)
    {
        $fetch = DB::table('stores')
                ->where('id',$id)
                ->first();    
                //dd($fetch);  
        return view('admin.stock', ['data' => $fetch]);
    }    

   
      /*============================
       Stores
       ============================*/
    public function Stores()
    {     
      $data = Store::orderBy('id', 'desc')->get();
      return view('admin.stores', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.store_add');
      }

      public function store(Request $request)
      {        
        $data = new Store;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->store_type = $request->store_type;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->address = $request->address;
        $data->link_title = $request->link_title;
        $data->link_action = $request->link_action;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)      {
       
        $data = Store::find($id);      
        return view('admin.store_edit', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = Store::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;

          $data->store_type = $request->store_type;
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
      // DB::table('stores')
      // ->where('id',$id)
      // ->delete();

      //return redirect()->back()->with(session()->flash('alert-success', 'Store has been deleted successfully.'));
      return redirect()->back()->with(session()->flash('alert-warning', 'Pls contact with the support team.'));
    }

    public function find_store(Request $request){
      $data = DB::table('stores')
          ->where('store_type', $request->storeType)
          ->get();
      $total = $data->count();
      // dd($sub_categories);
      return response()->json(['success'=>true,'data'=>$data, 'total'=>$total]);
      
  }

    /*============================
       End News Post
       ============================*/

     

}
