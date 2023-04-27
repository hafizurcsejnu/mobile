<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
   
    
    public function index()
    {
        $data = BlogCategory::orderBy('id', 'desc')->get();
        return view('admin.blog_categories', ['data'=>$data]);
    }     
    
    
    public function store(Request $request)
    {
        $data = new BlogCategory;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));        
    }

    public function update(Request $request)    {        
        
        $data = BlogCategory::find($request->id);
        $data->name = $request->name;
        $data->save(); 

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {       
        $data = BlogCategory::find($id);
        $data->delete();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been deleted successfully.'));
    }

    
    
}
