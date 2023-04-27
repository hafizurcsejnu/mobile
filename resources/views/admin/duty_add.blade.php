
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        New Duty  
      </h1> 
      <a href="duties"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Duties
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_duty" method="post" enctype="multipart/form-data">
                  @csrf
                 
                  <div class="row">  
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Ex No</label>
                        <select class="form-control ss" required name="equipement_id" id="equipement_id">  
                          <option value="">-- Select Equipement --</option> 
                            <?php                            
                             $companies=DB::table('products')
                             ->where('client_id', session('client_id'))
                             ->where('product_type', 'Service')
                             ->where('active', 'on')->orderBy('name','asc')->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach  
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Duty Rate</label>
                        <input type="text" name="rate" id="rate" class="form-control">
                      </div>
                    </div>

                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Duty Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                        value="<?php echo date('Y-m-d'); ?>">
                      </div>
                    </div>
                  </div> 

                  <div class="row">

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Customer or company</label>
                        <select class="form-control select2-single" name="customer_id" required id="customerId">  
                          <option value="">-- Select customer --</option>                   
                          <option value="New">New Customer</option>                   
                  
                            <?php                            
                             $customers = DB::table('customers')
                             ->where('client_id', session('client_id'))
                             ->where('active', 'on')
                             ->orderBy('title','asc')
                             ->get();
                             ?>
                            @foreach($customers as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>

                        <div id="customerDiv"></div>
                        
                      </div>

                      
                    </div>


                    <div class="col-md-6"> 
                      <div class="form-group">
                        <label for="">Operator</label>
                        <select class="form-control select2-single" name="employee_id" id="employeeId">  
                          <option value="">-- Select Operator --</option>
                          <option value="New">New Operator</option>     
                            <?php                            
                             $driver =DB::table('employees')
                             ->where('designation', 'Driver')
                             ->where('client_id', session('client_id'))
                             ->where('active', 'on')
                             ->orderBy('title','asc')
                             ->get();
                             ?>
                            @foreach($driver as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                        <div id="operatorDiv"></div>

                      </div>
                    </div>
                  
                  </div>

                  <br> <br>
                  <div class="row">                     
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Start Reading</label>
                        <input type="text" name="start_reading" class="form-control" id=""  placeholder="" value="0">
                      </div>      
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Stop Reading</label>
                        <input type="text" name="stop_reading" class="form-control" id=""  placeholder="" value="0">
                      </div>      
                    </div>                                                
                 
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Total Hours</label>
                        <input type="text" required name="total_hours" class="form-control" id=""  placeholder="" value="0">
                      </div>      
                    </div>
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Tracking Hours</label>
                        <input type="text" name="tracking_hours" class="form-control" id=""  placeholder="" value="0">
                      </div>      
                    </div>
                  </div>


                  <div class="row">                     
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Payment Receive</label>
                        <input type="text" name="payment_receive" class="form-control" id="payment_receive"  placeholder="In Taka" value="0">
                      </div>      
                    </div>
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Fuel Receive</label>
                        <select class="form-control ss" name="fuel_type"> 
                          <option value="">Fuel Type</option>
                          <option value="Hydraulic">Hydraulic</option>
                          <option value="Diesel">Diesel</option>
                          <option value="Mobil">Mobil</option>
                          <option value="Grease">Grease</option>
                          <option value="Accessories">Accessories</option> 
                          <option value="Others">Others</option>

                        </select>                       
                      </div>      
                    </div>

                    <div class="col-md-3">
                      <div class="row">
                       
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Fuel Qty</label>
                            <input type="text" name="fuel_qty" class="form-control" id="fuel_qty"  placeholder="Qty">
                          </div>   
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Fuel Rate</label>
                            <input type="text" name="fuel_rate" class="form-control" id="fuel_rate"  placeholder="Rate">
                          </div>   
                        </div>

                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Fuel Cost</label>
                        <input type="text" readonly name="fuel_cost" class="form-control" id="fuel_cost"  placeholder="">
                      </div>      
                    </div>  
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Total Payment</label>
                        <input type="text" name="total_payment" readonly class="form-control" id="total_payment"  placeholder="">
                      </div>      
                    </div>    
                    
                    <div class="col-md-9">
                      <div class="form-group">
                        <label for="">Notes</label>
                        <textarea name="notes" class="form-control" rows="1"></textarea>  
                      </div>  
                    </div>

                  </div>
                  <div class="row">
                  </div>
                           
                  <div class="purchase_details mt-5">
                    <h4 style="border-bottom: 1px solid #ddd">Duty Expense Details</h4>
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Particular</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Expense Type</label>
                      </div>

                       <div class="col-md-1">
                        <label for="">Qty</label>
                      </div>
                       <div class="col-md-1">
                        <label for="">Rate</label>
                      </div>
                     
                      
                      <div class="col-md-2">
                        <label for="">Total Amount</label>
                      </div> 
                      
                     
                      <div class="col-md-2">
                        <label for="">Action</label>
                      </div>
                    </div>
    
                    <div class="row content" id="row_1">

                      <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="particular[]" class="form-control particular" id="particular1" placeholder="Particular"/>
                        </div>
                       
                      </div>   


                      <div class="col-md-2">
                        <div class="form-group">
                          <select class="select2-single product" name="expense_type[]" id="productId_1"
                            style="width: 100%;">
                            <option value="">Select Type</option>
                            <option value="Hydraulic">Hydraulic</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Grease">Grease</option>
                            <option value="Technician Bill">Technician Bill</option>
                            <option value="Operator Bill">Operator Bill</option>
                            <option value="Lovet Rent">Lovet Rent</option>
                            <option value="Salary">Salary</option>
                            <option value="Others">Others</option>
{{-- custom data lookup --}}
@php
$data_lookups = DB::table('data_lookups')
  ->where('client_id', session('client_id'))
  ->where('data_type', 'Expense Type')
  ->get();
@endphp
@foreach($data_lookups as $item) 
<option value="{{$item->title}}">{{$item->title}}</option>
@endforeach 
{{-- end custom data lookup --}}
                          </select>
                        </div>
                      </div>

                      <div class="col-md-1">
                        <div class="form-group">
                          <input type="text" name="qty[]" id="qty1" class="form-control qty" value="1">
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <input type="text" name="price[]" id="unitPrice1" class="form-control price">
                        </div>
                      </div>         
                      
                                  
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" name="total_price[]" readonly class="form-control amount tr" id="amount1">
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
                      <div class="col-md-4">
    
                      </div>
                      <div class="col-md-4">
                        <label for="" style="float: right;">Total Expense:</label>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" readonly name="total_price" class="form-control tr" id="totalPrice">
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

    $(document).on('change', '#equipement_id', function () {
        // $('#customerDiv').hide();
        // $('#operatorDiv').hide();

        var equipement_id = $(this).val(); 
          $.ajax({
            url: "find_equipement_rate",
            data: {
              _token: '{{csrf_token()}}',
              equipement_id: equipement_id
            },
            type: 'POST',
            success: function (response) {              
              $("#rate").val(response.rate);
              //alert(response.rate);
              if(response.customer_id != null){
                $("#customerId").prepend("<option value='"+ response.customer_id +"' selected='selected'>"+ response.customer_name +"</option>");
              }else{
                $("#customerId").prepend("<option value='' selected='selected'>-- Select Cutomer --</option>");
              }
              if(response.employee_id != null){
                $("#employeeId").prepend("<option value='"+ response.employee_id +"' selected='selected'>"+ response.employee_name +"</option>");
              }else{
                $("#employeeId").prepend("<option value='' selected='selected'>-- Select Operator --</option>");
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
          '<div class="col-md-4"><div class="form-group"> <input type="text" name="particular[]" class="form-control particular" placeholder="Particular" id="particular' +
          i + '" ></div></div>';
        html +=
          '<div class="col-md-2"><div class="form-group"><select class="select2-single form-control product" id="productId_' +
          i +
          '" name="expense_type[]" style="width: 100%;"><option value="">Select Type</option> <option value="Hydraulic">Hydraulic</option> <option value="Diesel">Diesel</option> <option value="Mobil">Mobil</option> <option value="Grease">Grease</option> <option value="Technitian Bill">Technician Bill</option> <option value="Salary">Salary</option>  <option value="Others">Others</option> </select></div> </div>';
  
      
          
        html += '<div class="col-md-1"><div class="form-group"><input type="text" name="qty[]" id="qty' + i +
          '" class="form-control qty"></div></div>';
       
        html +=
          '<div class="col-md-1"><div class="form-group"><input type="text" name="price[]" id="unitPrice' +
          i + '" class="form-control price"></div></div>';  
  
        html +=
          '<div class="col-md-2"><div class="form-group"> <input type="text" readonly name="total_price[]" class="form-control amount tr" id="amount' +
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
            $('#unitPrice' + row_id + '').val(response.data.bp);
            $('#amount' + row_id + '').val(response.data.bp);
            $('#particular' + row_id + '').val(response.data.barcode);
            updatetotalPrice();
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
            $("#unitPrice").val(response.data.bp);
            $("#amount").val(response.data.bp);
            $("#totalPrice").val(response.data.bp);
          }
        });
      });

      $("#payment_receive").change(function () {
        var payment_receive = parseFloat($(this).val());
        var fuel_qty = $('#fuel_qty').val();
        var fuel_rate = $('#fuel_rate').val();
        var fuel_cost = parseFloat(fuel_qty * fuel_rate);
        $("#fuel_cost").val(fuel_cost);
        $("#total_payment").val(payment_receive+fuel_cost);
      });  
      
      $("#fuel_qty").change(function () {
        var fuel_qty = $(this).val();
        var fuel_rate = $('#fuel_rate').val();
        var fuel_cost = parseFloat(fuel_qty * fuel_rate);
        $("#fuel_cost").val(fuel_cost);
        var payment_receive = parseFloat($('#payment_receive').val());
        $("#total_payment").val(payment_receive+fuel_cost);
      });
     
      $("#fuel_rate").change(function () {
        var fuel_rate = $(this).val();
        var fuel_qty = $('#fuel_qty').val();
        var fuel_cost = parseFloat(fuel_qty * fuel_rate);
        $("#fuel_cost").val(fuel_cost);
        var payment_receive = parseFloat($('#payment_receive').val());
        $("#total_payment").val(payment_receive+fuel_cost);
      });
  
      // not needed now
      $("#unitPrice").change(function () {
        var unitPrice = $(this).val();
        var new_amount = $('#qty').val() * unitPrice;
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
          // $('#customerDiv').show();
          var textCustomer =
            "<div id='newCustomer'> <input type='text' class='form-control mb-2 mt-1' placeholder='Enter new customer name' name='customer_name' id=''/><div class='row'><div class='col-md-6'><input type='text' name='customer_mobile' class='form-control' placeholder='Customer`s mobile'></div><div class='col-md-6'><input type='text' name='customer_address' class='form-control' placeholder='Customer`s address'></div></div></div>";
          $("#customerDiv").append(textCustomer);
        } else {
          $("div [id$='newCustomer']").remove();
  
          // $.ajax({
          //   url: "find_customer",
          //   data: {
          //     _token: '{{csrf_token()}}',
          //     customerId: customerId
          //   },
          //   type: 'POST',
          //   success: function (response) {
          //     // console.log(response.data);
          //     $("#mobile").val(response.data.mobile)
          //     $("#address").val(response.data.address)
          //   }
          // });
        }
      });

      $(document).on('change', '#employeeId', function () {
        // $('#operatorDiv').show();
        var employeeId = $(this).val();
        if (employeeId == 'New') {
          var textEmployee =
            "<div id='newEmployee'><input type='text' class='form-control mb-2 mt-1' placeholder='Enter new operator name' name='employee_name' id=''/><div class='row'><div class='col-md-6'><input type='text' name='employee_mobile' class='form-control' placeholder='Operator`s mobile'></div><div class='col-md-6'><input type='text' name='employee_address' class='form-control' placeholder='Operator`s address'></div></div>";
          $("#operatorDiv").append(textEmployee);
        } else {
          $("div [id$='newEmployee']").remove();
  
          // $.ajax({
          //   url: "find_employee",
          //   data: {
          //     _token: '{{csrf_token()}}',
          //     employeeId: employeeId
          //   },
          //   type: 'POST',
          //   success: function (response) {
          //     // console.log(response.data);
          //     $("#mobile").val(response.data.mobile)
          //     $("#address").val(response.data.address)
          //   }
          // });
        }
      });
  
      $(document).on('click', '#bank', function () {
        if ($('#bank').is(':checked')) {
          bankDetails =
            '<div id="bank_details"><div class="form-group"><select class="form-control" name="bank_id" style="margin-top: -15px; float:left;margin-bottom:5px; margin-right: 5%"><option value="">Select bank</option> </select> </div><div class="form-group d-none"> <input type="text" name="branch" placeholder="Branch name" class="form-control" style="width:30%; float:left; margin-bottom:5px"></div></div></div>';
  
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