@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Bank Checks        
      </h1> 
      <a href="" data-toggle="modal" data-target="#addNewEntry" class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        Add <span class="d-sm-none d-md-inline">New</span> Entry
      </a>
    </div>

<!-- Modal -->
<div class="modal fade" id="addNewEntry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="store_bank_check"  enctype="multipart/form-data">
        @csrf
      <div class="modal-body">

          <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <span>Check Name</span>
                  <input type="text" name="name"  placeholder="Enter check name" required="" class="form-control">     
                </div>           
              </div> 
              <div class="col-md-6">
                <div class="form-group">
                  <span>Check No</span>
                  <input type="text" name="check_no"  placeholder="Enter check no" required="" class="form-control">     
                </div>           
              </div>  <div class="col-md-6">
                <div class="form-group">
                  <span>Amount</span>
                  <input type="text" name="amount"  placeholder="Amount" required="" class="form-control">     
                </div>           
              </div> 
          </div>

          <div class="row"> 
            <div class="col-md-12">
              <div class="form-group">
                <span>Select Bank</span>
                <select class="form-control" name="bank_id" required>
                  <option value="">Select bank</option>
                  <?php                   
                  $items=DB::table('banks')
                    ->get();
                  ?>
                  @foreach($items as $item) 
                    <option value="{{$item->id}}">{{$item->title}}</option>
                  @endforeach  
              </select>   
              </div>
            </div>
        </div>  

        <div class="row"> 
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">
                        Select Client</label>
                    <select class="select2-single" id="customerId" required name="customer_id" style="width: 100%;">
                      <option value="">Select Client</option>
                      <?php                            
                                $collection=DB::table('customers')
                                   ->where('active','on')
                                   ->orderBy('id','desc')
                                   ->get();                                
                                ?>
                      @foreach ($collection as $item)
                      <option value="{{$item->id}}">{{$item->title}}</option>
                      @endforeach
                    </select> 

                  </div>
            </div>
        </div>  

        <div class="row"> 
            <div class="col-md-12">
              <div class="form-group">
                <p id="errorShow" style="display: none; color: rgb(222, 198, 12)">There is no unpaid invoice of this customer.</p>
                <span>Select Invoice</span>
                <select class="form-control invoice_id" name="invoice_id" id="invoiceId" required>
                </select>
              </div>
            </div>
       
        <div class="col-md-12">
          <div class="form-group">
            <span>Check Notes</span>
              <textarea name="note" class="form-control" rows="2"></textarea>    
          </div>           
        </div> 
      </div>  
         
         
          <div class="form-group">
            <label for="">Image: </label> <br>
            <img id="uploadPreview" style="width: 200px; height: 150px; display:none" />
            <input id="uploadImage"  type="file" name="image" onchange="PreviewImage();" />
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal End -->  

    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">
                <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">              

                <h1 class="page-title text-primary-d2 text-140">
                    Bank Checks    
                  <small class="page-info text-dark-m3">
                    <i class="fa fa-angle-double-right text-80"></i>
                    you can add, edit and delete any of these data.
                  </small>
                </h1>                     


                <div class="page-tools mt-3 mt-sm-0 mb-sm-n1">
                  <!-- dataTables search box will be inserted here dynamically -->
                </div>
              </div>

              <div class="card bcard h-auto">
               

                  <table id="datatable" class="d-style w-100 table text-dark-m1 text-95 border-y-1 brc-black-tp11 collapsed">
                    <!-- add `collapsed` by default ... it will be removed by default -->
                    <!-- thead with .sticky-nav -->
                    <thead class="sticky-nav text-secondary-m1 text-uppercase text-85">
                      <tr>
                      

                        <th class="border-0 bgc-white pl-3 pl-md-4 shadow-sm"> SN </th>
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Check Name </th>  
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Amount</th>                    
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Customer</th>                    
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Invoice</th>                    
                        <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">Status</th>  
                        <th class="border-0 bgc-white shadow-sm w-2">
                          Action
                        </th>
                      </tr>
                    </thead>  

                    <tbody class="pos-rel">
                    @foreach($data as $item)                                   
                      <tr class="d-style bgc-h-default-l4">
                        <td class="pl-3 pl-md-4 align-middle pos-rel"> {{$loop->iteration}} </td>
                        <td> <span class="text-105"> {{$item->name}} </span> </td>
                        <td> <span class="text-105"> {{$item->amount}} </span> </td>
                        <?php 
                        $customer=DB::table('customers')
                           ->where('id', $item->customer_id)
                           ->first();              
                       ?>
                        <td><a title="Edit" href="customer-details/{{$customer->id}}">{{$customer->title}}</a></td>
                        
                        <td><a title="Edit" href="invoice-preview/{{$item->invoice_id}}">
                          @if ($item->invoice_id!=null)
                              Invocie#{{$item->invoice_id}} 
                          @endif
                          </a></td>
                        <td> <span class="text-105 @if($item->status=="Withdraw Completed") text-success @elseif($item->status=="Pending") text-warning @elseif($item->status=="Dishonoured") text-danger @endif "> {{$item->status}} </span> </td>
                       

                        <td class="align-middle">
                          <span class="d-none d-lg-inline">
                              <a data-rel="tooltip"  data-toggle="modal" data-target="#item{{$item->id}}"  title="Edit" href="#" class="v-hover">
                                  <i class="fa fa-edit text-blue-m1 text-120"></i>
                              </a>
                          </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-pencil-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Edit</span>
                          </a>
                          </span>

                          <!-- edit modal -->
                          <div class="modal fade" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
                            <div class="modal-dialog" role="document"  style="width:800px!important">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">
                                    Update Bank Check
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  
                                  <form method="post" action="update_bank_check"   class="mt-lg-3" autocomplete="off" enctype="multipart/form-data">
                                    @csrf                    

                                    <div class="row"> 
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <span>Check Name</span>
                                          <input type="text" name="name"  value="{{ $item->name }}" required="" class="form-control">     
                                        </div>           
                                      </div>  
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <span>Check No</span>
                                          <input type="text" name="check_no"  value="{{ $item->name }}" required="" class="form-control">     
                                        </div>           
                                      </div>  <div class="col-md-6">
                                        <div class="form-group">
                                          <span>Amount</span>
                                          <input type="text" name="amount" readonly  value="{{ $item->amount }}" required="" class="form-control">     
                                        </div>           
                                      </div> 
                                  </div>
                        
                                  <div class="row"> 
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Select Bank</span>
                                        <select class="form-control" required name="bank_id">
                                        <?php        
                                                    
                                            $bank=DB::table('banks')
                                            ->where('id', $item->bank_id)
                                            ->first();

                                            $banks=DB::table('banks')
                                            ->get();
                                        ?>
                                          <option value="{{$bank->id}}">{{$bank->title}}</option>
                                          
                                          @foreach($banks as $bank) 
                                            <option value="{{$bank->id}}">{{$bank->title}}</option>
                                          @endforeach  
                                      </select>   
                                      </div>
                                    </div>
                                </div>  
                        
                                <div class="row d-none"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Select Client</label>
                                            <select class="select2-single1" id="customerId" name="customer_id" style="width: 100%;">
                                              
                                                    <?php      
                                                        $customer=DB::table('customers')
                                                        ->where('id', $item->customer_id)
                                                        ->first();
                                                    ?>
                                                      <option value="{{$item->customer_id}}">{{$customer->title}}</option>

                                              
                                              <?php                            
                                                        $collection=DB::table('customers')
                                                           ->where('active','on')
                                                           ->orderBy('id','desc')
                                                           ->get();                                
                                                        ?>
                                              @foreach ($collection as $customer)
                                              <option value="{{$customer->id}}">{{$customer->title}}</option>
                                              @endforeach
                                            </select>
                        
                                          </div>
                                    </div>
                                </div>  
                        
                                <div class="row"> 
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Select Invoice</span>
                                        <select class="form-control" name="invoice_id" required>
                                          <option value="{{$item->invoice_id}}">Invoice#{{$item->invoice_id}}</option>
                                          <option value="">Select invoice</option>
                                          <?php                   
                                          $invoices=DB::table('orders')
                                            ->get();
                                          ?>
                                          @foreach($invoices as $invoice) 
                                            <option value="{{$invoice->id}}">Invoice#{{$invoice->id}}</option>
                                          @endforeach  
                                      </select>   
                                      </div>
                                    </div>
                                </div>  
                                
                                <div class="row"> 
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Check Status</span>
                                        <p class="text-warning">A "Withdraw Completed" check can not be updated. Be careful when you make as "Withdraw Completed"</p>
                                        <select class="form-control" name="status">
                                          <option value="{{$item->status}}">{{$item->status}}</option>
                                          <option value="Pending">Pending</option>
                                          <option value="Withdraw Completed">Withdraw Completed</option>
                                          <option value="Dishonoured">Dishonoured</option>
                                          <option value="Cancelled">Cancelled</option>
                                      </select>   
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <span>Check Notes</span>
                                          <textarea name="note" class="form-control" rows="2">{{$item->note}}</textarea>    
                                      </div>           
                                    </div> 

                                </div>  

                                 
                                  <div class="form-group">
                                    <label for="">Image: </label> <br>
                                   
                                    <br>
                                    <br>
                                    <img id="uploadPreview" style="width: 150px; height: 150px; display:none" />
                                    <input id="uploadImage" type="file" name="image" onchange="PreviewImage();" />
                                  </div>                                    
                                  <input type="hidden" name="id" value="{{ $item->id }}">
                                  <input type="hidden" name="hidden_image" value="{{ $item->image }}">
      
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  @if ($item->status != "Withdraw Completed")
                                  <button type="submit" class="btn btn-info btn-bold px-4">Save changes</button>
                                  @endif
                                 
                                </div>
                              </div>
                            </div>
                            </form>
                          </div> 
                          <!-- edit modal end -->                                                                      

                          <span class="d-lg-inline">
                            <a data-rel="tooltip" title="Delete" href="javascript:void(0)" data-target="#confirm_delete_modal" data-toggle="modal" data-id="{{$item->id}}" class="delete-btn v-hover">
                                <i class="fa fa-trash text-blue-m1 text-120"></i>
                            </a>
                            <div id="confirm_delete_modal" class="modal fade" aria-modal="true">
                              <div class="modal-dialog modal-dialog-centered modal-confirm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <div class="icon-box">
                                      <i class="fa fa-times fa-4x"></i>
                                    </div>				
                                    <h4 class="modal-title w-100">Warning!</h4>	
                                  </div> 
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure? This action can't be undone.</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="" class="btn btn-danger delete-bankCheck">Delete</a>
                                  </div>
                                </div>
                              </div>
                            </div>                              
                        </span>

                          <span class="d-lg-none text-nowrap">
                              <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                  <i class="fa fa-trash-alt mx-1"></i>
                                  <span class="ml-1 d-md-none">Delete</span>
                          </a>
                          </span>
                        </td>
                      </tr> 



                      @endforeach

                    
                    </tbody>
                  </table>

              </div>
            </div>


           
      </div>
    </div>

  </div>
  <script>
    $(document).ready(function() {  
      $(document).on('change', '#customerId', function(){  
          //var row_id = $(this).parent().parent().parent().attr('id').split('_').pop();
          
          var customerId = $(this).val();
          console.log(customerId);
          $.ajax({
            url: "find_invoice",
            data: {
              _token: '{{csrf_token()}}',
              customerId: customerId
            },
            type: 'POST',
            success: function (response) {
              console.log(response);
                  if(response.total>0){
                      $('#errorShow').hide();
                      $('#invoiceId').empty();
                      $('#invoiceId').focus;
                      $('#invoiceId').append('<option value="">-- Select one --</option>'); 
                      $.each(response.data, function(key, value){
                          $('select[id="invoiceId"]').append('<option value="'+ value.id +'">Invoice#' + value.id+ '</option>');
                      });
                  }else{
                    $('#invoiceId').empty();
                    $('#errorShow').show();

                  }       
            }
          });
         
      });  



    });
  </script>
@endsection