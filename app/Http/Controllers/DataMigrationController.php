<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DataLookup;
use App\Models\OrderDetail;
use App\Models\BankAccount;
use App\Models\CustomerAccount;
use App\Models\ProductStock;
use App\Models\Company;

use Illuminate\Support\Str;
use App\Traits\CategoryTrait;
use App\Traits\DebitCreditTrait;
use App\Models\ProductCategory;
use App\Models\Payment; 
use DB;


class DataMigrationController extends Controller
{
    use CategoryTrait;
    use DebitCreditTrait;

    public function  updateDate(){
      $orders = DB::table('orders')
      ->where('client_id', session('client_id'))
      ->get(); 
      //dd($orders);

      $i=0;
      foreach ($orders as $order){
        $i++;
          //payment table
          // $payment = Payment::where('order_id', $order->id)->first();
          // if($payment != null){
          //   $data = Payment::where('order_id', $order->id)->first();            
          //   $data->created_at = $order->created_at; 
          //   $data->update();   
          // }  
          // bank acc table
          $payment = BankAccount::where('invoice_id', $order->id)->first();
          if($payment != null){
            $data = BankAccount::where('invoice_id', $order->id)->first();            
            $data->created_at = $order->created_at; 
            $data->update();   
          }  
      }
    }
    public function  updateObDate(){
      $ob_date = "2023-01-01 10:00:00";
        
      $BankAccount = BankAccount::where('type', 'OB')->where('client_id', session('client_id'))->get();  
      foreach ($BankAccount as $item){
        $data = BankAccount::where('id', $item->id)->first();  
        $data->created_at = $ob_date; 
        $data->update();  
      }  

     $ProductStock = ProductStock::where('type', 'OB')->where('client_id', session('client_id'))->get();  
      foreach ($ProductStock as $item){
        $data = ProductStock::where('id', $item->id)->first();  
        $data->created_at = $ob_date; 
        $data->update();  
      }            
     
    }


    public function  updateClientId(){
      $ba = DB::table('customer_accounts')
      ->orderBy('id', 'asc')
      ->get(); 
      
      $i=0;
      foreach ($ba as $item){
          $i++;
          $user = DB::table('users')
          ->where('id', $item->created_by)
          ->first(); 

          $client_id = $user->client_id;

          $data = CustomerAccount::where('id', $item->id)->first();  
          $data->client_id = $client_id; 
          $data->update();   
      }
      dd($i);
    }

    public function  updateProfitUnit(){
      $order_details = DB::table('order_details')
      ->where('tp', null)
      ->where('client_id', session('client_id'))
      ->orderBy('id', 'asc')
      ->get(); 

      $i=0;
      foreach ($order_details as $order_detail){
        $i++;
          $product = Product::where('id', $order_detail->product_id)->first();
          if($order != null){
            $data = OrderDetail::where('id', $order_detail->id)->first();  
            $data->tp = $product->tp; 
            $data->profit_unit = $order_detail->price - $product->tp; 
            $data->update();   
          }  
      }
      dd($i);
    } 
    
    public function  update_client_id_of_order_details(){
      $order_details = DB::table('order_details')
      ->orderBy('id', 'asc')
      ->get(); 

      $i=0;
      foreach ($order_details as $order_detail){
        $i++;
          $order = Order::where('id', $order_detail->order_id)->first();
          if($order != null){
            $data = OrderDetail::where('id', $order_detail->id)->first();  
            $data->client_id = $order->client_id; 
            $data->update();   
          }  
      }
      dd($i);
    }

    public function insertProductAccessories()
    {
      $products = Product::where('client_id', session('client_id'))->where('active', 'on')->get();
      foreach ($products as $company) {
        
          $data = new Product;
          $data->name = 'Bottle - '.$company->name;   

          //dd($data->name);    
          $data->slug = preg_replace('/\s+/u', '-', trim($data->name));
          $data->price = 10;
          $data->msrp = 0;
          $data->category_id = 1922;      
          $data->sub_category_id = '';        
          $data->brand = '';
          $data->measurement_unit = 'Pcs';
          $data->client_id = session('client_id');
          $data->created_by = session('user_id');
          $data->updated_by = '';
          $data->save(); 
      }
      
    }

    
    public function insertProduct()
    {
      $companes = Company::where('client_id', session('client_id'))->where('active', 'on')->get();
      foreach ($companes as $company) {
        $models = DataLookup::where('client_id', session('client_id'))->where('data_type', 'Model')->get();
        foreach ($models as $model) {
          $data = new Product;
          $data->name = 'Besin '.$company->title.' - '.$model->title;      
          //dd($data->name);    
          $data->slug = preg_replace('/\s+/u', '-', trim($data->name));
          $data->price = 0;
          $data->msrp = 0;
          $data->category_id = 1857;      
          $data->sub_category_id = '';        
          $data->brand = $company->title;
          $data->model = $model->title;
          $data->measurement_unit = 'pcs';
          $data->client_id = session('client_id');
          $data->created_by = session('user_id');
          $data->updated_by = '';
          $data->save(); 
        }
      }
      
    }
    
      public function g_inv_id()
    {    
      for ($i=1; $i < 7; $i++) { 
        $order = DB::table('orders')
        ->where('client_id', $i)
        ->orderBy('id', 'ASC')
        ->get();
        $inv_id = 0;
        
  
        foreach ($order as $item) {    
          $inv_id = $inv_id+1;      
          $data = Order::find($item->id);
          $data->inv_id = $inv_id;
          $data->save();         
          
        }     
      }
     
    }
    
    public function generateCat()
    {    
      //dd('hi'); 
        //sn 119-264 ab   428-436  b
      for ($i=300; $i < 879; $i++) { 
        $product = ProductCategory::find($i)->where('client_id', 4);
        
        $data = ProductCategory::find($i);
        $data->name = $data->name. ' (A)';         
        $data->save();    
        //dd($data); 
      }
    }
    public function g_data_lookup()
    {  
   

      for ($i=17; $i < 29; $i++) { 
        $product = DataLookup::find($i);
        
        // new data creation
        $new = new DataLookup;
        $new->title = $product->title;
        $new->data_type = $product->data_type;
        $new->client_id = session('client_id');
        $new->created_by = session('user_id');
        $new->updated_by = '';
        $new->save();   
      }
      echo $i. " data inserted";
    } 
    
    public function g_company_acc()
    { 
      $data = DB::table('purchases')
      ->where('client_id', '3')
      ->where('company_id', '!=', null)
      ->get();   

      $i=0;
      foreach ($data as $item) {       
        $this->debitCompanyAc($item->company_id, $item->total_price, $item->id, $expense_id = null);
        $i++;
      }

      echo $i . "data inserted";
    } 

   
    
    public function generateProduct()
    {    
      //dd('hi'); 
        //sn 119-264 ab   428-436  b
      for ($i=400; $i < 540; $i++) { 
        $product = Product::find($i);
        
        $data = Product::find($i);
        $data->name = $data->name. ' (A)';         
        $data->save();    
        //dd($data);   

        // new data creation
        $new = new Product;
        $new->name = $product->name. ' (B)';
        $new->slug = preg_replace('/\s+/u', '-', trim($product->name));
        $new->price = $product->price;
        $new->msrp = $product->msrp;
        $new->category_id = $product->category_id;
        $new->sub_category_id = $product->sub_category_id;  
        $new->code = $product->code;
        $new->brand = $product->brand;
        $new->model = $product->model;
        $new->particular = $product->particular;
        $new->measurement_unit = $product->measurement_unit;
        $new->product_type = $product->product_type;
        $new->active = $product->active;
        $new->featured = $product->featured;
        $new->is_set = $product->is_set;
        $new->client_id = session('client_id');
        $new->created_by = session('user_id');
        $new->updated_by = '';
        $new->save();   
      }
    }
    public function products()
    { 
      // update data for order_details table data        
      
      // $orders = DB::table('orders')
      // ->where('active', 'on')
      // ->get(); 

      // foreach ($orders as $order) {
      //   $od = DB::table('order_details')
      //     ->where('order_id', $order->id)
      //     ->get();
      //     //dd($od);
      //     foreach ($od as $item) {
      //         DB::table('order_details')
      //           ->where('id', $item->id)
      //           ->update(['active' => 'on']);
      //     }
      // }
      
      //$users = User::where('client_id', session('user.client_id'))->get();
      $users = DB::table('users')
      ->select('id')
      ->where('client_id', session('user.client_id'))
      ->get();      
      //dd($users);

      $fetch = DB::table('products')
      ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
      ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId') 
      ->where('products.client_id', session('client_id')) //those whose client_id = session('client_id')
      ->orderby('products.id', 'desc')
      ->get();        
      
      $data=view('admin.products')
      ->with('data',$fetch);

      return view('admin.master')
      ->with('main_content',$data);
      } 

    public function create()
    {        
      $last_item = DB::table('products')
      ->orderBy('id', 'DESC')
      ->first();        
      return view('admin.product_add', ['last_item' => $last_item]);
    }
    public function create2()
    {         
      $last_item = DB::table('products')
      ->orderBy('id', 'DESC')
      ->first();        
      return view('admin.product_add2', ['last_item' => $last_item]);
    }

    public function createService()
    {        
      $last_item = DB::table('products')
      ->orderBy('id', 'DESC')
      ->first();        
      return view('admin.service_add', ['last_item' => $last_item]);
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
        $data->slug = preg_replace('/\s+/u', '-', trim($request->name));
        $data->price = $request->price;
        $data->msrp = $request->msrp;

        //if($request->sub_category_id != null){
          //$data->category_id = $request->sub_category_id;
        //}else{
        $data->category_id = $request->category_id;
        //}        
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
        ->where('products.id',$id)
        ->first();
        return view('admin.product_edit', ['data'=>$data]);
      }
      public function editService($id)
      {
       
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catID')
        ->where('products.id',$id)
        ->first();
        return view('admin.service_edit', ['data'=>$data]);
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
