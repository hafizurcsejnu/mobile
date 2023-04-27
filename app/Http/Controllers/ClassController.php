<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use DB;

class ClassController extends Controller
{
    public function classes()
    {
        $data = DB::table('classes')     
        ->where('classes.active', 'on')
        ->get(); 
        return view('classes', ['data'=>$data]);  
    }
    public function index()
    {
        $data = DB::table('classes')     
        ->where('classes.active', 'on')
        ->get(); 
        return view('admin.classes', ['data'=>$data]);  
    }

    public function show($id)
    {
        $fetch = ClassModel::find($id);  
        $data = new ClassModel;
        $data->hit_count = $fetch->hit_count;        
        $data->save();
      
        return view('class_details', ['data' => $fetch]);       
    }  

     
      public function create()
      {        
        return view('admin.class_add');
      }

      public function store(Request $request)
      {        
        $data = new ClassModel;
        $data->title = $request->title;
        $data->date_time = $request->date_time;
        $data->description = $request->description;
        $data->link = $request->link;
        
        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)
      {       
        $data = DB::table('classes')
        ->where('classes.id',$id)
        ->first();
        return view('admin.class_edit', ['data'=>$data]);
      }

      public function update(Request $request)
      {       
                
          $data = ClassModel::find($request->id);
          $data->title = $request->title;
          $data->date_time = $request->date_time;
          $data->description = $request->description;
          $data->link = $request->link;
          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect('/class')->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('classes')
      ->where('id',$id)
      ->delete();

      Session::put('message', 'Class deleted successfully!');
      return Redirect::to('/class');
    }

    /*============================
       End News Post
       ============================*/

     

}
