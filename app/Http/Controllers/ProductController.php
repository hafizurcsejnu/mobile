<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\CategoryTrait;
use App\Models\ProductCategory;
use DB;


class ProductController extends Controller
{
    use CategoryTrait;
       
    public function index()
    {
      //$data = Product::orderBy('id', 'desc')->get();
      $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
        ->where('products.active', 'on')
        ->where('products.product_type', 'Product')
        ->get(); 

      return view('Product', ['data'=>$data]);  
    }
 
    public function show($slug)
    {      
        $data = Product::where('slug', $slug)->first();  
        if($data == null){
          return redirect('/404')->with(session()->flash('alert-warning', 'Item is not available!'));
        }  
        if($data->active != 'on'){
          return redirect('/404')->with(session()->flash('alert-warning', 'Item is not available right now!'));
        }  
        if($data->hit_count != null){
           $data->hit_count = $data->hit_count + 1;  
        }else{
          $data->hit_count = 1;  
        }             
        $data->update();      
        return view('admin.product', ['item' => $data, 'menu'=>'shop']);       
    }  

    public function quickView($id)
    {      
        $fetch = Product::find($id);  
        return view('quick_view', ['item' => $fetch]);       
    }  
    public function sets()
    {      
      $data = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
      ->where('products.is_set', 'on')
      ->where('products.active', 'on')
      ->get(); 
      $total = $data->count();

      return view('sets', ['data'=>$data, 'menu'=>'sets', 'total'=>$total, 'page'=>'sets']);   
    }  
    public function collections()
    {      
      $data = DB::table('products') 
      ->where('active', 'on')
      ->where('product_type', 'collection')
      ->orderby('id', 'desc')
      ->get(); 
      $total = $data->count();

      return view('collections', ['data'=>$data, 'menu'=>'collections', 'total'=>$total, 'page'=>'collections']);   
    } 

    public function download($id, $source)
    {  
      $product = DB::table('products')     
                ->where('id', $id)
                ->first();
      if($product->$source == null){        
        return redirect('my-account#tab-downloads')->with(session()->flash('alert-danger', 'The source file is not available! Please contact system admin.'));  
      }
   
      //checking purchase log 
      $purchase = DB::table('order_details')     
                ->where('product_id', $id)
                ->where('user_id', session('user_id'))
                ->first();  
      if($purchase){
          $data = Product::find($id); 
          return redirect($data->$source);
      }else{
          return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
      }
      
    }  
    public function downloadCollection($id, $source)
    {  
      $product = DB::table('products')     
                ->where('id', $id)
                ->first();
      if($product->$source == null){        
        return redirect('my-account#tab-downloads')->with(session()->flash('alert-danger', 'The source file is not available! Please contact system admin.'));  
      }
   
      // if($parent != null){
      //   $id = $parent;      
      // }
      //checking purchase log 
      $purchase = 1;  
      if($purchase){
          $data = Product::find($id); 
          return redirect($data->$source);
      }else{
          return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
      }
      
    }  
    public function freebeesDownload($id, $source)
    {           
      $data = Product::find($id); 
      //dd($id);
      return redirect($data->$source);
    }  


   

    /*============================
      products
      ============================*/
  
      
    public function products()
    { 
      
      $users = DB::table('users')
      ->select('id')
      ->where('client_id', session('user.client_id'))
      ->get();      
      //dd($users);

      $fetch = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId') 
      ->where('products.product_type', 'Product') 
      ->where('products.client_id', session('client_id')) //those whose client_id = session('client_id')
      ->orderby('products.id', 'asc')
      ->get();       
      
      $data=view('admin.products')
      ->with('data',$fetch);

      return view('admin.master')
      ->with('main_content',$data);
    }  
    
    public function services()
    { 
      $users = DB::table('users')
      ->select('id')
      ->where('client_id', session('user.client_id'))
      ->get();      
      //dd($users);

      $fetch = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId') 
      ->where('products.product_type', 'Service') 
      ->where('products.client_id', session('client_id')) 
      ->orderby('products.id', 'desc')
      ->get();       
      
      $data=view('admin.services')
      ->with('data',$fetch);

      return view('admin.master')
      ->with('main_content',$data);
    } 

    public function create()
    {        
      $last_item = DB::table('products')
      ->where('client_id', session('client_id'))
      ->orderBy('id', 'DESC')
      ->first();        
      return view('admin.product_add', ['last_item' => $last_item]);
    } 
    public function create2()
    {         
      $last_item = DB::table('products')
      ->where('client_id', session('client_id'))
      ->orderBy('id', 'DESC')
      ->first();        
      return view('admin.product_add2', ['last_item' => $last_item]);
    }

    public function createService()
    {        
      $last_item = DB::table('products')
      ->where('client_id', session('client_id'))
      ->orderBy('id', 'DESC')
      ->first();        
      if(session('bt') == 'e'){
        return view('admin.service_add_equipement', ['last_item' => $last_item]);
      }else{
        return view('admin.service_add', ['last_item' => $last_item]);
      } 
    }

    public function store(Request $request)
    {        
      if(Product::where('name', $request->name)->first())
      {
          return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
      } 
      if(is_numeric($request->price) == null){
        return redirect()->back()->with(session()->flash('alert-danger', 'Price should be a number!'));    
      }          

      $input=$request->all();
      $all_images=array();

      if($request->file('productImages') == null){
        //return redirect('add-product')->with(session()->flash('alert-danger', 'Product images can not be null.'));    
      }
      
        //upload images
      $removed_images =$request->excludeImages;   
      $removed_items= explode("*",$removed_images);  

      if($files=$request->file('productImages')){
        foreach($files as $file){
            
            $name_original=$file->getClientOriginalName();               
            if (in_array($name_original, $removed_items)) {
                //echo "Just skip";
            }else{
              $name = time().rand(100,999).'_'.$name_original;                
              $file->move('images',$name);                
              $all_images[]=$name;   
            }             
        }          
      }      
      $final_images = implode('|', $all_images);
      //end upload image   


      $data = new Product;
      $data->name = $request->name;
      if(session('client_id') == 11 & $request->category_id == 1847){
        //$data->name = $request->name . ' - ' . $request->brand;
      }
      $data->slug = preg_replace('/\s+/u', '-', trim($request->name));
      $data->tp = $request->tp;
      $data->price = $request->price;
      $data->msrp = $request->msrp;
      $data->category_id = $request->category_id;      
      $data->sub_category_id = $request->sub_category_id;
      $data->description = $request->description;
      $data->short_description = $request->short_description;        
      $data->meta_description = $request->meta_description;
      if($request->usages != null)$data->usages = implode(', ', $request->usages);
      if($request->materials != null)$data->materials = implode(', ', $request->materials);
      if($request->hidden_data != null)$data->hidden_data = implode(', ', $request->hidden_data);
      
      $data->code = $request->code;
      $data->barcode = $request->barcode;
      $data->brand = $request->brand;
      $data->model = $request->model;
      $data->particular = $request->particular;
      $data->measurement_unit = $request->measurement_unit;
      $data->warranty = $request->warranty;
      $data->images = $final_images;
      if($request->file('thumbnail')!= null){
          $data->thumbnail = $request->file('thumbnail')->store('thumbnails');
      } 

      $data->product_type = $request->product_type;
      if($request->product_type == 'Service'){
        $data->service_type = $request->service_type;
      }
      $data->active = $request->active;
      $data->featured = $request->featured;
      $data->is_set = $request->is_set;
      $data->client_id = session('client_id');
      $data->created_by = session('user_id');
      $data->updated_by = '';
      $data->save();

      if($request->source == '2'){
        return redirect('add-product2')->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    
      }

      return redirect('products')->with(session()->flash('alert-success', 'Data has been inserted successfully.'));    

    }



      public function edit($id)
      {
       
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catID')
        ->where('products.id', $id)
        ->where('products.client_id', session('client_id'))
        ->first();
        if($data != null){
          return view('admin.product_edit', ['data'=>$data]);
        }else{
          return redirect('products')->with(session()->flash('alert-warning', 'You are not authorized.'));    
        }
        
      }
      public function editService($id)
      {
       
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catID')
        ->where('products.id',$id) 
        ->first(); 

        if(session('bt') == 'e'){
          return view('admin.service_edit_equipement', ['data'=>$data]);
        }else{
          return view('admin.service_edit', ['data'=>$data]);
        } 

      }

      public function update(Request $request) 
      {       
        if(Product::where('name', $request->name)->get()->count() > 1)
        {
            return redirect()->back()->with(session()->flash('alert-warning', 'A term with the name provided already exists!'));       
        } 
        //validation
         if(is_numeric($request->price) == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Price should be a number!'));    
        }   

          $input=$request->all(); 
          $new_images=array();
  
          $hidden_image =$request->hidden_image;   
          $hidden_image_array= explode("|",$hidden_image); 
          
          $removed_images =$request->excludeImages;   
          $removed_items= explode("*",$removed_images);
    
          if($files=$request->file('productImages')){
              foreach($files as $file){
                  $name_original=$file->getClientOriginalName();               
                  if (in_array($name_original, $removed_items)) {
                      //echo "Just skip";
                  }else{
                    $name = time().rand(100,999).'_'.$name_original;                
                    $file->move('images',$name);                
                    $new_images[]=$name;   
                  }
                } 
            }    
        
        $all_selected_images = array_merge($hidden_image_array,$new_images);
        //print_r($all_selected_images);       

        // getting all removed items
        $removed_image = $request->excludeImages;
        $removed_image_array = explode('*',$removed_image);
        $removed_image_name = Array();
        
        foreach($removed_image_array as $image){       
          if($image!=""){
            if(filter_var($image,FILTER_VALIDATE_URL)){
              $pathinfo = pathinfo($image);
              $filename = $pathinfo['basename'];                       
              array_push($removed_image_name,$filename);                
            }
            else{                
                $filtered_image_path = explode('/images/',$image);                
                $filtered_image_path = $filtered_image_path[1];
                array_push($removed_image_name, $filtered_image_path);
            } 
          }            
        }

        // delete removed items
        foreach($removed_image_name as $filename){
          if($filename!=""){
            if (file_exists("images/".$filename)) {              
              // dd("images/".$filename);
              $status = unlink("images/".$filename);
            }
          }
        }
      

          $final_images =  array_diff($all_selected_images, $removed_image_name);          
          $final_images = implode('|', $final_images);

          if($final_images == null){
            //return redirect()->back()->with(session()->flash('alert-danger', 'Product images can not be null.'));    
          }

          $data = Product::find($request->id);
          $data->name = $request->name;
          $data->slug = preg_replace('/\s+/u', '-', trim($request->name));
          $data->images = $final_images;

          if($request->file('thumbnail')!= null){
            $data->thumbnail = $request->file('thumbnail')->store('thumbnails');
          }else{
              $data->thumbnail = $request->hidden_thumbnail;
          }

          $data->tp = $request->tp;
          $data->price = $request->price;
          $data->msrp = $request->msrp;
          $data->measurement_unit = $request->measurement_unit;
          
          //if($request->sub_category_id != null){
            //$data->category_id = $request->sub_category_id;
          //}else{
            $data->category_id = $request->category_id;
          //}     
          $data->sub_category_id = $request->sub_category_id;
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->meta_description = $request->meta_description;

          if($request->usages != null) $data->usages = implode(', ', $request->usages);
          if($request->materials != null) $data->materials = implode(', ', $request->materials);
          if($request->hidden_data != null)$data->hidden_data = implode(', ', $request->hidden_data);

          $data->code = $request->code;
          $data->barcode = $request->barcode; 
          $data->brand = $request->brand;
          $data->model = $request->model;
          $data->particular = $request->particular;
          $data->warranty = $request->warranty;
          
          $data->active = $request->active;
          $data->featured = $request->featured;
          $data->is_set = $request->is_set;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }

    public function addStock($id)
      {
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catID')
        ->where('products.id',$id)
        ->first();
        return view('admin.stock_add', ['data'=>$data]);
      }

      public function productStock($product_id)
      {
          $data = DB::table('products')
                  ->where('id',$product_id)
                  ->first();      
          return view('admin.product_stock', ['data' => $data]);
      }
      public function productStockDetails($product_id)
      {
        $product = DB::table('products')
        ->where('id', $product_id)
        ->first();      
        $product_name = $product->name;

        $data = DB::table('product_stocks')
        ->where('product_id', $product_id)
        ->where('store_id', session('client_id'))   
        ->orderBy('id', 'DESC')
        ->get();        

        return view('admin.product_stock_details', ['data' => $data, 'product_name'=>$product_name]);
      }

      public function update_opening_stock(Request $request)
      {       
          //delete past records
          DB::table('product_stocks')
          ->where('product_id',$request->product_id)
          ->where('type', 'OB')
          ->delete();

          //dd($request->id);          
             
          $total_qty = DB::table('product_stocks')
            ->where('product_id', $request->id)
            ->orderBy('id', 'DESC')
            ->first();
            if($total_qty){
              $total_qty = $total_qty->total_qty;
            }else{
              $total_qty = 0;
            }
            
            $store_qty = DB::table('product_stocks')
            ->where('product_id', $request->product_id)
            ->where('store_id', $request->store_id)
            ->orderBy('id', 'DESC')
            ->first();
            if($store_qty){
              $store_qty = $store_qty->store_qty;
            }else{
              $store_qty = 0;
            }
          


          $unload=array();
          $unload['product_id'] = $request->product_id;
          $unload['store_id'] = $request->store_id;
          $unload['qty'] = $request->qty;
          $unload['store_qty'] = $store_qty + $request->qty;
          $unload['total_qty'] = $total_qty + $request->qty;
          $unload['type'] = 'OB';          
          $unload['client_id'] = session('client_id');          
          DB::table('product_stocks')->insert($unload); 

          if($unload){
            return response()->json(['success'=>true,'data'=>$unload['total_qty']]);
          }else{
            return response()->json(['success'=>false,'data'=>'404']);
          }
    
        
        return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
      }
      


    public function updatePrice(Request $request)
    {
      $price = $request->price;
      foreach($request->product_id as $product){
          $data = Product::find($product);
          $data->price = $price;
          $data->save(); 
      }
      return redirect('/products')->with(session()->flash('alert-success', 'Price has been updated successfully.'));
    }
    public function destroy($id)
    {
      $order = DB::table('order_details')
      ->where('product_id', $id)
      ->first();
      if($order){
        return redirect()->back()->with(session()->flash('alert-warning', 'Item has order records. You should not delete it.'));
      }
      $product = Product::find($id);
      //delete product image
      if($product->images != null){
        $product_images = explode('|', $product->images);      
        foreach($product_images as $image){
          if (file_exists("images/".$image)) { 
              unlink("images/".$image);
          }
        }
      }
      
      //delete thumbnail
      
      if ($product->thumbnail != null && file_exists("storage/app/public/".$product->thumbnail)) { 
          unlink("storage/app/public/".$product->thumbnail);
      }      
      DB::table('products')
      ->where('id',$id)
      ->delete();

      return redirect()->back()->with(session()->flash('alert-success', 'Item has been deleted successfully.'));
    }


     
  
    public function shop(Request $request)
    {
      $settings = DB::table('settings')->where('id', 1)->first();
      if($settings->active!='on'){return view('under_construction');} 
      
      $categories = $this->getCategories();
      // $data = DB::table('products') 
      // ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      // ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
      // ->where('products.active', 'on')
      // ->where('products.freebee', null)
      // ->get(); 

      //$data = Product::paginate(30);
      $data = Product::withCount('popularity')
                      ->where('active','on')
                      ->where('is_set',null)
                      ->where('product_type', 'Product')
                      ->orderBy('created_at', 'desc')
                      ->paginate(30);
      $total = Product::count();
      if($request->ajax()){
        $query = Product::query()
        ->with('category')->where('product_type', 'Product')->orderBy('created_at', 'desc');
        // $query->where('active','on')->where('freebee',null)->where('is_set',null);
        if($request->has('filter')){ 
          $form_data = [];
          parse_str($request->filter, $form_data);
          if(array_key_exists("size", $form_data) && count($form_data["size"])>0){
            // foreach($form_data->size as $key => $size){
            //   if($key==0){
            //     $query->where('size',$size);
            //   }else{
            //     $query->orWhere('size',$size);
            //   }
            // }
          }
          if(array_key_exists("brand", $form_data) && count($form_data["brand"])>0){
            foreach($form_data["brand"] as $key => $brand){
              if($key==0){
                $query->where('brand',$brand);
              }else{
                $query->orWhere('brand',$brand);
              }
            }
          }

          if(array_key_exists("materials", $form_data) && count($form_data["materials"])>0){
            foreach($form_data["materials"] as $key => $materials){
              if($key==0){
                $query->where('materials',$materials);
              }else{
                $query->orWhere('materials',$materials);
              }
            }
          }
          if(array_key_exists("style", $form_data) && count($form_data["style"])>0){
            foreach($form_data["style"] as $key => $style){
              if($key==0){
                $query->where('style',$style);
              }else{
                $query->orWhere('style',$style);
              }
            }
          } 

          if(array_key_exists("usages", $form_data) && count($form_data["usages"])>0){
            foreach($form_data["usages"] as $key => $usages){
              if($key==0){
                $query->where('usages',$usages);
              }else{
                $query->orWhere('usages',$usages);
              }
            }
          }
          
          return response()->json(["total"=>$query->count(),"items"=>json_encode($query->paginate(30)),"form_data"=>$form_data]);
        }
        return response()->json(json_encode($data));
      }
      else{
        return view('shop', ['data'=>$data, 'menu'=>'shop','categories'=>$categories, 'total'=>$total])->with('warning', 'Please add product into cart to proceed!');
      }
    }  

    public function shopCategory(Request $request, $slug)
    {
     
      // showing category slug in the url. replaced id with slug in function parameter. 
      $category = DB::table('product_categories')     
      ->where('slug', $slug)
      ->first();

      if($category == null){
        return redirect('/404')->with(session()->flash('alert-warning', 'Category not found!'));
      }  

      $id = $category->id;

      $data = Product::where("category_id",$id)
                        ->orWhere("sub_category_id",$id)
                        ->where('active','on')
                        ->where('is_set',null)
                        ->where('product_type', 'Product')
                        ->with('category','sub_category');
      $category_name = ProductCategory::where('id',$id)->pluck('name')[0];
      $total = $data->count();
      $data = $data->paginate(30);
      if($request->ajax()){
        $query = Product::query()->with('category');
        $query->where('category_id',$id)->where('active','on')->where('is_set',null)->orWhere('sub_category_id',$id);
        if($request->has('filter')){
          $form_data = [];
          parse_str($request->filter, $form_data);

          if(array_key_exists("size", $form_data) && count($form_data["size"])>0){
            // foreach($form_data->size as $key => $size){
            //   if($key==0){
            //     $query->where('size',$size);
            //   }else{
            //     $query->orWhere('size',$size);
            //   }
            // }
          }
          if(array_key_exists("brand", $form_data) && count($form_data["brand"])>0){
            foreach($form_data["brand"] as $key => $brand){
              if($key==0){
                $query->where('brand',$brand);
              }else{
                $query->orWhere('brand',$brand);
              }
            }
          }

          if(array_key_exists("materials", $form_data) && count($form_data["materials"])>0){
            foreach($form_data["materials"] as $key => $materials){
              if($key==0){
                $query->where('materials',$materials);
              }else{
                $query->orWhere('materials',$materials);
              }
            }
          }
          if(array_key_exists("style", $form_data) && count($form_data["style"])>0){
            foreach($form_data["style"] as $key => $style){
              if($key==0){
                $query->where('style',$style);
              }else{
                $query->orWhere('style',$style);
              }
            }
          }

          if(array_key_exists("usages", $form_data) && count($form_data["usages"])>0){
            foreach($form_data["usages"] as $key => $usages){
              if($key==0){
                $query->where('usages',$usages);
              }else{
                $query->orWhere('usages',$usages);
              }
            }
          }
          
          return response()->json(["total"=>$query->count(),"items"=>json_encode($query->paginate(30)),"form_data"=>$form_data]);
        }
        return response()->json(json_encode($data));
      }
      else{

        return view('shop_category', ['data'=>$data, 'menu'=>'shop','total'=>$total,'category'=>$category_name]);
      }
    }
    public function freebies()
    {
      $data = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')  
      ->where('products.active', 'on')
      ->where('products.is_set', null)
      ->where('products.freebee', 'on')
      ->get(); 
      $total = $data->count();
      //dd($total);
      return view('freebies', ['data'=>$data, 'menu'=>'freebies']);
    }
    public function shopSubCategory($id)
    {
      $data = DB::table('products')
      ->join('product_categories', 'products.sub_category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId')        
      ->where('products.sub_category_id', $id)
      ->where('products.active', 'on')
      ->where('products.is_set', null)
      ->where('products.product_type', 'Product')
      ->get(); 
      $total = $data->count();
      //dd($total);

      return view('shop_category', ['data'=>$data, 'menu'=>'shop']);
    }
     
    public function mobileSearch(Request $request){
      $data = DB::table('products')
      ->where('active', 'on')
      ->where('name', 'like', '%' . $request->search . '%')            
      ->orWhere('materials', 'like', '%' . $request->search . '%')
      ->orWhere('style', 'like', '%' . $request->search . '%')
      ->orWhere('usages', 'like', '%' . $request->search . '%')
      ->orWhere('brand', 'like', '%' . $request->search . '%')
      ->orWhere('hidden_data', 'like', '%' . $request->search . '%')            
      ->get();
      $row_count = $data->count();
      //return $row_count; 
      
      if ($row_count>0) {
        return view('search_result', ['data' => $data, 'total' => $row_count, 'searchItem' => $request->search]);
      }
  }
  public function search_product(Request $request){

    $output='';  
    $data = DB::table('products')
        ->where('active', 'on')
        ->where('name', 'like', '%' . $request->search . '%')            
        ->orWhere('materials', 'like', '%' . $request->search . '%')
        ->orWhere('style', 'like', '%' . $request->search . '%')
        ->orWhere('usages', 'like', '%' . $request->search . '%')
        ->orWhere('brand', 'like', '%' . $request->search . '%')
        ->orWhere('particular', 'like', '%' . $request->search . '%')
        ->orWhere('hidden_data', 'like', '%' . $request->search . '%')            
        ->get();
    $row_count = $data->count();
    //return $row_count; 
    
    if ($row_count>0) {
      foreach($data as $item)
      {
      if($images = $item->images) $images = explode('|', $images);
      $output .= '<div class="col-6 col-md-3 col-lg-3 col-xl-2 product-column search_item">

      <div class="product product-2 search_item">
<figure class="product-media">'; 
        
        if($item->thumbnail != null ){             
          $output .= '<a href="/product/'.$item->slug.'" target="_blank"><img src="'.asset('storage/app/public/').'/'.$item->thumbnail.'" class="search_item"></a>'; 
        }elseif($images = $item->images){
          $output .= '<a href="/product/'.$item->slug.'" target="_blank"><img src="'.asset('images').'/'.$images[0].'" class="search_item"></a>'; 
        }else{
          $output .= '<a href="/product/'.$item->slug.'" target="_blank"><img src="'.asset('frontend/images/no-image.png').'" class="search_item"></a>'; 
        }

        $output .= '<div class="product-action-vertical">';

        if(session('user_id')){
          $output .= '<a href="javascript:void(0)" class="btn-product-icon btn-wishlist btn-expandable addToWishlist" title="Wishlist" data-id="'.$item->id.'">
          <span id="atw'.$item->id.'">Add to Wishlist</span></a>';      
        }else{
          $output .= '<a href="/login" class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist">
          <span>Add to Wishlist</span></a>';
        }
            
    $output .= '</div>

    <div class="product-action product-action-dark">';

        if(session('cart')){               
                $cart = session()->get('cart');
                if(isset($cart[$item->id])) {
                $class= "cart";
                }
                else{
                $class="";
                }                
              }
        else{
              $class = "";
         }


         $output .= '<a href="javascript:void(0)" id="atc'.$item->id.'" class="btn-product btn-cart addToCart '.$class.'" data-id="'.$item->id.'"><span>Add to cart</span></a>';        
         //$output .= '<a href="quick-view/'.$item->id.'" class="btn-product btn-quickview" title="Quick view"><span>Quick view</span></a>';
          $output .= '</div>       
              </figure>
              <div class="product-body search_item">
                  <div class="product-cat"></div>        
                  <h3 class="product-title"><a href="/product/'.$item->slug.'" target="_blank">'.$item->name.'</a></h3>     
                  <div class="product-price">$'.$item->price.'</div>                   
              </div>
            
          </div>
          </div>';         
            }
      echo $output;


    }
    else
    {
      //echo "<h3 style=\"color:red; text-align:center;margin-top:5px;\">No item is found with this keyword!</h3>";
      echo "not found";
    }

  }

      public function find_subcategory(Request $request){
        $sub_categories = DB::table('product_categories')
            ->where('parent_id', $request->category_id)
            ->get();
        $total = $sub_categories->count();
        // dd($sub_categories);
        return response()->json(['success'=>true,'data'=>$sub_categories, 'total'=>$total]);
        
    }
    
    public function find_product_id(Request $request){
        $data = DB::table('products')
            ->where('name', $request->product_name)
            ->get();
        $total = $data->count();
        // dd($sub_categories);
        return response()->json(['success'=>true,'data'=>$data, 'total'=>$total]);        
    }

    
     

}
