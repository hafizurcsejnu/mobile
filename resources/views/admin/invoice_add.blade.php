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
  .price{
    text-align: center!important;
  }
  input.price {
    text-align: center!important;
}
  i.fa.fa-trash {
    display: block;
  }
</style>


@if($settings->payment_details != 'yes')
<style>
    label.payment_details, select.payment_details, input.payment_details {
        display: none!important;
    }
    p.payment_details {
        display: none;
    }
    div#bank_details {
        display: none;
    }
</style>  
@endif



<div class="page-content container container-plus">
  <div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
      New Invoice
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

              <form action="store_invoice" method="post" enctype="multipart/form-data">
                @csrf

                
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Customer*</label>
                      <select class="select2-single" id="customerId" name="customer_id" style="width: 100%;">
                        <option value="">Search customer</option>
                        <option value="New">New</option>
                        <?php                            
                              $collection=DB::table('customers')
                                  ->where('active','on')
                                  ->where('client_id', session('client_id')) 
                                  ->orderBy('id','desc')
                                  ->get();                                
                              ?>
                        @foreach ($collection as $item)
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


                <div class="row" style="margin-top: 50px">
                  <div class="col-md-3">
                    <label for="">Select Item</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Product Serial/Imie</label>
                  </div>
                  <div class="col-md-1">
                    <label for="">Qty</label>
                  </div>
                  <div class="col-md-1">
                    <label for="">Price</label>
                  </div>
                  <div class="col-md-1">
                    <label for="">Less</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Total Price</label>
                  </div>
                  <div class="col-md-2">
                    <label for="">Action</label>
                  </div>
                </div>

                <div class="row content" id="row_1">
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="select2-single product" name="product_id[]" id="productId_1"
                        style="width: 100%;">
                        <?php                             
                              $collection=DB::table('products')
                                 ->where('client_id',session('client_id'))
                                 ->where('active','on')
                                 ->orderBy('id','asc')
                                 ->get();       
                                                            
                              $banks = DB::table('banks')
                                 ->where('client_id',session('client_id'))
                                 ->where('banking_type', '!=', 'Mobile Banking')
                                 ->orderBy('title','asc')
                                 ->get();  

                              //dd($banks);
                                 
                              $mobile_banking = DB::table('banks')
                                 ->where('client_id',session('client_id'))
                                 ->where('banking_type', 'Mobile Banking')
                                 ->orderBy('title','asc')
                                 ->get();     
                                 //dd($mobile_banking);                           
                              ?>
                            
                        <option value="">Select Item</option>
                        <option value="1">Advance Payment</option>
                        <option value="2">Due Payment</option>
                        @if (session('client_id') == 6)
                          <option value="-1">Discount on Ledger</option>
                        @endif
                        @foreach ($collection as $item)                        
                        <option value="{{$item->id}}">{{ucwords($item->name)}}</option>
                        @endforeach
                        <option value="N/A">N/A</option>
                      </select>                     

                    </div>
                  </div>
                 

                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="product_sn[]" id="product_sn_1" class="form-control product_sn imei">
                    </div>
                  </div>
                  <div class="col-md-1">
                    <style>
                    input.qty {
                      display: inline;
                      float: left;
                      width: 50%;
                      padding: 0;
                  }</style>
                    <div class="form-group">
                      <input type="text" name="qty[]" id="qty1" class="form-control qty">

                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary add_imei" data-toggle="modal" data-row="1" data-target="#imeiModal">
                        <i class="fa fa-plus"></i>
                      </button>
                      <div id="imei_number_1_input">                            
                      </div>

                    </div>

                    

                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" style="padding: 0px 3px" name="price[]" id="unitPrice1" class="form-control price tc">
                    </div>
                  </div>
                  
                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="text" style="padding: 0px 3px" name="less[]" id="less1" class="form-control less tc">
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
                  {{-- <div class="col-md-1">
                    <button>+ Note</button>
                  </div>
                  <div class="col-md-7">
                    <input type="text" name="item_note" class="form-control item_note" id="">
                  </div> --}}
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

                <div class="row d-none" style="background: #fff;  height: 45px;
                padding-top: 4px;margin-top: -10px;margin-bottom: 10px;">
                  <div class="col-md-4">
                    <label for="" style="float: right;">Discount Code:</label>                          
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="coupon_code" placeholder="Enter code" class="form-control" id="coupon_code">
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
                  <div class="col-md-6">
                    <label class="payment_details" style="font-size: 19px; font-weight: bold; border-bottom: 1px solid #ddd; display: block">Payment Details:</label>
                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Net Bill:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="net_bill" class="form-control tr" id="net_bill" value="0">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

                <div class="row">
                  {{-- cash payment --}}
                  <div class="col-md-1">
                    <label for="" class="payment_details">Cash:</label>
                  </div>
                  <div class="col-md-3"></div>
                  <div class="col-md-2">
                    <input type="text" name="payment_cash" id="payment_cash" class="form-control payment_details tr" placeholder="0.00">
                  </div>
                  {{-- cash payment --}}


                  <div class="col-md-2">
                    <label for="" style="float: right;">Previous Due:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="previous_due" class="form-control tr" id="previous_due" value="0">
                    </div>
                  </div> 
                  <div class="col-md-2"></div>
                </div>  
                {{-- this is new changes.  --}}
                
                <div class="row">
                  {{-- bank payment --}}
                  <div class="col-md-1">
                    <label for="" class="payment_details">Bank:</label>
                  </div>
                  <div class="col-md-3">
                    <div id="bank_details">
                      <div class="form-group">
                          <select class="form-control payment_details ss" name="bank_id_general" style="margin-top: -15px; float:left;margin-bottom:5px; margin-right: 5%">
                            <option value="">Select bank</option>
                            @foreach ($banks as $bank)
                              <option value="{{$bank->id}}">{{$bank->title}} - A/C No-{{$bank->ac_no}}</option>
                            @endforeach 
                          </select> 
                      </div> 
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input type="text" name="payment_bank" id="payment_bank" class="form-control payment_details tr" placeholder="0.00">
                  </div> 
                  {{-- bank payment --}}
                 
                  <div class="col-md-2">
                    <label for="" style="float: right;">Total Bill:</label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" readonly name="total_bill" class="form-control tr" id="totalBill" value="0">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>


                <div class="row">

                   {{-- bkash payment // Mobile Financial Service --}}
                   <div class="col-md-1">
                    <label for="" class="payment_details">MFS:</label> 
                  </div> 
                  <div class="col-md-3">
                    <div id="bank_details">
                      <div class="form-group">
                          <select class="form-control payment_details ss" name="bank_id_mfs" style="margin-top: -15px; float:left;margin-bottom:5px; margin-right: 5%">
                            <option value="">Select mobile banking</option>
                            @foreach ($mobile_banking as $bank)
                              <option value="{{$bank->id}}">{{$bank->title}}-{{$bank->ac_no}}</option>
                            @endforeach 
                          </select> 
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2"> 
                    <input type="text" name="payment_mfs" id="payment_mfs" class="form-control payment_details tr"  placeholder="0.00">
                    <p class="payment_details" style="text-align: right; font-weight: 600">Total: <span id="totalPayment"></span> </p>
                  </div>
                  {{-- bkash payment --}}
                    

                 

                  <div class="col-md-2">

                    {{-- <input type="checkbox" class="form-check-input" id="due" title="Due Invoice"> --}}

                    <label for="" style="float: right;">Payment: <input type="checkbox" class="form-check-input" id="paidBtn" title="Click for full paid."> </label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="paid_amount" class="form-control tr" id="paidAmount" required style="font-weight: 600; color:#000">
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <textarea name="note" id="summernote1" class="form-control" placeholder="Remarks:" rows="2"></textarea>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="" style="float: right;">Net Due:  
                      <input type="checkbox" class="form-check-input" id="adjustment" title="Adjust this amount as discount.">
                    </label>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">                     
                      <input type="text" readonly name="due_amount" class="form-control tr" id="dueAmount">
                      <p style="display: none; color: red;" id="adjustment_error">Adjustment amount can not be more than 10000 Tk.</p>
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

  <!-- Modal -->
  <div class="modal fade" id="imeiModal" tabindex="-1" role="dialog" aria-labelledby="imeiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imeiModalLabel">IMEI Serial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="imei">
                        
          </div>
          <textarea name="item_note[]" id="" style="width: 100%" rows="5"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save_imei">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- close modal -->
<script>
  $(document).on('click', '.add_imei', function() {
    var row = $(this).data('row');
    var quantity = parseInt($('#qty' + row).val());
    var existing_imei = $('#imei_number_' + row + '_input').find('input').val();
    if (existing_imei == '' || existing_imei == null || existing_imei == undefined) {
      existing_imei = [];
    } else {
      existing_imei = existing_imei.split(',');
    }
    var html = '';
    for(i=1;i<=quantity;i++){
      html += '<div class="form-group"><input type="text" class="form-control" id="imei_'+i+'" name="imei_'+row+'[]" placeholder="Enter IMEI '+i+'" value="'+((existing_imei[i-1]) ?? '')+'"></div>';
    }
    $("#imeiModal .modal-body").html(html);
    $('#imeiModal #save_imei').data('row', row);
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
        '<div class="col-md-3"><div class="form-group"><select class="select2-single product" id="productId_' + i +'" name="product_id[]" style="width: 100%;"><option value="">Select Item</option> <option value="1">Advance Payment</option><option value="2">Due Payment</option>@foreach ($collection as $item) <option value="{{$item->id}}">{{$item->name}}</option>@endforeach </select></div> </div>';

       html += '<div class="col-md-2"><div class="form-group"><input type="text" name="product_sn[]" id="product_sn_' + i +
         '" class="form-control product_sn imei"></div></div>';
        
      html += '<div class="col-md-1"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
        '" class="form-control qty"><button type="button" class="btn btn-primary add_imei" data-row="'+i+'" data-toggle="modal" data-target="#imeiModal"><i class="fa fa-plus"></i></button><div id="imei_number_'+i+'_input"></div></div></div>';

      html +=
        '<div class="col-md-1"><div class="form-group"><input type="text" name="price[]" style="padding: 0px 3px"  id="unitPrice' +
        i + '" class="form-control price tc"></div></div>';

      html +=
        '<div class="col-md-1"><div class="form-group"><input type="text" name="less[]" style="padding: 0px 3px"  id="less' +
        i + '" class="form-control less tc"></div></div>';

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
      updateTotalPrice();
    });

    function updateTotalPrice() {
      var sum = 0;
      $(".amount").each(function () {
        sum += +$(this).val();
        console.log(sum);
      });

      var previous_due = parseFloat($('#previous_due').val());
      if(previous_due == null || previous_due == ''){
        previous_due = 0;
      }

      $("#totalPrice").val(sum);
      $("#totalBill").val(sum+previous_due);
      $("#net_bill").val(sum);
    }
    
    function updateTotalBill() {
      var net_bill = $('#net_bill').val();
      var previous_due = parseFloat($('#previous_due').val());
      if(previous_due == null || previous_due == ''){
        previous_due = 0;
      }
      var totalBill = parseInt(net_bill) + parseInt(previous_due);    
      $("#totalBill").val(totalBill);
    }

    function updateTotalPayment() {
      var payment_cash = $('#payment_cash').val();
      var payment_bank = $('#payment_bank').val();
      var payment_mfs =  $('#payment_mfs').val();

      if(payment_cash == null || payment_cash == ''){ payment_cash = 0; }
      if(payment_bank == null || payment_bank == ''){ payment_bank = 0; }
      if(payment_mfs == null || payment_mfs == ''){ payment_mfs = 0; }

      var totalPayment = parseInt(payment_cash) + parseInt(payment_bank) + parseInt(payment_mfs);    

      console.log(payment_cash);
      console.log(payment_bank);
      console.log(payment_mfs);
      console.log(totalPayment);
      $("#totalPayment").text(totalPayment);
    }

    $(document).on('change', '#payment_cash', function () {
      updateTotalPayment();
    }); 
    $(document).on('change', '#payment_bank', function () {
      updateTotalPayment();
    });
    $(document).on('change', '#payment_mfs', function () {
      updateTotalPayment();
    });

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
          updateTotalPrice();
        }
      });

    });  
    
    $(document).on('change', '.product_sn1', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var product_sn = $(this).val();
      alert(product_sn);
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

    $(document).on('change', '.imei', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var imei = $(this).val();
    
      $.ajax({
        url: "find_imei",
        data: {
          _token: '{{csrf_token()}}',
          imei: imei
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

    $(document).on('click', '#save_imei', function() {
        var row_id = $(this).data('row');
        var imei = '';
        var inputs = $('#imeiModal .modal-body input');
        for(var i=0; i<inputs.length; i++) {
            imei += inputs[i].value + ',';
        }
        var input = '<input type="hidden" name="imei_' + row_id +'" value="' + imei + '"/>';
        $('#imei_number_' + row_id + '_input').html(input);
        $('#imeiModal').modal('toggle');
    });


    //change on previous due
    $(document).on('change', '#previous_due', function () {      
      var previous_due = $(this).val();     
      updateTotalBill();
    }); 
    
     //change on qty
    $(document).on('change', '.qty', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var qty = $(this).val();
      var new_amount = $('#unitPrice' + row_id + '').val() * qty;
      $('#amount' + row_id + '').val(new_amount);
      updateTotalPrice();
    });

    //change on unit price
    $(document).on('change', '.price', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var price = $(this).val();
      var new_amount = $('#qty' + row_id + '').val() * price;
      $('#amount' + row_id + '').val(new_amount);
      updateTotalPrice();
    });
    
    //change on less 
    $(document).on('change', '.less', function () {
      var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
      var less = $(this).val();
      var price = $('#unitPrice' + row_id + '').val();
      var qty = $('#qty' + row_id + '').val();
      var less_amount = price * qty * less / 100;
      console.log(less, price, qty, less_amount);
      var new_amount = price * qty - less_amount;
      //alert(less_amount);
      $('#amount' + row_id + '').val(new_amount);
      updateTotalPrice();
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
            var previous_due = parseInt($("#previous_due").val());        

            $("#discount_amount").val(discount_amount);
            $("#discount_msg").hide();    

            var totalPrice = $("#totalPrice").val();        
            var net_bill = totalPrice - discount_amount;
            var total_bill = totalPrice - discount_amount + previous_due;
            $("#net_bill").val(net_bill);
            $("#totalBill").val(total_bill);
            $("#paidAmount").val();

          }else{
            $("#discount_msg").show();
            $("#discount_amount").val(0);
            var totalPrice = $("#totalPrice").val();
            $("#net_bill").val(totalPrice);
            $("#paidAmount").val(0);
          }  
        }
      });
    });

    $("#paidBtn").click(function () {
      var totalBill = $("#totalBill").val();
      if(totalBill > 0){
        $("#paidAmount").val(totalBill);
      }else{
        var totalBill = $("#totalBill").val();
        $("#paidAmount").val(totalBill);
      }    
      $("#dueAmount").val(0);
      $('#adjustment_error').css('display', 'none');
    });   

    $("#paidAmount").change(function () {
      var totalPrice = $("#totalPrice").val();
      var paidAmount = $("#paidAmount").val();
      var totalBill = $("#totalBill").val();
      var discount_amount = $("#discount_amount").val();
      var due_amount = totalBill - paidAmount;

      // net due float fixed
      if(typeof due_amount === 'number'){
        if(due_amount % 1 === 0){
          // int
        } else{
          //float
          due_amount = due_amount.toFixed(2);
        }
      } else{
        // not a number
      }

      $("#dueAmount").val(due_amount); 
    });
 

    $(document).on('change', '#customerId', function () {     
      var customerId = $(this).val();
      if (customerId == 'New') {
        var textMore ="<input type='text' autofocus class='form-control mb-2 mt-1' placeholder='Enter customer name / Sold to' name='customer_name' id='customerName'/>";
        $("#customerName").focus();
        $("#customerNameDiv").append(textMore);
      } 
      else{ 
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
        var totalBill = $("#totalBill").val();
        var paidAmount = $("#paidAmount").val(0);
        var discount_amount = $("#discount_amount").val();
        var net_bill = totalBill - discount_amount;
        $("#dueAmount").val(net_bill);
      }
 
    }); 
    
    $(document).on('click', '#adjustment', function () {
      if ($('#adjustment').is(':checked')) {   
        var net_bill = parseInt($("#net_bill").val());
        var dueAmount = parseInt($("#dueAmount").val());
        var previous_due = parseInt($("#previous_due").val());        
        if(dueAmount > 10000 || dueAmount == NaN){
          $('#adjustment_error').css('display', 'block');
          $('#adjustment').prop('checked', false);
        }else{
          if(dueAmount > 0){
              $('#adjustment_error').css('display', 'none');
              var discount_amount = parseInt($("#discount_amount").val());
              var final_discount = discount_amount + dueAmount;
              var final_net_bill = net_bill - dueAmount;
              var final_total_bill = net_bill + previous_due - dueAmount;
              $("#net_bill").val(final_net_bill);
              $("#totalBill").val(final_total_bill);
              $("#discount_amount").val(final_discount);
              $("#dueAmount").val(0);
              $('input#adjustment').css('display', 'none');
          }else{
            $('input#adjustment').css('display', 'inline block');
            $('#adjustment').prop('checked', false);
          }
          
        }
        
      }
    });

  });


</script>

@endsection