
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
         Cash Receive   
      </h1> 
      <a href="cashflows"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Cash Flow
      </a>
    </div>   


    <div class="row mt-3">
      <div class="col-12">
        <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">               

                <form action="save_cashflow" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Cash Receive Particular</label>
                        <input type="text" name="title" class="form-control" id=""  placeholder="Enter particular here">
                      </div>  
                    </div>     
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Cash Receive Type</label>
                        <select class="form-control select2-single" name="cashflow_type" id="expenseType" required>  
                          <option value="">Select cash receive type</option> 
                          <option value="Opening Balance">Opening Balance</option>  
                          <option value="Boss Personal">Boss Personal</option>  
                          <option value="Bank Withdraw">Bank Withdraw</option>  
                          <option value="House Rent">House Rent</option> 
                          <option value="Investment">Investment</option>  
                          <option value="Loan Receive">Loan Receive</option> 
                          <option value="Loan Return">Loan Return</option> 
                          <option value="Others">Others</option> 
                        </select>
                      </div>      
                      
                    </div>  
                    <div class="col-md-6" id="bankAcc" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: green; display: block; width:100%">Select Bank Account</label>                    
                        <select class="form-control select2-single" name="bank_id" style="display: block; width:100%">  
                          <option value="">-- Select Bank Account --</option> 
                            <?php                            
                              $banks=DB::table('banks')->where('client_id', session('client_id'))->where('active', 'on')->orderBy('title','asc')->get();?>
                            @foreach($banks as $item) 
                            <option value="{{$item->id}}">{{$item->title}} - {{$item->ac_no}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>
                    
                    <div class="col-md-6" id="company" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: green; display: block; width:100%">Select Company</label>                    
                        <select class="form-control select2-single" name="company_id" style="display: block; width:100%">  
                          <option value="">-- Select Company --</option> 
                            <?php                            
                              $companies = DB::table('companies')->where('client_id', session('client_id'))->where('active', 'on')->orderBy('title','asc')->get();?>
                            @foreach($companies as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>

                    <div class="col-md-6" id="investment" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: green; display: block; width:100%">Select Investor <a href="add-customer" style="color: #4188b3; font-size: 12px">Add New Investor From Customer</a> </label>   
                                        
                        <select class="form-control select2-single" name="investor_id" style="display: block; width:100%">  
                          <option value="">-- Select Investor--</option> 
                            <?php                            
                              $investors=DB::table('customers')
                                ->where('type', 'Investor')
                                ->where('client_id', session('client_id'))
                                ->where('active', 'on')
                                ->orderBy('id','desc')
                                ->get();
                               // dd($investors);
                              ?>
                            @foreach($investors as $item) 
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach  
                        </select>
                      </div>        
                    </div>

                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" name="amount" class="form-control" id="amount" required  placeholder="Enter amount here">
                      </div>  
                    </div>
                  
                    
                    <div class="col-md-6" id="pMethod">
                      <div class="form-group"> 
                        <label for="">Payment Method</label>
                        <select class="form-control ss" name="payment_method" id="paymentMethod">  
                          <option value="Cash">Cash</option> 
                          <option value="Bank">Bank</option>  
                          <option value="MFS">MFS</option>  
                          {{-- <option value="Check">Check</option>  --}}
                        </select>
                      </div>      
                    </div>

                    <div class="col-md-6" id="bankAccount" style="display: none">
                      <div class="form-group">
                        <label for="" style="color: green; display: block; width:100%">Select Bank Account</label>                    
                        <select class="form-control select2-single" name="bank_id_pm" style="display: block; width:100%">  
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

                    
                 

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                        value="<?php echo date('Y-m-d'); ?>">
                      </div> 
                    </div>  
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Received By</label>                    
                        <input type="text" name="received_by" class="form-control" id="" required  value="Manager">
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
                    <textarea id="summernote" name="description" rows="5">
                    </textarea>  
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
     
        $(document).on('change', '#expenseType', function () {       
              var type = $(this).val();
            
            if(type == 'Bank Withdraw'){
                $("#bankAcc").show();
                $("#investment").hide();
                $("#pMethod").hide();
                $("#bankAccount").hide();
            }
            else if(type == 'Company Expense Bill'){
                $("#company").show();
                $("#pMethod").show();
                $("#investment").hide();
                $("#bankAcc").hide();
            }
            else if(type == 'Investment'){
                $("#investment").show();
                $("#bankAcc").hide();
                $("#company").hide();
                $("#pMethod").show();
            }
            else{
                $("#bankAcc").hide();
                $("#company").hide();
                $("#pMethod").show();
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