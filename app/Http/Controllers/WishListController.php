<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;
use Auth;
use DB;

class WishListController extends Controller
{
    public function addToWishlist(Request $request)
      {
          $product_id = $request->id;   

          $data_available = DB::table('wish_lists')    
                ->where('product_id', $product_id)
                ->where('user_id', session('user_id'))
                ->first(); 

        if($data_available != null)
        return response()->json(['success'=>false,'data'=>'Item is availabe in wishlist.', 'product_id'=>$product_id]);
        

          $data = new WishList;
          $data->product_id = $product_id;
          $data->user_id = session('user_id');
          $data->status = 'Added';
          $data->save();
          return response()->json(['success'=>true,'data'=>'Item has been added in wishlist.', 'product_id'=>$product_id]);
  
      }

    public function myWishlist()
    {
        //$data = WishList::where('user_id',session('user_id'))->get(); 
       
        $data = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->join('wish_lists', 'products.id', '=', 'wish_lists.product_id')
        ->select('products.*', 'product_categories.name as catName', 'product_categories.id as catId', 'product_categories.slug as catSlug')        
        ->where('products.active', 'on')
        ->where('wish_lists.user_id', session('user_id'))
        ->get(); 
        //dd($data);
        return view('wish_list', ['data'=>$data]); 
    }

   
    public function destroy(Request $request)
    {
        $product_id = $request->product_id;
        $data = WishList::where('product_id', $product_id)
                ->where('user_id', session('user_id'))
                ->first();
        $data->delete();
        
        return response()->json(['success'=>true,'product_id'=>$product_id]);
        
    }
}
