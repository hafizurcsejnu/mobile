<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class ProductCategoryController extends Controller
{
   
    function make_slug($string) {
        return preg_replace('/\s+/u', '-', trim($string));
    }  

    public function index()
    {
        $data = ProductCategory::orderBy('id', 'desc')->where('parent_id', null)->where('client_id', session('client_id'))->get();
        return view('admin.product_categories', ['data'=>$data]);
    }     
    
    
    public function store(Request $request)
    {
       
        // name can be same in different category.. 
        if(ProductCategory::where('name', $request->name)->where('parent_id', $request->parent_id)->where('client_id', session('client_id'))->first())
        {  
            return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        }

        $data = new ProductCategory;
        $data->name = $request->name;
        //$data->slug = Str::slug($request->name);
        $data->slug = preg_replace('/\s+/u', '-', trim($request->name));

        $data->parent_id = $request->parent_id;
        $data->active = 'on';
        if(file_exists($request->file('image'))){
            $data->image = $request->file('image')->store('images');
        }
        $data->client_id = session('client_id');
        $data->created_by = session('user_id');
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));        
    }

    public function update(Request $request)    {        
        
        if(ProductCategory::where('name', $request->name)->where('parent_id', $request->parent_id)->first())
        {
            return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        }
        
        $data = ProductCategory::find($request->id);
        $data->name = $request->name;
        $data->slug = preg_replace('/\s+/u', '-', trim($request->name));
        $data->parent_id = $request->parent_id;
        // print_r($request->old_parent_id);
        // dd($request->id);
        if($request->old_parent_id != $request->parent_id){
            $products = Product::where('category_id',$request->old_parent_id)
                        ->where('sub_category_id',$request->id)
                        ->update(['category_id' => $request->parent_id]);           
        }        

        if(file_exists($request->file('image'))){
            $data->image = $request->file('image')->store('images');
        }
        $data->updated_by = session('user_id');        
        $data->save(); 

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {       
        //checking anchor
        if($id == 1){
            return redirect()->back()->with(session()->flash('alert-danger', 'This is anchor category! You can not delete it! If needed you can edit this.'));
        }
        //checking subcat existance
        $sub_category = ProductCategory::where('parent_id',$id)->first();
        if($sub_category != null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Item has sub category! Please delete sub category first!'));
        }

        $related_products = Product::where('category_id',$id)->get();
        //dd($related_products);
        foreach ($related_products as $item){
            $product = Product::find($item->id);
            $product->category_id = 1;
            //$product->sub_category_id = null;
            $product->save(); 
        }       

        //delete
        $data = ProductCategory::find($id);
        $data->delete();
        return redirect()->back()->with(session()->flash('alert-success', 'Data has been deleted successfully.'));
    }
    public function destroySubCat($id)
    {       
       
        //checking subcat existance
        $sub_category = ProductCategory::where('parent_id',$id)->first();
        if($sub_category != null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Item has sub category! Please delete sub category first!'));
        }

        $related_products = Product::where('sub_category_id',$id)->get();
        //dd($related_products);
        foreach ($related_products as $item){
            $product = Product::find($item->id);
            $product->sub_category_id = null;
            $product->save(); 
        }       

        //delete
        $data = ProductCategory::find($id);
        $data->delete();
        return redirect()->back()->with(session()->flash('alert-success', 'Data has been deleted successfully.'));
    }

    
    
}
