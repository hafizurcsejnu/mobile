<?php
use App\Models\Setting;
$settings = Setting::where('client_id', session('client_id'))->first();
?>
@extends('admin.master')
@section('main_content')

<div class="page-content container container-plus">
  <div class="page-header pb-2">
    
    <a href="add-invoice" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
      <i class="fa fa-plus mr-1"></i>
      <span class="d-sm-none d-md-inline">New</span> Invoices
    </a>
    <a href="invoices" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
      <i class="fa fa-list mr-1"></i>
      <span class="d-sm-none d-md-inline">All</span> Invoices
    </a>
  </div>

 <style>

input#paidAmount {
    float: right;
    text-align: right;
}
button.btn.btn-primary {
    float: right;
    
}

   .form-check-input {
    position: absolute;
    margin-top: 0.3rem;
    margin-left: 0rem!important;
  }
  .table {
    width: auto;
  }
  .table th, .table td {
    padding: 0.25rem;
    vertical-align: top;
}
  table.table.top1_right {
    float: right;
}
table.table.top1_left tr, table.table.top1_right tr {
    height: 21px;
}
table.table.top1_left tr td, table.table.top1_right tr td{
  border-top: 0px solid #dee2e6;
}

 </style>

  <div class="row mt-3">
    <div class="col-12">
      <div class="card dcard">
        <div class="card-body px-1 px-md-3">
          <div role="main" class="main-content">


            <div class="page-content container container-plus" style="padding: 10px 50px;">
              <div id="printableArea">
                
                {{-- @include('reports.__report_header') --}}
                @include('reports._report_top1')              
               
                <table class="table" style="width: 100%; margin: 0 auto; text-align: center;">
                  <thead>
                    <tr style="background: #DDDDDD; color: #000">
                      <th style="width: 10%">#</th>
                      <th style="background-color: #ddd!important; text-align:left;width: 30% ">Item Title</th>
                      <th style="background-color: #ddd!important;width: 20%">Quantity</th>
                      <th style="background-color: #ddd!important;width: 10%">Return Qty</th>
                      <th style="background-color: #ddd!important;width: 20%" class="tr">Unit Price</th>                      
                      <th style="background-color: #ddd!important; width: 20%" class="tr">Amount</th>
                    </tr> 
                  </thead> 
                  <tbody>

                    <form action="update_invoice" method="post" enctype="multipart/form-data">
                      @csrf

                      @php
                      $orderDetails = DB::table('order_details')
                      ->join('products', 'order_details.product_id', '=', 'products.id')
                      ->select('order_details.*', 'products.name as productName', 'products.slug as product_slug', 'products.id as product_id','products.measurement_unit as mUnit')
                      ->where('order_id',$order->id)
                      ->get();
                      $i=0;

                      $banks=DB::table('banks')
                                ->orderBy('title','asc')
                                ->get();    
                      @endphp
                      @php
                            $i++;
                      @endphp

                      @foreach ($orderDetails as $data)
                      <tr class="product_row">
                        <td class="product_title" scope="row">{{$loop->iteration}}.</td>
                        <td class="product_title" style="text-align:left;"><a href="{{URL::to('product')}}/{{$data->product_slug}}" style="color: #000">{{$data->productName}}</a> </td>
                        <td>{{$data->qty}} @if ($data->mUnit!=null) {{$data->mUnit}} @endif</td>
                        <td class="tc">
                          <input type="text" name="return_qty[]" class="form-control tc" id="return_qty">  
                          <input type="hidden" name="product_id[]" value="{{$data->product_id}}">  
                          <input type="hidden" name="price[]" value="{{$data->price}}">  
                        </td>
                        <td class="tr">{{$data->price}}</td>
                        <td class="price tr">{{number_format($data->price * $data->qty,2)}}</td>
                      </tr>
                      @endforeach


          
                      <tr style="margin-top:1px solid #000;">    
                        <td colspan="4">&nbsp;</td>
                        <td class="box tr"><b>Total</b> </td>    
                        <td class="box price tr">
                          <b>{{number_format($order->sub_total, 2)}}</b>
                          <input type="hidden" id="totalPrice" name="sub_total" value="{{$order->sub_total}}">
                        </td>
                      </tr>
                    
                      <tr class="">
                        <td colspan="2">&nbsp;</td>
                        
                        <td colspan="1" class="tr" style="padding-top:10px">@if($order->due_amount != 0) Discount Code: @endif</td>
                      
                        <td colspan="1">
                          @if($order->due_amount != 0) 
                          <input type="text" name="coupon_code" placeholder="Discount Code" class="form-control" id="coupon_code" style="width: 150px">
                          <p id="discount_msg" class="text-danger" style="display: none">Invalid  code</p>
                          @endif  
                        </td>
                        <td class="tr"><b>(-)Discount</b> </td>
                        <td class="tr">
                          <input type="text" readonly name="discount_amount" class="form-control tr" id="discount_amount" value="{{$order->discount_amount}}">
                        </td>
                      </tr>
                    

                      <tr class="">
                        <td colspan="4">&nbsp;</td>
                        <td class="tr"><b>Net Payable</b> </td>
                        <td class="tr">
                          <input type="text" readonly name="total_price" class="form-control tr" id="net_amount" value="{{$order->total_price}}">
                        </td>
                      </tr>
                      
                      <tr class="text-success">
                        <td colspan="4">&nbsp;</td>
                        <td class="box tr"><b>Amount Paid</b> </td>
                        <td class="box price tr"><b>
                          <input type="text" readonly class="form-control tr" id="depositAmount" name="deposit_amount" value="{{$order->paid_amount}}">
                        </b></td> 
                      </tr>  
                      <tr class="text-danger">
                        <td colspan="4">&nbsp;</td> 
                        <td class="box tr"><b> Due</b> </td> 
                        <td class="box price tr"><b>
                          <input type="text" readonly class="form-control tr" id="dueAmount" name="due_amount" value="{{$order->due_amount}}">
                        </b></td>    
                      </tr>      
  
                    
                        <input type="hidden" name="past_due" value="{{$order->due_amount}}">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                      
                      @if($order->due_amount != 0) 
                        <tr class="new_payment">
                          <td colspan="4">
                            <div class="form-group1 payment_method" style="float: left">
                              <label for="">Payment Method: </label> &nbsp;&nbsp;&nbsp;

                              <input type="radio" name="payment_method" class="form-check-input" checked value="Cash" id="cash">
                              <label class="form-check-label" for="cash">Cash</label>

                              {{-- <input type="radio" name="payment_method" class="form-check-input" value="Bank" id="bank">
                              <label class="form-check-label" for="bank">Bank</label> --}}
                              
                              <input type="radio" name="payment_method" class="form-check-input" value="Check" id="check">
                              <label class="form-check-label" for="check">Check</label>

                              <input type="radio" name="payment_method" class="form-check-input" value="Due" id="due">
                              <label class="form-check-label" for="due">Due</label>
                            </div>                        
                          </td>
                          <td class="box tr">
                            <label for="" style="">Deposit: <input type="checkbox" class="form-check-input" id="paidBtn"
                                title="Click for full paid."> </label>
                          </td>
                          <td class="box">
                            <b><input type="text" name="paid_amount" class="form-control tr" id="paidAmount" required
                                style="font-weight: 600; color:#000;"></b>
                          </td>
                        </tr>
                        <tr class="">
                          <td colspan="4">
                            <div id="bankDetails" style="display: none">
                              <div id="bank_details"><div class="form-group"><select class="form-control" name="bank_id" style="margin-top: -15px;float:left;margin-bottom:5px; margin-right: 5%"><option value="">Select bank</option>@foreach ($banks as $bank)<option value="{{$bank->id}}">{{$bank->title}}({{$bank->branch}}) - A/C No-{{$bank->ac_no}}</option>@endforeach </select> </div><div class="form-group d-none"> <input type="text" name="branch" placeholder="Branch name" class="form-control" style="width:30%; float:left; margin-bottom:5px"></div></div></div>
                            </div>  
                          </td>
                          <td class="tr">
                            <label for="">Final Due:</label>
                            <input type="checkbox" class="form-check-input" id="adjustment" title="Adjust this amount as discount.">
                          </td>
                          <td class="tr">
                            <input type="text" readonly style="text-align: right; margin: 0 auto; float: right;" name="final_due" class="form-control" id="finalDue">
                          </td>
                        </tr>
                      @endif

                      <tr class="button">
                        <td colspan="3">   
                          <div class="form-group">
                          <textarea name="note" class="form-control" placeholder="Remarks" rows="">{{ucwords($order->note)}}</textarea>
                        </div>
                        </td>            
                        <td class="tr" @if($order->due_amount == 0)colspan="1" @endif></td>    
                              
                        <td class="text-light">
                          <a class="btn" style="background: rgb(28, 139, 175); color: #fff" title="Details" href="invoice-preview/{{$order->id}}" target="_blank" class="v-hover tr">Print</a>
                          <input type="hidden" name="customer_id" value="{{$order->customer_id}}">
                          <button type="submit" class="btn btn-primary" style="color: #fff">Update</button>
                        </td>
                    
                      </tr>
                    </form>

                  </tbody>
                </table>
                
              @php
                $payments = DB::table('payments')
                ->where('order_id',$order->id)
                ->get();
                $total_payments = $payments->count();
              @endphp
              @if($total_payments > 1)
                <table class="table" style="width: 50%;text-align: center;">                  
                  <h5>Payment History:</h5>
                  <thead>
                    <tr style="background: #dddddd">
                      <th>SN</th>
                      <th>Date</th>
                      <th>P. Method</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($payments as $payment)
                        <tr>
                          <td>{{$loop->iteration}}</td>   
                          <td>{{$payment->created_at}}</td>   
                          <td>{{$payment->payment_method}}</td>           
                          <td class="price">{{number_format($payment->amount, 2)}}</td>     
                        </tr>
                      @endforeach  
                      <tr class="text-bold" style="font-weight: 600; background:#f1f1f1">
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td class="price">{{number_format($order->paid_amount, 2)}}</td> 
                      </tr>               
                  </tbody>
                </table>
              @endif

              <div class="product_refund d-none">
                <h5 style="background: #d0e2ff;color: #0a0a0a;
                padding: 5px 0px;
                font-size: 16px;
                font-weight: 600; margin-top: 50px"> &nbsp; Product Return Option: </h5>
    
                <div class="row">
                  <div class="col-md-4">
                    <label for="">Select {{$settings->product_type}}</label>
                  </div>
                  
                  <div class="col-md-2">
                    <label for="">Qty</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Unit Price</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Amount</label>
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
                              $collection=DB::table('products')
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
                        @foreach ($orderDetails as $data)                     
                          <option value="{{$data->product_id}}">{{$data->productName}}</option>
                        @endforeach                     
                      </select>
                    </div>
                  </div>
                  
                  
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="qty[]" id="qty1" class="form-control qty">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="price[]" id="unitPrice1" class="form-control price">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="amount[]" readonly class="form-control amount tr" id="amount1">
                    </div> 
                  </div>  
                  
                  @if ($i>1)
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
                  @endif
                  
                </div>
             
    
                  <div id="target"></div>
    
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                      <label for="" style="float: right;">Total Refund:</label>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="text" readonly name="total_price" class="form-control tr" id="totalPrice">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="button" id="refundBtn" class="btn btn-primary" style="color: #fff; width: 100%;">Save Refund</button>
                    </div>
                  </div>
              </div>   

                  <p
                    style="display: none; text-align: center; border: 1px dotted grey; width: 80%; margin: 20px auto; padding:5px">
                    Generated from Accounting Software. No signature is needed. </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  {{-- </div> --}}

</div>
<script>
$(document).ready(function () {

  $("#paidBtn").click(function () {
      var totalPrice = {{$order->due_amount}};
      var dueAmount = $("#dueAmount").val();
      $("#paidAmount").val(dueAmount);
      $("#finalDue").val(0);
    });   

  $("#paidAmount").change(function () {
      var totalPrice = {{$order->due_amount}};
      var dueAmount = $("#dueAmount").val();
      var paidAmount = $("#paidAmount").val();
      $("#finalDue").val(dueAmount - paidAmount);
    });


  $(document).on('click', '#bank', function () {
    if ($('#bank').is(':checked')) {
      bankDetails =
        '<div id="bank_details"><div class="form-group"><select class="form-control" name="bank_id" style="margin-top: -15px;float:left;margin-bottom:5px; margin-right: 5%"><option value="">Select bank</option>@foreach ($banks as $bank)<option value="{{$bank->id}}">{{$bank->title}}({{$bank->branch}}) - A/C No-{{$bank->ac_no}}</option>@endforeach </select> </div><div class="form-group d-none"> <input type="text" name="branch" placeholder="Branch name" class="form-control" style="width:30%; float:left; margin-bottom:5px"></div></div></div>';
      //$("#bankDetails").append(bankDetails);
      $("#bankDetails").show();
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

   
    $(document).on('click', '#adjustment', function () {
      if ($('#adjustment').is(':checked')) {   
        var net_amount = parseInt($("#net_amount").val());
        var dueAmountOld = parseInt($("#dueAmount").val());
        var finalDue = parseInt($("#finalDue").val());
        var discount_amount = parseInt($("#discount_amount").val());
        
        var final_discount = discount_amount + finalDue;
        var final_net_amount = net_amount - finalDue;
        var dueAmountNew = dueAmountOld - finalDue;
        $("#net_amount").val(final_net_amount);
        $("#discount_amount").val(final_discount);
        $("#dueAmount").val(dueAmountNew);
        $("#finalDue").val(0);
        //console.log(net_amount+ '-' +dueAmount+ '-' +discount_amount+ '-' +final_discount + '-' +dueAmount);
      }
    });


     //coupon code
     $("#coupon_code").change(function () {
      var coupon_code = $(this).val();
      var total_price = $('#totalPrice').val();
      var depositAmount = $('#depositAmount').val();
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
            var due_amount = net_amount - depositAmount;
            $("#net_amount").val(net_amount);
            $("#dueAmount").val(due_amount);

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



});
</script>


<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
  }
</script>

{{-- refund script --}}

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

      html +=
        '<div class="col-md-4"><div class="form-group"><select class="select2-single form-control product" id="productId_' + i +'" name="product_id[]" style="width: 100%;"><option value="">Select product</option>@foreach ($orderDetails as $item) <option value="{{$item->product_id}}">{{$item->productName}}</option>@endforeach </select></div> </div>';

  
        
        
      html += '<div class="col-md-2"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
        '" class="form-control qty"></div></div>';

      html +=
        '<div class="col-md-2"><div class="form-group"><input type="text" name="price[]" id="unitPrice' +
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
          $('#unitPrice' + row_id + '').val(response.data.price);
          $('#amount' + row_id + '').val(response.data.price);
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

    // not needed now
    $("#unitPrice").change(function () {
      var unitPrice = $(this).val();
      var new_amount = $('#qty').val() * unitPrice;
      $("#amount").val(new_amount);
      $("#totalPrice").val(new_amount);
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