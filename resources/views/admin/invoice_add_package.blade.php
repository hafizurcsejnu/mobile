<?php
  use App\Models\Setting;
  $settings = Setting::where('client_id', session('client_id'))->first();
?>
@extends('admin.master')
@section('main_content')


<style>
   .payment_method label {
      margin-right: 25px;
    }

  .form-control[readonly] {
    color: #939192;
    background: #f5f5f5;
    cursor: default;
    font-weight: 600;
    color: #000;
  }
  i.fa.fa-trash {
          display: block;
  }
  input.tc {
    text-align: center;
  }
/* input#code_1 {
    padding: 0px 2px;
} */
</style>

<div class="page-content container container-plus">
  <div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
      New Indoor Invoice
    </h1>
    <a href="invoices" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
      <i class="fa fa-list mr-1"></i>
      <span class="d-sm-none d-md-inline">All</span> Invoices
    </a>
  </div>


  <div class="row mt-3">
    <div class="col-12">
      <div class="card dcard">
        <div class="card-body px-1 px-md-3">
          <div role="main" class="main-content">
            <div class="page-content container container-plus">

              <form action="store_invoice" method="post" enctype="multipart/form-data" onsubmit="saveBtn.disabled = true; return true;">
                @csrf

                <div class="row">
                  <div class="col-md-4"> 
                    <div class="form-group">
                      <label for="">customer Name*</label>
                      <select class="select2-single" id="customerId" name="customer_id" style="width: 100%;">
                        <option value="">Select customer</option>
                        <option value="New">New</option>
                        <?php                             
                                  $customers = DB::table('customers')
                                    ->where('client_id', session('client_id'))
                                     ->where('active','on')
                                     ->orderBy('id','desc')
                                     ->get();                                
                                  ?>
                        @foreach ($customers as $item)
                        <option value="{{$item->id}}">{{ucwords($item->title)}}</option>
                        @endforeach
                      </select>

                      <div id="customerNameDiv"></div>

                    </div>
                  </div>
                  <div class="col-md-8">                  
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Age*</label>
                          <input type="text" name="age" required class="form-control" id="age" placeholder="Age">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Gender*</label>
                          <select class="form-control" required name="gender" id="gender">
                            {{-- <option value="">Select Gender</option> --}}
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="3rd Gender">3rd Gender</option>   
                        </select> 
                        </div> 
                      </div>
                    
                               
                    </div>

                    <div class="row"  style="margin-top: -10px!important">
                      <div class="col-md-4">
                        <div class="form-group">
                          {{-- <label for="">Mobile*</label> --}}
                          <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          {{-- <label for="">Address</label> --}}
                          <input type="text" name="address" placeholder="Enter Address" class="form-control" id="address">
                        </div>
                      </div>
                     
                      <div class="col-md-4 d-none">
                        <div class="form-group">
                          <input type="date" name="date" class="form-control" id="date"
                            value="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>          
                    </div>

                  </div>

                     
                </div>


                <div class="row" style="margin-top: 50px">
                  <div class="col-md-4">
                    <label for="">Select Item</label>
                  </div>
                  {{-- <div class="col-md-2">
                    <label for="">Code</label>
                  </div> --}}
                  <div class="col-md-2">
                    <label for="">Qty</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Price</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Total Price</label>
                  </div>
                  {{-- <div class="col-md-2">
                    <label for="">Action</label>
                  </div> --}}
                </div> 
                @php                                           
                    $banks=DB::table('banks')
                      ->orderBy('title','asc')
                      ->get();                                
                                  
                    $products = DB::table('products')
                                 ->where('client_id', session('client_id'))
                                 ->where('active','on')
                                 ->get();   
                    $total_price = 0;   
                @endphp
                @foreach ($products as $key => $item)
                @php
                    $total_price = $total_price + $item->price;
                @endphp
                    <div class="row content" id="row_{{$loop->iteration}}">
                      <div class="col-md-4">
                        <div class="form-group">
                          <select class="form-control select2-single product" name="product_id[]" id="productId_{{$loop->iteration}}"
                          style="width: 100%;"> 
                          <?php                             
                                $products = DB::table('products')
                                  ->where('client_id', session('client_id'))
                                  ->where('active','on')
                                  ->orderBy('name','asc')
                                  ->get();                                
                          ?>
                              
                          <option value="{{$item->id}}">{{$item->name}}</option>
                          @foreach ($products as $item)                        
                          <option value="{{$item->id}}">{{ucwords($item->name)}}</option>
                          @endforeach
                          <option value="N/A">N/A</option>
                        </select>                 
                        </div>
                      </div>
                      {{-- <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="code[]" id="code_1" class="form-control code">
                        </div>
                      </div> --}}
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="qty[]" id="qty{{$loop->iteration}}" class="form-control qty" value="1">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" style="padding: 0px 3px; text-align: center" name="price[]" id="unitPrice{{$loop->iteration}}" class="form-control tc price" value="{{$item->price}}">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="amount[]" readonly class="form-control amount tr" id="amount{{$loop->iteration}}" value="{{$item->price}}">
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <button type="button" id="{{$key + 1}}" class="btn btn-danger form-control btn_remove"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <button class="btn btn-info form-control" id="addRow"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </div>

                @endforeach
                
                <div id="target"></div>


                <div class="row">
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Total Amount:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="total_price" class="form-control tr" id="totalPrice" value="{{$total_price}}">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

                <div class="row" style="background: #fff;  height: 45px;
                padding-top: 4px;margin-top: -10px;margin-bottom: 10px;">
                  <div class="col-md-4">
                    <label for="" style="float: right;">Discount Code:</label>                 
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="coupon_code" placeholder="Enter code" class="form-control" id="coupon_code">
                      <p id="discount_msg" class="text-danger" style="display: none">Invalid discount code</p>
                    </div>
                  </div> <div class="col-md-2">
                    <label for="" style="float: right;">Discount:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="discount_amount" class="form-control tr" id="discount_amount" value="0">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

                <div class="row">
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Net Amount:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="net_amount" class="form-control tr" id="net_amount" value="{{$total_price}}">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group payment_method">
                      <label for="">Payment Method: </label> &nbsp;&nbsp;&nbsp;

                      <input type="radio" checked name="payment_method" class="form-check-input" value="Cash" id="cash">
                      <label class="form-check-label" for="cash">Cash</label> 
                      
                      <input type="radio" name="payment_method" class="form-check-input" value="Bkash" id="bkash">
                      <label class="form-check-label" for="bkash">bKash</label>

                      {{-- <input type="radio" name="payment_method" class="form-check-input" value="Bank" id="bank">
                      <label class="form-check-label" for="bank">Bank</label> --}}

                      <input type="radio" name="payment_method" class="form-check-input" value="Due" id="due">
                      <label class="form-check-label" for="due">Due</label>
                    </div>

                    <div id="bankDetails"></div>

                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Received: <input type="checkbox" class="form-check-input"
                        id="paidBtn" title="Click for full paid."> </label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="paid_amount" class="form-control tr" id="paidAmount" required
                        style="font-weight: 600; color:#000">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <textarea name="note" id="summernote1" class="form-control" placeholder="Remarks:" rows="1"></textarea>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Total Due:  
                      <input type="checkbox" class="form-check-input" id="adjustment" title="Adjust this amount as discount.">
                    </label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">                     
                      <input type="text" readonly name="due_amount" class="form-control tr" id="dueAmount">
                      <p style="display: none; color: red;" id="adjustment_error">Adjustment amount can not be more than 100 Tk.</p>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

              

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group d-none ">
                      <label class="form-check-label" for="draft">
                        Save as Draft
                      </label>
                      <input type="checkbox" name="invoice_type" class="form-check-input" id="draft">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <style>
                      button.btn.btn-primary,
                      button.btn.btn-default {
                        width: 49%;
                      }
                    </style>
                    <input type="hidden" name="inv_type" value="IPD">
                    <button type="submit" class="btn btn-primary" name="saveBtn">Save</button>
                    <button type="button" class="btn btn-default">Cancel</button>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
</div>


<script>   
  $(document).ready(function () {
    let i = '{{$products->count()}}';  
    var j = 0; 
    $(document).on('click', '#addRow', function (event) {
      event.preventDefault();
      //console.log('clicked');  
      i++;
      j = i;

      var html = '<div id="row_' + i + '" class="row content dynamic-added">';

      html +=
        '<div class="col-md-4"><div class="form-group"><select class="select2-single product" id="productId_' + i +'" name="product_id[]" style="width: 100%;"><option value="">Select Item</option>@foreach ($products as $item) <option value="{{$item->id}}">{{$item->name}}</option>@endforeach </select></div> </div>';

      // html += '<div class="col-md-2"><div class="form-group"><input type="text" name="code[]" id="code_' + i +
      //   '" class="form-control code"></div></div>';
        
      html += '<div class="col-md-2"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
        '" class="form-control qty"></div></div>';

      html +=
        '<div class="col-md-2"><div class="form-group"><input type="text" name="price[]" style="padding: 0px 3px; text-align: center"  id="unitPrice' +
        i + '" class="form-control tc price"></div></div>';

      html +=
        '<div class="col-md-2"><div class="form-group"> <input type="text" readonly name="amount[]" class="form-control amount tr" id="amount' +
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
      $("#net_amount").val(sum);
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
          $('#code_' + row_id + '').val(response.data.barcode);
          $('#unitPrice' + row_id + '').val(response.data.price);
          $('#amount' + row_id + '').val(response.data.price);
          updatetotalPrice();
        }
      });

    });  
    
    $(document).on('change', '.code', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var code = $(this).val();
      $.ajax({
        url: "find_code",
        data: {
          _token: '{{csrf_token()}}',
          code: code
        },
        type: 'POST',
        success: function (response) {
          console.log(response.data);
          if(response.data == '404'){
            $('#productId_' + row_id + '').prepend("<option value='' selected='selected'>Select Item</option>");
            $('#qty' + row_id + '').val(null);
            $('#unitPrice' + row_id + '').val(null);
            $('#amount' + row_id + '').val(null);
          }else{
            $('#productId_' + row_id + '').prepend("<option value='"+ response.data.id+ "' selected='selected'>" + response.data.name + "</option>");
            $('#qty' + row_id + '').val(1);
            $('#unitPrice' + row_id + '').val(response.data.price);
            $('#amount' + row_id + '').val(response.data.price);
            updatetotalPrice();
          }
         
        }
      });

    });  

    //change on qty
    $(document).on('change', '.qty', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var qty = $(this).val();
      var new_amount = $('#unitPrice' + row_id + '').val() * qty;
      $('#amount' + row_id + '').val(new_amount);
      updatetotalPrice();
    });

    //change on unit price
    $(document).on('change', '.price', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var price = $(this).val();
      var new_amount = $('#qty' + row_id + '').val() * price;
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
          $("#unitPrice").val(response.data.price);
          $("#amount").val(response.data.price);
          $("#totalPrice").val(response.data.price);
        }
      });
    }); 
    
    //coupon code
    $("#coupon_code").change(function () {
      var coupon_code = $(this).val();
      var total_price = $('#totalPrice').val();
      $.ajax({
        url: "find_discount",
        data: {
          _token: '{{csrf_token()}}',
          coupon_code: coupon_code,
          total_price: total_price
        },
        type: 'POST',
        success: function (response) {
          console.log(response.data);       
          if(response.data != 'Invalid'){
            var discount_amount = response.data;
            $("#discount_amount").val(discount_amount);
            $("#discount_msg").hide();    

            var totalPrice = $("#totalPrice").val();        
            var net_amount = totalPrice - discount_amount;
            $("#net_amount").val(net_amount);
            $("#paidAmount").val(0);

          }else{
            $("#discount_msg").show();
            $("#discount_amount").val(0);
            var totalPrice = $("#totalPrice").val();
            $("#net_amount").val(totalPrice);
            $("#paidAmount").val(0);
          }  
        }
      });
    });

    $("#paidBtn").click(function () {
      var net_amount = $("#net_amount").val();
      if(net_amount > 0){
        $("#paidAmount").val(net_amount);
      }else{
        var totalPrice = $("#totalPrice").val();
        $("#paidAmount").val(totalPrice);
      }    
      $("#dueAmount").val(0);
    });   

    $("#paidAmount").change(function () {
      var totalPrice = $("#totalPrice").val();
      var paidAmount = $("#paidAmount").val();
      var discount_amount = $("#discount_amount").val();
      $("#dueAmount").val(totalPrice - paidAmount - discount_amount);
    });
 

    $(document).on('change', '#customerId', function () {
      console.log('customer');
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
            $("#age").val(response.data.age)
            $("#gender").val(response.data.gender)
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
        var discount_amount = $("#discount_amount").val();
        var net_amount = totalPrice - discount_amount;
        $("#dueAmount").val(net_amount);
      }
 
    }); 
    
    $(document).on('click', '#adjustment', function () {
      if ($('#adjustment').is(':checked')) {   
        var net_amount = parseInt($("#net_amount").val());
        var dueAmount = parseInt($("#dueAmount").val());
        if(dueAmount > 100){
          $('#adjustment_error').css('display', 'block');
          $('#adjustment').prop('checked', false);
        }else{
          $('#adjustment_error').css('display', 'none');
          var discount_amount = parseInt($("#discount_amount").val());
          var final_discount = discount_amount + dueAmount;
          var final_net_amount = net_amount - dueAmount;
          $("#net_amount").val(final_net_amount);
          $("#discount_amount").val(final_discount);
          $("#dueAmount").val(0);
        }
        
      }
    });



  });
</script>

@endsection