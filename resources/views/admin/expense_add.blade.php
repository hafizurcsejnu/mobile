
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        New Expense     
      </h1> 
      <a href="expenses"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Expenses
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_expense" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expense Particular</label>
                        <input type="text" name="title" class="form-control" id=""  placeholder="Enter particular here">
                      </div>  
                    </div>     
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expense Type</label>
                         <select class="form-control select2-single" name="expense_type" id="expenseType" required>  
                            @include('admin._expense_type')
                        </select>
                      </div>      
                    </div>                         
                  </div>

                  <div class="row" id="companyData" style="display: none">                     
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" style="display: block; width:100%">Select Product</label>                    
                            <select class="form-control select2-single" name="product_id" style="display: block; width:100%">  
                              <option value="">-- Select Product --</option> 
                                <?php                            
                                 $products=DB::table('products')
                                 ->where('product_type', 'Product')
                                 ->where('client_id', session('client_id'))
                                 ->where('active', 'on')
                                 ->orderBy('name','asc')
                                 ->get();?>
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
                          <option value="">-- Select Company --</option>                       
                          <?php                            
                             $companies=DB::table('companies')->where('client_id', session('client_id'))->where('active', 'on')->orderBy('title','asc')->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>                           
                    <div class="col-md-6" id="purchaseVoucher" style="display: none">
                      <div class="form-group">
                        <label for="">Purchase Voucher</label>
                        <select class="form-control select2-single" name="purchase_id" style="display: block; width:100%">  
                          <option value="">-- Select Purchase Voucher --</option>                       
                          <?php                            
                             $purchases = DB::table('purchases')
                                      ->where('client_id', session('client_id'))
                                      ->where('active', 'on')
                                      ->orderBy('id','desc')
                                      ->get();
                             ?>
                            @foreach($purchases as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>                                                
                  </div>     
                  <div class="row" id="partsData" style="display: none">                     
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" style="display: block; width:100%">Select Ex No</label>                    
                            <select class="form-control select2-single" name="equipement_id" style="display: block; width:100%">  
                              <option value="">-- Select Ex No --</option> 
                                <?php                            
                                 $products=DB::table('products')
                                 ->where('product_type', 'Service')
                                 ->where('client_id', session('client_id'))
                                 ->where('active', 'on')
                                 ->orderBy('name','asc')
                                 ->get();?>
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
                        <label for="">Amount</label>
                        <input type="text" name="amount" class="form-control" id="amount" required  placeholder="Enter price here">
                      </div>  
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Expensed By</label>                    
                        <input type="text" name="expensed_by" class="form-control" id="amount" required  value="Manager">
                      </div>     
                    </div>
                  </div> 

                 

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Payment Method</label>
                        <select class="form-control ss" name="payment_method" id="paymentMethod">  
                          <option value="Cash">Cash</option> 
                          <option value="Bank">Bank</option>   
                          <option value="MFS">MFS</option>   
                          <option value="Due">Due</option>  
                          {{-- <option value="Check">Check</option>  --}}
                        </select>
                      </div>      
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                        value="<?php echo date('Y-m-d'); ?>">
                      </div> 
                    </div>      

                    <div class="col-md-6" id="bankAccount" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: green; display: block; width:100%">Select Bank Account</label>                    
                        <select class="form-control select2-single" name="bank_id" style="display: block; width:100%">  
                          <option value="">-- Select Bank Account --</option> 
                            <?php                            
                              $banks=DB::table('banks')
                              ->where('client_id', session('client_id'))
                              ->where('banking_type', 'General Banking')
                              ->where('active', 'on')
                              ->orderBy('id','asc')
                              ->get();
                            ?>
                            @foreach($banks as $item) 
                            <option value="{{$item->id}}">{{$item->title}} - {{$item->ac_no}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>
                    
                    <div class="col-md-6" id="MFS" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: rgb(10, 50, 158); display: block; width:100%">Select MFS Account</label>                    
                        <select class="form-control select2-single" name="bank_id_mfs" style="display: block; width:100%">  
                          <option value="">-- Select MFS Account --</option> 
                            <?php                            
                              $mfs = DB::table('banks')
                              ->where('client_id', session('client_id'))
                              ->where('banking_type', 'Mobile Banking')
                              ->where('active', 'on')
                              ->orderBy('id','asc')
                              ->get();
                            ?>
                            @foreach($mfs as $item) 
                            <option value="{{$item->id}}">{{$item->title}} - {{$item->ac_no}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>

                         
                  </div>

                  
                  <div class="row" id="dealer">                     
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Voucher/Bank Acc/Bkash/Nagad No</label>
                        <input type="text" name="boucher_no" class="form-control" id=""  placeholder="Enter boucher number">
                      </div>      
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Reference</label>
                        <input type="text" name="reference" class="form-control" id=""  placeholder="Enter reference name">
                      </div>      
                    </div>                                                
                  </div>   
                                  

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote1" name="description" class="form-control" rows="2"></textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Notes</label>
                    <textarea name="notes" class="form-control" rows="1"></textarea>  
                  </div>                

                  <div class="form-group">
                    <label for="">Image: </label>
                    <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
                    <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />

                    <p class="d-none">NB: Best image resolutions -> [slider: 1200px*500px] [featured: 260px*640px] </p>
                  </div>

                  <div class="form-group">                    
                    <label class="form-check-label" for="exampleCheck1">
                     Active
                    </label>
                    <input type="checkbox" name="active" checked class="form-check-input" id="exampleCheck1">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-default">Cancel</button>
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
        var type = $(this).val();
        if(type == 'Product Purchase'){
          $("#companyData").show();
          $("#purchaseVoucher").show();
          $("#partsData").hide();
        }
        else if(type == 'Ex Expense'){
          $("#partsData").show();
          $("#purchaseVoucher").hide();
          $("#companyData").hide();
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

      $(document).on('change', '#paymentMethod', function () {       
            var payment_method = $(this).val();
            
            if(payment_method == 'Bank'){
                $("#bankAccount").show();
                $("#MFS").hide();
                $("#bankAcc").hide();
            } 
            else if(payment_method == 'MFS'){
                $("#MFS").show();
                $("#bankAccount").hide();
                $("#bankAcc").hide();
            }
            else{
                $("#bankAccount").hide();
                $("#MFS").hide();
                $("#bankAcc").hide();
            }       
        });



    });
  </script>
 
@endsection