<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class BlogController extends Controller
{
    public function index()
    {
      //$data = Blog::orderBy('id', 'desc')->get();
      $data = DB::table('blogs')
        ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
        ->select('blogs.*', 'blog_categories.name as catName')        
        ->where('blogs.active', 'on')
        ->get(); 

      return view('blog', ['data'=>$data]);  
    }

    public function show($id)
    {
        $fetch = Blog::find($id);  
        $data = new Blog;
        $data->hit_count = $fetch->hit_count;        
        $data->save();
      
        return view('blog_details', ['data' => $fetch]);       
    }  

      /*============================
       Blogs
       ============================*/
       public function blogs()
       {     

        $fetch = DB::table('blogs')
        ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
        ->select('blogs.*', 'blog_categories.name as catName')
        ->get();        
        
        $data=view('admin.blogs')
        ->with('data',$fetch);

        return view('admin.master')
        ->with('main_content',$data);
      } 

      public function create()
      {        
        return view('admin.blog_add');
      }

      public function store(Request $request)
      {        
        $data = new Blog;
        $data->title = $request->title;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        
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
       
        $data = DB::table('blogs')
        ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
        ->select('blogs.*', 'blog_categories.name as catName', 'blog_categories.id as catID')
        ->where('blogs.id',$id)
        ->first();
        return view('admin.blog_edit', ['data'=>$data]);
      }

      public function update(Request $request)
      {       
                
          $data = Blog::find($request->id);
          $data->title = $request->title;
          $data->category_id = $request->category_id;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect('/blogs')->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('blogs')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Item has been deleted successfully.'));
    }

    /*============================
       End News Post
       ============================*/

     

}
