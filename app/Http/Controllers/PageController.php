<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class PageController extends Controller
{
    public function index()
    {
        $data = Page::orderBy('id', 'desc')->get();
        return view('admin.pages', ['data'=>$data]);        
    }

    public function show($slug)
    {
        $fetch = DB::table('pages')
                ->where('slug',$slug)
                ->first();
        $data['hit_count']= $fetch->hit_count+1;
        
        DB::table('pages')
        		->where('slug',$slug)
        		->update($data);
        //echo $data['hit_count'];exit();

        return view('page_details', ['data' => $fetch]);
        // return \Response::json($post_data);        
    }  

   
      /*============================
       Pages
       ============================*/
    public function pages()
    {     
      $data = Page::orderBy('id', 'desc')->get();
      return view('admin.pages', ['data'=>$data]);
    } 

      public function create()
      {        
        return view('admin.page_add');
      }

      public function store(Request $request)
      {        
        $data = new Page;
        $data->title = $request->title;       
        $data->slug = Str::slug($request->title);
        //dd($data->slug);
        $data->sub_title = $request->sub_title;
        $data->parent = $request->parent;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->meta_description = $request->meta_description;
        $data->link_title = $request->link_title;
        $data->link_action = $request->link_action;
        
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
       
        $data = Page::find($id);      
        return view('admin.page_edit', ['data'=>$data]);
      }

    public function update(Request $request)
    {       
          $data = Page::find($request->id);
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;

          $data->parent = $request->parent;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->meta_description = $request->meta_description;
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
      DB::table('pages')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Page has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
