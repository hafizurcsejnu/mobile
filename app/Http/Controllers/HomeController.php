<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;


class HomeController extends Controller
{
    public function home() {
      if (session('user.user_type') == 'Admin') {
        return redirect('/dashboard'); 
      }else{
        return view('user_login'); 
      }
      
    }  
    public function index() 
    {
      
      //$data = Product::orderBy('id', 'desc')->get();
      $featured_products = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName')        
        ->where('products.active', 'on')
        ->where('products.featured', 'on')
        ->get();       

      $sets = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
      ->where('products.is_set', 'on')
      ->where('products.active', 'on')
      ->where('products.freebee', null)
      ->orderby('products.id', 'desc')
      ->limit(12)
      ->get(); 

      $collections = DB::table('products')
      ->where('active', 'on')
      ->where('product_type', 'collection')
      ->orderby('id', 'desc')
      ->limit(12)
      ->get(); 
      //dd($collections);

      $top_selling = DB::table('products') // need to change with top selling
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
      ->where('products.is_set', null)
      ->where('products.active', 'on')
      ->where('products.freebee', null)
      ->orderby('products.id', 'desc')
      ->limit(12)
      ->get();  

      $categories = ProductCategory::with('children')->has('children')->where('parent_id',NULL)->orderBy('name', 'asc')->paginate(5);
      return view('home', ['featured_products'=>$featured_products, 'top_selling'=>$top_selling, 'sets'=>$sets, 'collections'=>$collections, 'menu'=>'home','categories'=>$categories]);  
    }

    public function loadCategories(Request $request){
      $categories = ProductCategory::with('children')->has('children')->where('parent_id',null)->orderBy('name', 'asc')->skip($request->count)->take(5)->get();
      $remaining = ProductCategory::with('children')->has('children')->where('parent_id',null)->orderBy('name', 'asc')->skip($request->count)->take(5)->count();
      $total = ProductCategory::where('parent_id',null)->count();
      $remaining = $total - ($remaining + $request->count+5);
      $data = [
        "total"=>$total,
        "remaining"=>$remaining,
        "items"=>json_encode($categories)
      ];
      return response()->json($data);
    }

    public function show($id)
    {
        $fetch = Product::find($id);  
        $data = new Product;
        $data->hit_count = $fetch->hit_count;        
        $data->save();
      
        return view('product_details', ['data' => $fetch]);       
    }  

      /*============================
       products
       ============================*/
       public function products()
       {     
        $fetch = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName')
        ->get();        
        
        $data=view('admin.products')
        ->with('data',$fetch);

        return view('admin.master')
        ->with('main_content',$data);
      } 

      public function create()
      {        
        return view('admin.product_add');
      }

      public function store(Request $request)
      {        
        $data = new Product;
        $data->title = $request->title;
        $data->slug = Str::slug($request->title);
        $data->price = $request->price;
        $data->msrp = $request->msrp;
        $data->measurement_unit = $request->measurement_unit;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->meta_description = $request->meta_description;

        if($request->file('image')!= null){
            $data->image = $request->file('image')->store('images');
        } 
        $data->active = $request->active;
        $data->featured = $request->featured;
        $data->created_by = session('user_id');
        $data->updated_by = '';
        $data->save();

        return redirect()->back()->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

      }

      public function edit($id)
      {
       
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catID')
        ->where('products.id',$id)
        ->first();
        return view('admin.product_edit', ['data'=>$data]);
      }

      public function update(Request $request)
      {       
                
          $data = Product::find($request->id);
          $data->title = $request->title;
          $data->slug = Str::slug($request->title);
          $data->price = $request->price;
          $data->msrp = $request->msrp;
          $data->measurement_unit = $request->measurement_unit;
          $data->category_id = $request->category_id;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->meta_description = $request->meta_description;
          
          if($request->file('image')!= null){
              $data->image = $request->file('image')->store('images');
          }else{
              $data->image = $request->hidden_image;
          }
          $data->active = $request->active;
          $data->featured = $request->featured;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect('/products')->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function destroy($id)
    {
      DB::table('products')
      ->where('id',$id)
      ->delete();

      Session::put('message', 'Post deleted successfully!');
      return Redirect::to('/products');
    }


}
