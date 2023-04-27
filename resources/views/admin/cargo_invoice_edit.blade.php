
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Update Cargo Chalan     
      </h1> 
      

      <a href="{{URL::to('add-cargo-invoice')}}" class="btn btn-white px-3 text-95 radius-round border-2 brc-black-tp10 float-right">
        <i class="fa fa-plus mr-1"></i>Add <span class="d-sm-none d-md-inline">New</span> Entry
      </a>

      <a href="cargo-invoices"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Cargo Chalan
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="update_cargo_invoice" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Chalan Name</label>
                    <input type="text" name="title" class="form-control" id=""  value="{{$data->title}}">
                  </div>                 
                  <div class="form-group">
                    <label for="">Product Name</label>                    
                        <select class="form-control" name="product_id" id="product_id">  

                            <?php $product=DB::table('products')->where('id', $data->product_id)->first();?>                            
                            <option value="{{$product->id}}">{{$product->name}}</option>

                            <?php                            
                             $products=DB::table('products')->where('active', 'on')->orderBy('name','asc')->get();?>
                            @foreach($products as $item) 
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach  
                        </select>
                  </div>     
                        

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Company Name</label>
                        <select class="form-control" name="company_id" id="">  
                          
                            <?php $item=DB::table('companies')->where('id', $data->company_id)->first();?>                            
                            <option value="{{$item->id}}">{{$item->title}}</option>                    

                            <?php                            
                             $companies=DB::table('companies')->where('active', 'on')->orderBy('title','asc')->get();
                             ?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">     
                      <label for="">Cargo Name</label>                       
                        <select class="form-control" name="ship_id" id="" >
                          
                          <?php $item=DB::table('data_lookups')->where('id', $data->ship_id)->first();?>                            
                          <option value="{{$item->id}}">{{$item->title}}</option>  

                          <?php                            
                            $ship=DB::table('data_lookups')->where('data_type', 'ship')->orderBy('title','asc')->get();
                          ?>
                          @foreach($ship as $item) 
                          <option value="{{$item->id}}">{{$item->title}}</option>
                          @endforeach  
                          
                        </select>
                      </div>
                    </div>
                  
                  </div>

                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Arrival Date Time</label>
                        <input type="datetime-local" name="arrival_date_time" class="form-control" value="{{$data->arrival_date_time}}">
                      </div> 
                    </div>        
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Release Date Time</label>
                        <input type="datetime-local" name="release_date_time" class="form-control" value="{{$data->release_date_time}}">
                      </div> 
                    </div>                             
                  </div>

                  <div class="form-group">     
                    <label for="">Select Sordar</label>                       
                      <select class="form-control" name="sordar_id" id="">
                        <?php $item=DB::table('data_lookups')->where('id', $data->sordar_id)->first();?>  
                        @if ($item)
                          <option value="{{$item->id}}">{{$item->title}}</option>  
                        @endif     

                        <?php                            
                          $sordar = DB::table('data_lookups')->where('data_type', 'sordar')->orderBy('title','asc')->get();
                        ?>
                        @foreach($sordar as $item) 
                        <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach  
                        
                      </select>
                    </div>    

                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="summernote" name="description" rows="25">{{$data->description}}</textarea>  
                  </div>

                  <div class="d-none form-group">
                    <label for="">Short Description</label>
                    <textarea name="short_description"  class="form-control"  rows="3">{{$data->short_description}}</textarea>  
                  </div>
                  <div class="form-group">
                    <label for="">Address</label>                    
                    <textarea name="address"  class="form-control"  rows="3">{{$data->address}}</textarea> 
                  </div>

                  <div class="product_unload">

                    <h4 style="margin-top: 50px; color:green">Product Unload Record</h4>
                    <hr>
                    
                    <div class="row">
                      <div class="col-md-2">
                        <label for="">Date</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Store Type</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Store Name</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Quantity</label>
                      </div>
                      <div class="col-md-2">
                        <label for="">Wet</label>
                      </div>
                     
                      <div class="col-md-2">
                        <label for="">Action</label>
                      </div>
                    </div>

                    <?php 
                       $unloads = DB::table('product_unloads')  
                              ->where('cargo_invoice_id', $data->id)
                              ->get();  
                        $unloads_count = $unloads->count(); 
                        $total_qty = 0;
                        foreach($unloads as $unload){
                          $total_qty = $total_qty +$unload->quantity;
                        }     
                        //dd($unloads);                                       
                    ?>
                    @if($unloads_count != 0)
                      @foreach($unloads as $unload)                    
                        <div id="row_{{$loop->iteration}}" class="row content">
                          <div class="col-md-2">
                            <div class="form-group">                       
                              <input type="date" name="date[]" id="date1" value="{{$unload->unload_date}}" class="form-control date" required>
                            </div> 
                          </div>  
                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <select class="form-control store_type" name="store_type[]" id="storeType_1"   required="">
                                @php
                                      $store = DB::table('stores')  
                                      ->where('id', $unload->store_id)
                                      ->first();  
                                @endphp
                                  <option value="{{$store->store_type}}">{{$store->store_type}}</option>                     
                                  <option value="Store">Store</option>
                                  <option value="Dump">Dump</option>                     
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">                         
                              <select class="form-control store" name="store_id[]" id="storeID_1" required="">
                                  @php
                                      $store = DB::table('stores')  
                                      ->where('id', $unload->store_id)
                                      ->first();  
                                  @endphp
                                  <option value="{{$store->id}}">{{$store->title}}</option> 
                              </select>
                            </div> 
                          </div>                            
                          <div class="col-md-2">
                            <div class="form-group">                        
                              <input type="text" name="qty[]" value="{{$unload->quantity}}" class="form-control qty" id="qty1" >
                            </div> 
                          </div>  
                          <div class="col-md-2">
                            <div class="form-group">                        
                              <input type="text" name="wet[]" class="form-control wet" value="{{$unload->wet}}" id="wet1" >
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
                      <div  id="row_1" class="row content">
                        <div class="col-md-2">
                          <div class="form-group">                       
                            <input type="date" name="date[]" id="date1" class="form-control date" required>
                          </div> 
                        </div>  
                        
                        <div class="col-md-2">
                          <div class="form-group">
                            <select class="form-control store_type" name="store_type[]" id="storeType_1" required="">
                                <option value="">Select type</option>                        
                                <option value="Store">Store</option>
                                <option value="Dump">Dump</option>                      
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">                         
                            <select class="form-control store" name="store_id[]" id="storeID_1" required="">
                                
                            </select>
                          </div> 
                        </div>                       
                        <div class="col-md-2">
                          <div class="form-group">                        
                            <input type="text" name="qty[]" class="form-control qty" id="qty1" >
                          </div> 
                        </div>  
                        <div class="col-md-2">
                          <div class="form-group">                        
                            <input type="text" name="wet[]" class="form-control wet" id="wet1" >
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
                      <div class="col-md-4"></div>
                      <div class="col-md-2">
                          <label for="" style="float: right;">Total Quantity:</label>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <input type="text" readonly name="total_quantity" class="form-control" id="totalQuantity" value="@if($unloads != null){{$total_qty}}@endif" >
                          </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>

                  </div>

                  
                      <div class="form-group">
                        <label for="">Image: </label>
                        <input type="hidden" name="hidden_image" value="{{$data->image}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <img src="{{ URL::asset('storage/app/public/'.$data->image.'') }}" id="previousImage" height="100px" alt="">
    
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
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{URL::to('cargo-invoices')}}" class="btn btn-default">Cancel</a>
                      
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
     
      let i=<?php if($unloads_count!=0) echo $unloads_count; else echo "1";?>;  
      var j = 0;     
      $(document).on('click', '#addRow', function(event){  
        event.preventDefault();  
        //console.log('clicked');  
        i++;
        j=i;

        var html = '<div id="row_'+i+'" class="row content dynamic-added">';

          html += '<div class="col-md-2"><div class="form-group"><input type="date" name="date[]" id="date'+i+'" class="form-control date" required></div></div>';

          html += '<div class="col-md-2"><div class="form-group"><select class="form-control store_type" name="store_type[]" id="storeType_'+i+'" required=""><option value="">Select type</option><option value="Store">Store</option><option value="Dump">Dump</option></select></div></div>';   
        
          html += '<div class="col-md-2"><div class="form-group"><select class="form-control required="" store" name="store_id[]" id="storeID_'+i+'"></select></div></div>';         
          
          html += '<div class="col-md-2"><div class="form-group"> <input type="text" name="qty[]" class="form-control qty" id="qty'+i+'" ></div></div>';

          html += '<div class="col-md-2"><div class="form-group"><input type="text" name="wet[]" id="wet'+i+'" class="form-control wet"></div></div>';
          
          html += '<div class="col-md-1"><div class="form-group"><button id="'+i+'" type="button" class="btn btn-danger form-control btn_remove"><i class="fa fa-trash"></i></button></div></div>';
          
          html += '</div>';

        
        let tb = $("#target").find();
        //console.log(html);
        $("#target").append(html);
        //tb.find('tr').last().trigger('select-added');
      });  

      $(document).on('click', '.btn_remove', function(){  
          var button_id = $(this).attr("id");   
          $('#row_'+button_id+'').remove(); 
          updatetotalQuantity(); 
      });  

      function updatetotalQuantity() {
        var sum = 0;        
          $(".qty").each(function(){
              sum += +$(this).val();
              console.log(sum);
          });
          $("#totalQuantity").val(sum);
      }

       //change on qty
       $(document).on('change', '.qty', function(){  
          var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
          var qty = $(this).val();
          updatetotalQuantity();
      });  

      $(document).on('change', '.store_type', function(){  
          var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
          //var row_id = $(this).attr('id').split('_').pop(); 
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
                      $('#storeID_'+row_id+'').empty();
                      $('#storeID_'+row_id+'').focus;
                      $('#storeID_'+row_id+'').append('<option value="">-- Select one --</option>'); 
                      $.each(response.data, function(key, value){
                          $('select[id="storeID_'+row_id+'"]').append('<option value="'+ value.id +'">' + value.title+ '</option>');
                      });
                  }else{
                    $('#storeID_'+row_id+'').empty();
                  }       
            }
          });
         
      });  


    });
  </script>
@endsection