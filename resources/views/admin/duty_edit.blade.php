
@extends('admin.master')
@section('main_content')    
<style>
  select#productId_1 {
    height: 40px;
    border: 1px solid #d1d5d7;
}
      i.fa.fa-trash {
          display: block;
      }
    
</style>
  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update Duty
      </h1> 
      

      <a href="{{URL::to('add-duty')}}" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
        <i class="fa fa-plus mr-1"></i>Add <span class="d-sm-none d-md-inline">New</span> Entry
      </a>

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

                <form action="update_duty" method="post" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="row">                     
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Ex No</label>
                        <select class="form-control ss" name="equipement_id" id="equipement_id">  
                          @if ($data->equipement_id != null)
                            <?php 
                            $item = DB::table('products')
                            ->where('id', $data->equipement_id)
                            ->first();?>  
                            @if ($item)
                            <option value="{{$item->id}}">{{$item->name}}</option> 
                            @endif 
                          @endif  

                          <option value="">Select ex. no</option> 
                          <?php                            
                           $equipements = DB::table('products')
                           ->where('product_type', 'Service')
                           ->where('client_id', session('client_id'))
                           ->where('active', 'on')
                           ->orderBy('name','asc')
                           ->get();
                           ?>
                          @foreach($equipements as $item) 
                          <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach  
                      </select>
                      </div>   
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Duty Rate</label>
                        <input type="text" name="rate" class="form-control" id="rate" value="{{$data->rate}}">
                      </div>
                    </div>


                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Duty Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                            value="{{$data->date}}">
                      </div>
                    </div>
                  </div> 
                 
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Customer or company</label>
                        <select class="form-control select2-single" name="company_id" id="">  
                                @if ($data->customer_id != null)
                                  <?php $item=DB::table('customers')->where('id', $data->customer_id)->first();?>                            
                                  <option value="{{$item->id}}">{{$item->title}}</option> 
                                @endif
                                <option value="">Select customer</option> 
                                <?php                            
                                $companies=DB::table('customers')
                                ->where('client_id', session('client_id'))
                                ->where('active', 'on')
                                ->orderBy('title','asc')->get();
                                ?>
                                @foreach($companies as $item) 
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach  
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Operator</label>
                        <select class="form-control ss" name="employee_id">  
                            @if ($data->employee_id != null)
                              <?php 
                              $item = DB::table('employees')
                              ->where('id', $data->employee_id)
                              ->first();?>  
                              @if ($item)
                              <option value="{{$item->id}}">{{$item->title}}</option> 
                              @endif 
                            @endif  

                            <option value="">Select operator</option> 
                            <?php                            
                             $companies=DB::table('employees')
                             ->where('designation', 'Driver')
                             ->where('client_id', session('client_id'))
                             ->where('active', 'on')
                             ->orderBy('title','asc')
                             ->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>
                    </div>

                  </div>


                  <br> <br>
                  <div class="row">                     
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Start Reading</label>
                        <input type="text" name="start_reading" class="form-control" id=""  value="{{$data->start_reading}}">
                      </div>      
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Stop Reading</label>
                        <input type="text" name="stop_reading" class="form-control" id=""  value="{{$data->stop_reading}}">
                      </div>      
                    </div>                                                
                 
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Total Hours</label>
                        <input type="text" required name="total_hours" class="form-control" id=""  value="{{$data->total_hours}}">
                      </div>      
                    </div>
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Tracking Hours</label>
                        <input type="text" name="tracking_hours" class="form-control" id=""  value="{{$data->tracking_hours}}">
                      </div>      
                    </div>
                  </div>


                  <div class="row">                     
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Payment Receive</label>
                        <input type="text" name="payment_receive" class="form-control" id=""  value="{{$data->payment_receive}}">
                      </div>      
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Fuel Receive</label>
                        <select class="form-control ss" name="fuel_type">
                          <option value="{{$data->fuel_type}}">{{$data->fuel_type}}</option>
                          <option value="Hydraulic">Hydraulic</option>
                          <option value="Diesel">Diesel</option>
                          <option value="Mobil">Mobil</option>
                          <option value="Grease">Grease</option>
                          <option value="Others">Others</option>
                        </select>                       
                      </div>      
                    </div>

                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Fuel Qty</label>
                            <input type="text" name="fuel_qty" class="form-control" id="" value="{{$data->fuel_qty}}">
                          </div>   
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Fuel Rate</label>
                            <input type="text" name="fuel_rate" class="form-control" id=""  value="{{$data->fuel_rate}}">
                          </div>   
                        </div>
                        
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Fuel Cost</label>
                        <input type="text" name="fuel_cost" class="form-control" id=""  value="{{$data->fuel_cost}}">
                      </div>      
                    </div>  


                  
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Total Payment</label>
                        <input type="text" name="total_payment" readonly class="form-control" id=""  value="{{$data->total_payment}}">
                      </div>      
                    </div>    
                    
                    <div class="col-md-9">
                      <div class="form-group">
                        <label for="">Notes</label>
                        <textarea name="notes" class="form-control" rows="1">{{$data->notes}}</textarea>  
                      </div>  
                    </div>
                  </div>
                                
                             

                  <div class="form-group d-none">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="3">{{$data->description}}</textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="1">{{$data->short_description}}</textarea>  
                  </div>

                  <div class="duty_details mt-5">
                    <h4>Duty Expense Details</h4>
                    <div class="row">

                      <div class="col-md-3">
                        <label for="">Particular</label>
                      </div>

                      <div class="col-md-2">
                        <label for="">Expense Type</label>
                      </div>
                      <div class="col-md-1 tc">
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

                    <?php 
                       $expenses = DB::table('expenses')  
                              ->where('duty_id', $data->id)
                              ->get();  
                        $ed_count = $expenses->count(); 
                        $total_qty = 0;
                        $total_price = 0;
                        $total_expense = 0;
                        foreach($expenses as $ed){
                          $total_qty = $total_qty + $ed->qty;
                          $total_duty = $total_price + $ed->price;
                          $total_expense = $total_expense + $ed->amount;
                        }     
                        //dd($ed_count);                                       
                    ?>
                    @if($ed_count != 0)
                      @foreach($expenses as $ed)                    
                        <div id="row_{{$loop->iteration}}" class="row content">

                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" name="particular[]" value="{{$ed->title}}" class="form-control particular" id="particular1">
                            </div>
                          </div> 
 
                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <select class="select2-single product" name="expense_type[]" id="productId_1"
                                style="width: 100%;">
                                <option value="{{$ed->expense_type}}">{{$ed->expense_type}}</option>
                                <option value="Hydraulic">Hydraulic</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Mobil">Mobil</option>
                                <option value="Grease">Grease</option>
                                <option value="Technician Bill">Technician Bill</option>
                                <option value="Salary">Salary</option>
                                <option value="Others">Others</option>
                              </select>
                            </div>
                          </div>
                                                       
                          <div class="col-md-1">
                            <div class="form-group">
                              <input type="text" name="qty[]" value="{{$ed->qty}}" id="qty1" class="form-control qty">
                            </div>
                          </div>
                          <div class="col-md-1">
                            <div class="form-group">
                              <input type="text" name="price[]" value="{{$ed->price}}" id="unitPrice1" class="form-control price">
                            </div>
                          </div>
                        
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text" name="total_price[]" value="{{$ed->amount}}" readonly class="form-control amount tr" id="amount1">
                            </div>
                          </div>                     
                                      
                          <div class="col-md-1">
                            <div class="form-group">                       
                              <button type="button" id="{{$loop->iteration}}" class="btn btn-danger form-control @if($loop->iteration>1) btn_remove @endif"><i class="fa fa-trash"></i></button>
                            </div> 
                          </div> 
                          <div class="col-md-1">
                            <div class="form-group">                       
                              <button class="btn btn-info form-control" id="addRow"><i class="fa fa-plus"></i></button>
                            </div> 
                          </div> 
                        </div> 
                      @endforeach
                    @else
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
                    @endif
  
                   
  
                    <div id="target"></div>
    
                    <div class="row">
                      <div class="col-md-3">
    
                      </div>
                      <div class="col-md-4">
                        <label for="" style="float: right;">Total Amount:</label>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" readonly name="total_price" class="form-control tr" id="totalPrice" value="{{$total_expense}}">
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>

                  </div>
                 

              
                  
                      <div class="form-group">
                        <label for="">Image: </label>
                        <input type="hidden" name="hidden_image" value="{{$data->image}}">
                        <input type="hidden" name="id" value="{{$data->id}}">

                        @if ($data->thumbnail != null)
                          <img src="{{ URL::asset('storage/app/public/'.$data->thumbnail.'') }}" style="width: 100px; height: 100px;">
                        @else 
                          {{-- <img src="{{ URL::asset('images/noimage.png') }}" id="noimage"style="width: 100px; height: 100px;"> --}}
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
                      <input type="hidden" name="duty_id" value="{{$data->id}}">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{URL::to('dutys')}}" class="btn btn-default">Cancel</a>
                      
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
      let i=<?php if($ed_count != 0) echo $ed_count; else echo "1";?>;  
      var j = 0;   
      $(document).on('click', '#addRow', function (event) {
        event.preventDefault();
        //console.log('clicked');  
        i++;
        j = i;
  
        var html = '<div id="row_' + i + '" class="row content dynamic-added">';
        
        html +=
          '<div class="col-md-3"><div class="form-group"> <input type="text" name="particular[]" class="form-control particular" placeholder="Particular Title" id="particular' +
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
            $('#unitPrice' + row_id + '').val(response.data.price);
            $('#amount' + row_id + '').val(response.data.price);
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
            $("#unitPrice").val(response.data.price);
            $("#amount").val(response.data.price);
            $("#totalPrice").val(response.data.price);
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


      $(document).on('change', '#equipement_id', function () {
        var equipement_id = $(this).val();  
          $.ajax({
            url: "find_equipement_rate",
            data: {
              _token: '{{csrf_token()}}',
              equipement_id: equipement_id
            },
            type: 'POST',
            success: function (response) {
              // console.log(response.data);
              $("#rate").val(response.data.rate)
            }
          });       
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