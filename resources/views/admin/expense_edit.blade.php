
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update expense
      </h1> 
      

      <a href="{{URL::to('add-expense')}}" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
        <i class="fa fa-plus mr-1"></i>Add <span class="d-sm-none d-md-inline">New</span> Entry
      </a>

      <a href="expenses"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> expenses
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_expense" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expense Particular</label>
                        <input type="text" name="title" class="form-control" id="" value="{{$data->title}}">
                      </div>  
                    </div>     
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expense Type</label>
                        <select class="form-control select2-single" name="expense_type" id="expenseType" required>  
                          <option value="{{$data->expense_type}}">{{$data->expense_type}}</option>  
                            @include('admin._expense_type')
                        </select>
                      </div>      
                    </div>                         
                  </div>

                  <div class="row  @if ($data->expense_type == 'Product Purchase' || $data->expense_type == 'Advance Payment') @else d-none @endif" id="companyData">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Product Name</label>                    
                            <select class="form-control select2-single" name="product_id" id="product_id" style="display: block; width:100%">  
                              
                                @php
                                $product = DB::table('products')
                                    ->where('id', $data->product_id)
                                    ->first(); 
                                @endphp                            
                                
                                 @if($product)
                                 <option value="{{$product->id}}">{{$product->name}}</option> 
                                 @endif

                                 <?php
                                 $products = DB::table('products')
                                    ->where('client_id', session('client_id'))
                                    ->where('active', 'on')
                                    ->orderBy('name','asc')
                                    ->get();
                                 
                                 ?>
                               
                                @foreach($products as $item) 
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach  
                            </select>
                      </div>     
                    </div>
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Company Name</label>
                        <select class="form-control select2-single" name="company_id" style="display: block; width:100%">  
                          @php
                          $company = DB::table('companies')
                           ->where('id', $data->company_id)
                           ->first(); 
                          @endphp                            
                          
                           @if ($company)
                           <option value="{{$company->id}}">{{$company->title}}</option> 
                           @endif
             
                          <?php                            
                             $companies=DB::table('companies')
                             ->where('active', 'on')
                             ->where('client_id', session('client_id'))
                             ->orderBy('title','asc')
                             ->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>        
                    <div class="col-md-6" id="purchaseVoucher" style="@if($data->expense_type == 'Advance Payment') display: none @endif">
                      <div class="form-group">
                        <label for="">Purchase Voucher</label>
                        <select class="form-control ss" name="purchase_id">  
                          @php
                          $purchase = DB::table('purchases')
                           ->where('id', $data->company_id)
                           ->first(); 
                          @endphp                            
                          
                           @if ($purchase)
                           <option value="{{$purchase->id}}">{{$purchase->title}}</option> 
                           @endif                      
                          <?php                            
                             $purchases = DB::table('purchases')
                                      ->where('client_id', session('client_id'))
                                      ->where('active', 'on')
                                      ->orderBy('title','asc')
                                      ->get();
                             ?>
                            @foreach($purchases as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>     
                  </div>

                  <div class="row  @if ($data->expense_type == 'Ex Expense') @else d-none @endif" id="partsData">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Ex No</label>                    
                            <select class="form-control select2-single" name="equipement_id" id="equipement_id" style="display: block; width:100%">  
                              
                                @php
                                $product = DB::table('products')
                                 ->where('id', $data->product_id)
                                 ->first(); 
                                @endphp                            
                                
                                 @if($product)
                                 <option value="{{$product->id}}">{{$product->name}}</option> 
                                 @endif

                                 <?php
                                 $products = DB::table('products')
                                 ->where('product_type', 'service')
                                 ->where('active', 'on')
                                 ->where('client_id', session('client_id'))
                                 ->orderBy('name','asc')
                                 ->get();                                 
                                 ?>
                               
                                @foreach($products as $item) 
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach  
                            </select>
                      </div>     
                    </div>                     
                  </div>
                        
                 
                        

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expensed By</label>                    
                        <input type="text" name="expensed_by" class="form-control" id="amount" required  value="{{$data->expensed_by}}">
                      </div>     
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" name="amount" class="form-control" id="amount" required  value="{{$data->amount}}">
                      </div>  
                    </div>
                  </div> 
                

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Payment Method</label>
                        <select class="form-control ss" name="payment_method" id="payment_method">  
                          <option value="{{$data->payment_method}}">{{$data->payment_method}}</option>  
                          <option value="Cash">Cash</option> 
                          <option value="Bank">Bank</option>   
                          <option value="Due">Due</option>  
                          {{-- <option value="Check">Check</option>  --}}
                           
                        </select>
                      </div>      
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                        value="{{$data->date}}">
                      </div> 
                    </div>            
                  </div>
                  
                  <div class="row" id="dealer">                     
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Voucher/Bank Acc/Bkash/Nagad No</label>
                        <input type="text" name="boucher_no" class="form-control" id=""  value="{{$data->boucher_no}}">
                      </div>      
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Reference/Bank name </label>
                        <input type="text" name="reference" class="form-control" id=""  value="{{$data->reference}}">
                      </div>      
                    </div>                                                
                  </div>   
                             

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote1" name="description" class="form-control" rows="3">{{$data->description}}</textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="1">{{$data->short_description}}</textarea>  
                  </div>
                 

              
                  
                      <div class="form-group">
                        <label for="">Image: </label>
                        <input type="hidden" name="hidden_image" value="{{$data->image}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        @if ($data->image!=null)
                          <img src="{{ URL::asset('storage/app/public/'.$data->image.'') }}" id="previousImage" height="100px" alt="">                            
                        @else 
                          <img src="{{ URL::asset('storage/app/public/noimage.png') }}" id="previousImage" height="100px" alt="">
                        @endif
    
                        <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                        <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
                      </div>
    
                      <div class="form-group">                    
                        <label class="form-check-label" for="">
                         Active
                        </label>
                        <input type="checkbox" name="active" @if($data->active == 'on') checked
                        @endif class="form-check-input" id="">
                      </div>
                      <br>
                      <input type="hidden" name="id" value="{{$data->id}}">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{URL::to('expenses')}}" class="btn btn-default">Cancel</a>
                      
                    </form>
                
             </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 

  <script>
    $(document).ready(function() {  
      $(document).on('change', '.stock_type', function(){  
          //var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
          
          var storeType = $(this).val();
          //console.log(row_id);
          $.ajax({
            url: "find_store",
            data: {
              _token: '{{csrf_token()}}',
              storeType: storeType
            },
            type: 'POST',
            success: function (response) {
                  if(response.total>0){
                      $('#storeID').empty();
                      $('#storeID').focus;
                      $('#storeID').append('<option value="">-- Select one --</option>'); 
                      $.each(response.data, function(key, value){
                          $('select[id="storeID"]').append('<option value="'+ value.id +'">' + value.title+ '</option>');
                      });
                  }else{
                    $('#storeID').empty();
                  }       
            }
          });
         
      });  

      $("#unitPrice").change(function () {       
        var unitPrice = $(this).val();
        console.log(unitPrice);
        var new_amount = $('#quantity').val() * unitPrice;
        $("#totalPrice").val(new_amount);
      });
      $("#quantity").change(function () {       
        var quantity = $(this).val();
        console.log(quantity);
        var new_amount = $('#unitPrice').val() * quantity;
        $("#totalPrice").val(new_amount);
      });

      $(document).on('change', '#expenseType', function () {      
        console.log('hi'); 
        var type = $(this).val();
        if(type == 'Product Purchase'){
          $("#companyData").show();
          $("#purchaseVoucher").show();
          $("#partsData").hide();
        }
        else if(type == 'Ex Expense'){
          $("#partsData").show();
          $("#companyData").hide();
          $("#purchaseVoucher").hide();
        }
        else if(type == 'Advance Payment'){
          $("#companyData").show();
          $("#purchaseVoucher").hide();
          $("#partsData").hide();
        }
        else{
          $("#companyData").hide();
          $("#purchaseVoucher").hide();
          $("#partsData").hide();
        }       
      });

    });
  </script>
@endsection