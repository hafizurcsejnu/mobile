<?php
  use App\Models\Setting;
  $settings = Setting::where('client_id', session('user.client_id'))->first();
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
input.product_sn{
    padding: 0px 2px;
    text-align: center;
}
.price{
  padding: 0px 3px; text-align: center;
}
</style>
<form action="store_invoice" method="post" enctype="multipart/form-data">
  @csrf
<div class="page-content container container-plus">
  <div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
      New Invoice   
      
      {{-- <select class="form-control" name="invoice_type" style="">
        <option value="">Retail</option>
        <option value="Wholesale">Wholesale</option>       
      </select> --}}
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

             

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group"> 
                      <label for="">Customer*</label>
                      <select class="select2-single" id="customerId" name="customer_id" style="width: 100%;">
                        <option value="">Search customer by name or mobile</option>
                        <option value="New">New</option>
                        <?php                            
                                  $customers=DB::table('customers')
                                     ->where('active','on')
                                     ->where('client_id', session('client_id')) 
                                     ->orderBy('id','desc')
                                     ->get();                                
                                  ?>
                        @foreach ($customers as $item)
                        <option value="{{$item->id}}">{{$item->title}} - {{$item->mobile}}</option>
                        @endforeach
                      </select>

                      <div id="customerNameDiv"></div>

                    </div>

                  </div>
                  <div class="col-md-@if($settings->product_type == 'Service'){{4}} @else{{2}}@endif">
                    <div class="form-group">
                      <label for="">Mobile*</label>
                      <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Address</label>
                      <input type="text" name="address" placeholder="Address details" class="form-control" id="address">
                    </div>
                  </div>
                
                @if ($settings->product_type == 'Service')
                  </div>
                  <div class="row"  style="border-bottom: 1px dotted #ededed; margin-bottom:50px; margin-top: -10px;">
                    <div class="col-md-4">
                      <label for="">{{$settings->additional_1_title}}</label>
                      <div class="form-group">
                        <select class="form-control" name="additional_1">
                          <option selected>Select {{$settings->additional_1_title}}</option>
                            @php
                              $collection=DB::table('data_lookups')
                                ->where('data_type','Service For')
                                ->orderBy('id','asc')
                                ->get();  
                            @endphp   
                            @foreach ($collection as $item)
                              <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="">{{$settings->additional_2_title}}</label>
                      <div class="form-group">
                        <input type="number" name="additional_2" class="form-control" value="1">
                      </div>
                    </div>   
                  @endif               

                  <div class="col-md-@if($settings->product_type == 'Service'){{4}} @else{{2}}@endif">
                    <div class="form-group">
                      <label for="">Invoice Date</label>
                      <input type="date" name="date" class="form-control" id="date"
                        value="<?php echo date('Y-m-d'); ?>">
                    </div>
                  </div>              
                </div>



                <div class="row">
                  <div class="col-md-4">
                    <label for="">Select {{$settings->product_type}}</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Product Serial</label>
                  </div>
                  <div class="col-md-1">
                    <label for="">Qty</label>
                  </div>
                  <div class="col-md-1">
                    <label for="">Price</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Total Price</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Action</label>
                  </div>
                </div>

                <div class="row content" id="row_1">
                  <div class="col-md-4">
                    <div class="form-group">
                      <select class="select2-single product" name="product_id[]" id="productId_1"
                        style="width: 100%;">
                        <?php                            
                              $products=DB::table('products')
                                 ->where('client_id', session('client_id')) 
                                 ->where('active','on')
                                 ->orderBy('name','asc')
                                 ->get();                                
                              $banks=DB::table('banks')
                                 ->where('client_id', session('client_id')) 
                                 ->orderBy('title','asc')
                                 ->get();                                
                              ?>
                            
                        <option value="">Select {{$settings->product_type}}</option>
                        @foreach ($products as $item)
                        @php                       
                            $stock = DB::table('product_stocks')
                              ->where('client_id', session('client_id')) 
                              ->where('product_id', $item->id)
                              ->orderBy('id','DESC')
                              ->first();
                            if($stock){

                            }else{
                              //checking product availability from settings stock_condition
                              if($settings->stock_condition == 'Yes'){
                                continue;
                              }                              
                            }
                        @endphp
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                        <option value="N/A">N/A</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="product_sn[]" id="productSn_1" class="form-control product_sn">
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" name="qty[]" id="qty1" class="form-control qty">
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" name="price[]" id="unitPrice1" class="form-control price">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="amount[]" readonly class="form-control amount tr" id="amount1">
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
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Total Amount:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="total_price" class="form-control tr" id="totalPrice">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>


                {{-- eef2f9 --}}
                <div class="row" style="background: #fff;  height: 45px;
                padding-top: 4px;margin-top: -10px;margin-bottom: 10px;">
                  <div class="col-md-2">

                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Discount Code:</label>                    
                  </div>
                  <div class="col-md-2"> 
                    <div class="form-group">
                      <input type="text" name="coupon_code" class="form-control" id="coupon_code">
                      <p id="discount_msg" class="text-danger" style="display: none">Invalid coupon code</p>
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
                      <input type="text" readonly name="net_amount" class="form-control tr" id="net_amount">
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
                    <label for="" style="float: right;">Deposit: <input type="checkbox" class="form-check-input"
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
                      <textarea name="note" id="summernote1" class="form-control" placeholder="Invoice Notes" rows="1"></textarea>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Total Due:  <input type="checkbox" class="form-check-input"
                      id="adjustment" title="Adjust this amount as discount."></label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="due_amount" class="form-control tr" id="dueAmount">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

              

                <div class="row">
                  <div class="col-md-6">
                   
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4">

                    <br>
                    <br>
                    <br>
                    <style>
                      button.btn.btn-primary,
                      button.btn.btn-default {
                        width: 49%;
                      }
                    </style>
                    <button type="submit" class="btn btn-primary">Save</button>
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
    let i = 1;
    var j = 0;
    $(document).on('click', '#addRow', function (event) {
      event.preventDefault();
      //console.log('clicked');  
      i++;
      j = i;

      var html = '<div id="row_' + i + '" class="row content dynamic-added">';
      html +='<div class="col-md-4"><div class="form-group"><select class="select2-single form-control product" id="productId_' + i +'" name="product_id[]" style="width: 100%;"><option value="">Select product</option>@foreach ($products as $item) @php $stock = DB::table('product_stocks')->where('product_id', $item->id)->orderBy('id','DESC')->first();if($stock){}else{continue;}@endphp <option value="{{$item->id}}">{{$item->name}}</option>@endforeach </select></div> </div>';        

      html += '<div class="col-md-2"><div class="form-group"><input type="text" name="product_sn[]" id="productSn_' + i +
        '" class="form-control product_sn"></div></div>';
        
      html += '<div class="col-md-1"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
        '" class="form-control qty"></div></div>';

      html +=
        '<div class="col-md-1"><div class="form-group"><input type="text" name="price[]" id="unitPrice' +
        i + '" class="form-control price"></div></div>';

      html +=
        '<div class="col-md-2"><div class="form-group"> <input type="text" readonly name="amount[]" class="form-control amount tr" id="amount' +
        i + '" ></div></div>';

      html += '<div class="col-md-1"><div class="form-group"><button id="' + i +
        '" type="button" class="btn btn-danger form-control btn_remove"><i class="fa fa-trash"></i></button></div></div>';

      html += '</div>';


      let tb = $("#target").find();
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
          $('#productSn_' + row_id + '').val(response.data.barcode);
          $('#unitPrice' + row_id + '').val(response.data.msrp);
          $('#amount' + row_id + '').val(response.data.msrp);
          updatetotalPrice();
        }
      });

    });  
    
    $(document).on('change', '.product_sn', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var product_sn = $(this).val();
      $.ajax({
        url: "find_product_sn",
        data: {
          _token: '{{csrf_token()}}',
          product_sn: product_sn
        },
        type: 'POST',
        success: function (response) {
          console.log(response.data);
          if(response.data == '404'){
            $('#productId_' + row_id + '').prepend("<option value='' selected='selected'>Select product</option>");
            $('#qty' + row_id + '').val(null);
            $('#unitPrice' + row_id + '').val(null);
            $('#amount' + row_id + '').val(null);
          }else{
            $('#productId_' + row_id + '').prepend("<option value='"+ response.data.id+ "' selected='selected'>" + response.data.name + "</option>");
            $('#qty' + row_id + '').val(1);
            $('#unitPrice' + row_id + '').val(response.data.msrp);
            $('#amount' + row_id + '').val(response.data.msrp);
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
      if(new_amount % 1 != 0){
        $('#amount' + row_id + '').val(new_amount.toFixed(2));
      }else{
        $('#amount' + row_id + '').val(new_amount.toFixed(2));
      }      
      updatetotalPrice();
    });


    //change on unit price
    $(document).on('change', '.price', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var price = $(this).val();
      var new_amount = $('#qty' + row_id + '').val() * price;
      if(new_amount % 1 != 0){
        $('#amount' + row_id + '').val(new_amount.toFixed(2));
      }else{
        $('#amount' + row_id + '').val(new_amount.toFixed(2));
      }      
      updatetotalPrice();
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

    // not needed now
    // $("#unitPrice").change(function () {
    //   var unitPrice = $(this).val();
    //   var new_amount = $('#qty').val() * unitPrice;
    //   $("#amount").val(new_amount);
    //   $("#totalPrice").val(new_amount);
    // });

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
        var discount_amount = $("#discount_amount").val();
        var net_amount = totalPrice - discount_amount;
        $("#dueAmount").val(net_amount);
      }
 
    }); 
    
    $(document).on('click', '#adjustment', function () {
      if ($('#adjustment').is(':checked')) {   
        var net_amount = parseInt($("#net_amount").val());
        var dueAmount = parseInt($("#dueAmount").val());
        var discount_amount = parseInt($("#discount_amount").val());
        var final_discount = discount_amount + dueAmount;
        var final_net_amount = net_amount - dueAmount;
        $("#net_amount").val(final_net_amount);
        $("#discount_amount").val(final_discount);
        $("#dueAmount").val(0);
      }

    });



  });
</script>

@endsection