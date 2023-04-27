
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        New Production  
      </h1> 
      <a href="productions"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Productions
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_production" method="post" enctype="multipart/form-data">
                  @csrf
                 
                  <div class="row">                     
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">House No / Production Title</label>
                        <input type="text" name="title" required class="form-control" id=""  placeholder="Enter title here">
                      </div>  
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Production Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                        value="<?php echo date('Y-m-d'); ?>">
                      </div>
                    </div>
                  </div> 

               
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">   
                        <label for="">Select Store</label>
                        <select class="form-control store" name="store_id" id="storeID">
                          <?php                            
                             $stores = DB::table('stores')
                             ->where('client_id', session('client_id'))
                             ->where('active', 'on')
                             ->orderBy('title','asc')
                             ->get();
                          ?>
                            @foreach($stores as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div> 
                    </div>     

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Product Quantity in House (Kg)</label>
                        <input type="text" name="raw_qty" class="form-control" id=""  placeholder="">
                      </div>      
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Notes</label>
                        <textarea name="notes" class="form-control" rows="1"></textarea>  
                      </div>  
                    </div>
                  </div>
                           

             

                  <div class="purchase_details mt-5">
                    <h4>Production Details:</h4>
                    <div class="row">
                      <div class="col-md-2">
                        <label for="">Date</label>
                      </div>
                      <div class="col-md-3">
                        <label for="">Select Product</label>
                      </div>
                     
                      <div class="col-md-1">
                        <label for="">Bag Size</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Qty (Bag)</label>
                      </div>
                      {{-- <div class="col-md-1">
                        <label for="">T.C(%)</label>  
                      </div> --}} 
                      <div class="col-md-2">
                        <label for="">Total Qty (Kg)</label>
                      </div> 
                      
                     
                      <div class="col-md-2">
                        <label for="">Action</label>
                      </div>
                    </div>
    
                    <div class="row content" id="row_1">

                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="date" name="date[]" id="date1" class="form-control date">
                        </div>
                      </div> 

                      <div class="col-md-3">
                        <div class="form-group">
                          <select class="select2-single product" required name="product_id[]" id="productId_1"
                            style="width: 100%;">
                            <?php                            
                                  $collection=DB::table('products')
                                     ->where('active','on')
                                     ->where('client_id', session('client_id'))
                                     ->orderBy('name','asc')
                                     ->get();                                
                                  $banks=DB::table('banks')
                                     ->where('client_id', session('client_id'))
                                     ->orderBy('title','asc')
                                     ->get();                                
                                  ?>
                            <option value="">Select Product</option>
                            @foreach ($collection as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            <option value="N/A">N/A</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <input type="text" name="unit_qty[]" id="unitQty1" class="form-control unit_qty">
                        </div>
                      </div>  
                      
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="qty[]" id="qty1" class="form-control qty">
                        </div>
                      </div>
                                       
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="total_qty[]" readonly class="form-control amount tr" id="amount1">
                        </div>
                      </div>                     
                                       
                      <div class="col-md-1">
                        <div class="form-group">
                          <button type="button" class="btn btn-danger form-control"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <button class="btn btn-info form-control" id="addRow"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </div>
    
                    <div id="target"></div>
    
                    <div class="row">
                      <div class="col-md-4"></div>
                      <div class="col-md-4">
                        <label for="" style="float: right;">Total Amount:</label>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" readonly name="total_qty" class="form-control tr" id="totalPrice">
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>

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

    $(document).ready(function () {
      let i = 1;
      var j = 0;
      $(document).on('click', '#addRow', function (event) {
        event.preventDefault();
        //console.log('clicked');  
        i++;
        j = i;
  
        var html = '<div id="row_' + i + '" class="row content dynamic-added">';
  
        html +=
        '<div class="col-md-2"> <div class="form-group"> <input type="date" name="date[]" id="date' +
          i + '" class="form-control date"> </div></div>';
          
        html +=
          '<div class="col-md-3"><div class="form-group"><select class="select2-single form-control product" id="productId_' +
          i +
          '" name="product_id[]" style="width: 100%;"><option value="">Select product</option>@foreach ($collection as $item)<option value="{{$item->id}}">{{$item->name}}</option>@endforeach </select></div> </div>';       
       
        html +=
          '<div class="col-md-1"><div class="form-group"><input type="text" name="unit_qty[]" id="unitQty' +
          i + '" class="form-control unit_qty"></div></div>';  

             
        html += '<div class="col-md-2"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
          '" class="form-control qty"></div></div>';
  
        html +=
          '<div class="col-md-2"><div class="form-group"> <input type="text" readonly name="total_qty[]" class="form-control amount tr" id="amount' +
          i + '" ></div></div>';
  
        html += '<div class="col-md-1"><div class="form-group"><button id="' + i +
          '" type="button" class="btn btn-danger form-control btn_remove"><i class="fa fa-trash"></i></button></div></div>';
  
        html += '</div>';
  
  
        let tb = $("#target").find();
        //console.log(html);
        $("#target").append(html);
        $('#productId_' + i, '#target').select2();

      });
  
      $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row_' + button_id + '').remove();
        updatetotalPrice();
      });
  
      function updatetotalPrice() {
        var sum = 0;
        $(".amount").each(function () {
          sum += +$(this).val();
          console.log(sum);
        });
        $("#totalPrice").val(sum);
      }
  
      $(document).on('change', '.product', function () {
        var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
        //var row_id = $(this).attr('id').split('_').pop(); 
        var productId = $(this).val();
        //console.log(row_id);
        $.ajax({
          url: "find_product",
          data: {
            _token: '{{csrf_token()}}',
            productId: productId
          },
          type: 'POST',
          success: function (response) {
            $('#qty' + row_id + '').val(1);
            $('#unitQty' + row_id + '').val(response.data.bp);
            $('#amount' + row_id + '').val(response.data.bp);
            $('#product_sn' + row_id + '').val(response.data.barcode);
            updatetotalPrice();
          }
        });
  
      });
  
      //change on qty
      $(document).on('change', '.qty', function () {
        var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
        var qty = $(this).val();
        var new_amount = $('#unitQty' + row_id + '').val() * qty;
        $('#amount' + row_id + '').val(new_amount);
        updatetotalPrice();
      });
  
      //change on unit price
      $(document).on('change', '.unit_qty', function () {
        var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
        var unit_qty = $(this).val();
        var new_amount = $('#qty' + row_id + '').val() * unit_qty;
        $('#amount' + row_id + '').val(new_amount);
        updatetotalPrice();
      });
  
  
  
  
      // not needed now
      $("#productId").change(function () {
        var productId = $(this).val();
        $.ajax({
          url: "find_product",
          data: {
            _token: '{{csrf_token()}}',
            productId: productId
          },
          type: 'POST',
          success: function (response) {
            // console.log(response.data);
            $("#qty").val(1);
            $("#unitQty").val(response.data.bp);
            $("#amount").val(response.data.bp);
            $("#totalPrice").val(response.data.bp);
          }
        });
      });
  
      // not needed now
      $("#unitQty").change(function () {
        var unitQty = $(this).val();
        var new_amount = $('#qty').val() * unitQty;
        $("#amount").val(new_amount);
        $("#totalPrice").val(new_amount);
      });
  
      $("#paidBtn").click(function () {
        var totalPrice = $("#totalPrice").val();
        $("#paidAmount").val(totalPrice);
        $("#dueAmount").val(0);
      });   
  
      $("#paidAmount").change(function () {
        var totalPrice = $("#totalPrice").val();
        var paidAmount = $("#paidAmount").val();
        $("#dueAmount").val(totalPrice - paidAmount);
      });
  
  
      $(document).on('change', '#customerId', function () {
        var customerId = $(this).val();
        if (customerId == 'New') {
          var textMore =
            "<input type='text' autofocus class='form-control mb-2 mt-1' placeholder='Enter new customer name' name='customer_name' id='customerName'/>";
          $("#customerNameDiv").append(textMore);
        } else {
          $("input[type='text'][id$='customerName']").remove();
  
          $.ajax({
            url: "find_customer",
            data: {
              _token: '{{csrf_token()}}',
              customerId: customerId
            },
            type: 'POST',
            success: function (response) {
              // console.log(response.data);
              $("#mobile").val(response.data.mobile)
              $("#address").val(response.data.address)
            }
          });
        }
      });
  
      $(document).on('click', '#bank', function () {
        if ($('#bank').is(':checked')) {
          bankDetails =
            '<div id="bank_details"><div class="form-group"><select class="form-control" name="bank_id" style="margin-top: -15px; float:left;margin-bottom:5px; margin-right: 5%"><option value="">Select bank</option>@foreach ($banks as $bank)<option value="{{$bank->id}}">{{$bank->title}}({{$bank->branch}}) - A/C No-{{$bank->ac_no}}</option>@endforeach </select> </div><div class="form-group d-none"> <input type="text" name="branch" placeholder="Branch name" class="form-control" style="width:30%; float:left; margin-bottom:5px"></div></div></div>';
  
          $("#bankDetails").append(bankDetails);
        }
      });
      $(document).on('click', '#cash', function () {
        if ($('#cash').is(':checked')) {
          $("#bank_details").remove();
        }
      });
      $(document).on('click', '#due', function () {
        if ($('#due').is(':checked')) {        
          $("#bank_details").remove();
          
          var totalPrice = $("#totalPrice").val();
          var paidAmount = $("#paidAmount").val(0);
          $("#dueAmount").val(totalPrice);
        }
  
      });
  
  
  
    });
  </script>
  
@endsection