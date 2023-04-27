<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;


class CollectionController extends Controller
{
   
  
    public function shop()
    {
      $data = DB::table('products')  
      ->where('active', 'on')
      ->where('product_type', 'collection')
      ->get(); 

      return view('collections', ['data'=>$data]);
    }

    public function index()
    {
      //$data = Product::orderBy('id', 'desc')->get();
      $data = DB::table('products')  
        ->where('active', 'on')
        ->where('product_type', 'collection')
        ->get(); 

      return view('admin.collections', ['data'=>$data]);  
    }

    public function show($slug)
    {      
        $fetch = Product::where('slug', $slug)->first();          
        //dd($fetch);
        // $data = new Product;
        // $data->hit_count = $fetch->hit_count + 1;        
        // $data->update();      
        return view('collection', ['item' => $fetch]);       
    }  
   
  

      public function create()
      {        
        $last_item = DB::table('collections')->orderBy('id', 'DESC')->first();
        return view('admin.collection_add', ['last_item' => $last_item]);
      }

      public function store(Request $request)
      {        
        if(is_numeric($request->price) == null){
          return redirect()->back()->with(session()->flash('alert-danger', 'Price should be a number!'));    
        }          

        $input=$request->all();
        $all_images=array();

        if($request->file('productImages') == null){
          return redirect()->back()->with(session()->flash('alert-danger', 'Collection images can not be null.'));    
        }
        if($request->product_id == null){
          return redirect()->back()->with(session()->flash('alert-danger', 'Collection should have multiple products.'));    
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

        
        // // dd($request->file('source_files'));
        // $input=$request->all();
        // $all_images=array();

        // //upload images
        // $removed_images =$request->excludeImages;   
        // $removed_items= explode("*",$removed_images);  

        // if($files=$request->file('productImages')){
        //   foreach($files as $file){
             
        //       $name_original=$file->getClientOriginalName();               
        //       if (in_array($name_original, $removed_items)) {
        //           //echo "Just skip";
        //       }else{
        //         $name = time().rand(100,999).'_'.$name_original;                
        //         $file->move('images',$name);                
        //         $all_images[]=$name;   
        //       }             
        //   }          
        // }      
        // $final_images = implode('|', $all_images);
        // //end upload image    

       
       

        $data = new Product;
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->price = $request->price;  
        
        $data->description = $request->description;
        $data->short_description = $request->short_description;
        $data->meta_description = $request->meta_description;
        
        $data->images = $final_images;  
        
        if($request->file('thumbnail')!= null){
            $data->thumbnail = $request->file('thumbnail')->store('thumbnails');
        } 

        $data->file_formats = '';
        $data->product_type = 'collection';
        $data->product_ids = implode(',', $request->product_id);

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
        ->where('id',$id)
        ->first();
        return view('admin.collection_edit', ['data'=>$data]);
      }

      public function update(Request $request)
      {       
          //dd($request); 
          $input=$request->all();
          $new_images=array();
  
          $hidden_image =$request->hidden_image;   
          $hidden_image_array= explode("|",$hidden_image);
          //print_r($hidden_image_array);
          // echo "<br/>";

          $removed_images =$request->excludeImages;   
          $removed_items= explode("*",$removed_images);

          if($request->file('productImages') == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Collection images can not be null.'));    
          }
    
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
          // dd($final_images);

          $data = Product::find($request->id);
          $data->name = $request->name;
          $data->images = $final_images;

          if($request->file('thumbnail')!= null){
            $data->thumbnail = $request->file('thumbnail')->store('thumbnails');
          }else{
              $data->thumbnail = $request->hidden_thumbnail;
          }


          $data->slug = Str::slug($request->name);
          $data->price = $request->price;
          $data->msrp = $request->msrp;
        
          $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->meta_description = $request->meta_description;
          if($request->product_id == null){
            return redirect()->back()->with(session()->flash('alert-danger', 'Collection should have a product item at least!')); 
          }else{
            $data->product_ids = implode(',', $request->product_id);
          }                
            
          $data->active = $request->active;
          $data->featured = $request->featured;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect('/all-collections')->with(session()->flash('alert-success', 'Data has been updated successfully.'));
      }

   
}
