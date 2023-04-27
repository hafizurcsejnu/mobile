<?php
    use App\Models\Setting;
    $settings = Setting::where('client_id', session('user.client_id'))->first();
   
    
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #d3d5d7;
    border-radius: 0px;
    height: 38px;
    padding: 3px;
}

</style>
@include('reports._report_header')
<title>INV Stock</title>


<div style="text-align: center; width: 100%; display: block; margin-top:10px;">
    <span style="font-weight: 600; border: 1px solid #6f6f6f; padding: 5px 30px;">Sell From Stock</span> 
</div>

@php
 
@endphp

<table class="table d-none" style="width: 100%; margin-bottom: 20px;">
    <tbody>
        <tr>
            <td>
                <table class="table top1_left" style="margin: 0;">
                    <tbody>
                        <tr><td>Invoice No</td><td>: <span style="font-weight: 600">INV-0001</span>                        
                        </td></tr>
                        <tr><td>Customer</td><td>: <span style="font-weight: 600">Walking Customer</td></tr>
                        <tr><td>Address</td><td>: Kashinathpur, Pabna</td></tr>
                        <tr><td>Mobile</td><td>: 01710-000000</td></tr>
                        <tr><td>
                           
                        </td></tr>   
                        
                        
                    </tbody>
                </table>          
            </td>
            <td>
                <table class="table top1_right" style="margin: 0;">
                    <tbody>
                        <tr><td>Inv Date</td><td>: <span style="font-weight: 600">{{date("d-m-Y")}} {{date("h:i:sa")}}</span></td></tr>
                        <tr class="d-none"><td>Inv Print</td><td>: {{date("d-m-Y")}} {{date("h:i:sa")}}</td></tr>
                        @php
                        $billed_by = DB::table('users')
                        ->where('id', session('user_id'))
                        ->first();
                        $billed_by = $billed_by->name;
                        @endphp
                        <tr><td>Billed By</td><td>: {{$billed_by}}</td></tr>
                        <tr><td>Payment</td><td>: Paid</td></tr>    
                    </tbody>
                </table>          
            </td>
        </tr>
    </tbody>
</table>


        
<form method="POST" style="margin-top: 50px"  action="{{route('save_product')}}" enctype="multipart/form-data">
    @csrf              
    <div class="row"> 

        <div class="col-md-1"></div>
        <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputPassword1">Select Item</label>
              <select class="form-control ss" style="width: 100%" required name="category_id" id="category_id">
                <option value="">Select Product</option>    
                  <?php                            
                   $categories=DB::table('products')
                   ->where('client_id', session('client_id'))
                   ->orderBy('name','asc')
                   ->get();?>
                  @foreach($categories as $category) 
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach  
              </select>
            </div>
          </div>

      <div class="col-md-2">
        <div class="form-group">
          <label for="">Quantity<span>*</span></label>
          <input type="text" name="qty" class="form-control" id="" required  placeholder="Quantity">
        </div>  
      </div>     
      
      <div class="col-md-2">
        <div class="form-group">
          <label for="">Selling Price<span>*</span></label>
          <input type="text" name="price" required class="form-control"> 
        </div>    
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="">Total Price<span></span></label>
          <input type="text" name="total_price" class="form-control"> 
        </div>    
      </div>   
      <div class="col-md-1"></div> 
     
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <label for="">&nbsp;<span></span></label>
            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button> 
          </div>
    </div>

    

  </form>





<style>
    table.tbl_border, table.tbl_border th, table.tbl_border td {
        border: 1px solid #e5e5e5;
        border-collapse: collapse;
    }                
</style>

       


</div>
</div>

{{-- <div class="invoice_wrapper" style="text-align: center;">
<button type="button" onclick="printDiv('printableArea')" style="width: 200px;cursor: pointer; ">Print </button>

@if ($settings->business_description == 'Titles')
<button> <a href="{{URL::to('delivery-order')}}/" >Delivery Order</a></button>
@endif
<button type="button" class="btn btn-default">Cancel</button>

<button> <a href="{{URL::to('edit-invoice')}}/" title="Update">Update</a></button>
<button> <a href="{{URL::to('invoices')}}" >All Invoices</a></button>
<button> <a href="{{URL::to('add-invoice')}}" >New Invoice</a></button>
</div> --}}


<script>

$(document).ready(function() {
        $('.ss').select2();
    });
</script>

<script src="{{asset('assets/node_modules/select2/dist/js/select2.js')}}"></script>
