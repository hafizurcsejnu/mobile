<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Production;
use App\Models\ProductStock;
use App\Models\ProductionDetail;
use App\Models\CustomerAccount;
use App\Models\Purchase;
use App\Models\Expense;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Setting::where('client_id', session('client_id'))->first();
        return view('admin.settings', ['data'=>$data]); 
    } 
    public function index1()
    {
        $data = Setting::where('client_id', session('client_id'))->first();
        return view('admin.settings1', ['data'=>$data]); 
    }
    public function reset()
    {
        $data = Order::where('client_id', session('client_id'))->delete();
        $data = OrderDetail::where('client_id', session('client_id'))->delete();
        $data = Production::where('client_id', session('client_id'))->delete();
        $data = ProductionDetail::where('client_id', session('client_id'))->delete();
        $data = ProductStock::where('client_id', session('client_id'))->delete();
        
        $data = CustomerAccount::where('client_id', session('client_id'))->delete();
        $data = Purchase::where('client_id', session('client_id'))->delete();
        $data = Expense::where('client_id', session('client_id'))->delete();
        
    }

    public function update(Request $request)
    {       
          $data = Setting::where('client_id', session('user.client_id'))->first();
          $data->title = $request->title;
          $data->sub_title = $request->sub_title;
          $data->product_type = $request->product_type;
        //   $data->description = $request->description;
          $data->short_description = $request->short_description;
          $data->meta_description = $request->meta_description;
          $data->email = $request->email;
          $data->website = $request->website;
          $data->mobile = $request->mobile;
          $data->phone = $request->phone;
          $data->address = $request->address;
          $data->fb_link = $request->fb_link;
          $data->twitter_link = $request->twitter_link;
          $data->linkedin_link = $request->linkedin_link;
          $data->instagram_link = $request->instagram_link;
          $data->pinterest_link = $request->pinterest_link;
          $data->youtube_link = $request->youtube_link;

          if($request->nav_logo_size != null){$data->nav_logo_size = $request->nav_logo_size;}
          if($request->inv_logo_size != null){$data->inv_logo_size = $request->inv_logo_size;}
          if($request->inv_title_size != null){$data->inv_title_size = $request->inv_title_size;}
          if($request->inv_sub_title_size != null){$data->inv_sub_title_size = $request->inv_sub_title_size;}
          if($request->inv_address_size != null){$data->inv_address_size = $request->inv_address_size;}
          if($request->product_ob != null){$data->product_ob = $request->product_ob;}
          if($request->customer_ob != null){$data->customer_ob = $request->customer_ob;}
          if($request->company_ob != null){$data->company_ob = $request->company_ob;}

          
          if($request->file('logo_header')!= null){
              $data->logo_header = $request->file('logo_header')->store('images');
          }else{
              $data->logo_header = $request->hidden_logo_header;
          }

          if($request->file('logo_footer')!= null){
                $data->logo_footer = $request->file('logo_footer')->store('images');
          }else{
                $data->logo_footer = $request->hidden_logo_footer;
          }
         
          if($request->file('favicon')!= null){
                $data->favicon = $request->file('favicon')->store('images');
          }else{
                $data->favicon = $request->hidden_favicon;
          }
           
          $data->active = $request->active;
          $data->updated_by = session('user_id');
          $data->save(); 

          return redirect()->back()->with(session()->flash('alert-success', 'Data has been updated successfully.'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
