
@extends('admin.master')
@section('main_content')    

  <div class="page-content container container-plus">
    <div class="page-header pb-2">
      <h1 class="page-title text-primary-d2 text-150">
        Customer Accounts:  <span style="color: #000; font-weight: 600">{{ucwords($data->title)}}, </span> <span style="font-size: 16px; color:#000"> {{ucwords($data->address)}}</span>
      </h1> 
      
      
      <a href="customers"class="btn btn-default px-3 text-95 radius-round border-2 brc-black-tp10 float-left">
        <i class="fa fa-plus mr-1"></i>
        <span class="d-sm-none d-md-inline">All</span> Customers
      </a>
    </div>     


    <div class="row mt-3">
      <div class="col-12">
         <div class="card dcard">
          <div class="card-body px-1 px-md-3">                                   
            <div role="main" class="main-content">         
              <div class="page-content container container-plus">      
                
                <form action="store_customer_ob" style="float: left" class="form form-inline" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="">Opening Balance: &nbsp;</label>

                    @php
                        $ob = DB::table('customer_accounts')
                          ->where('customer_id', $data->id)
                          ->where('type', 'OB')
                          ->orderBy('id', 'desc') 
                          ->first();
                          
                        $ca = DB::table('customer_accounts')
                          ->where('customer_id', $data->id)
                          ->orderBy('id', 'desc') 
                          ->first();
                          //dd($ca);
                        if($ca != null){
                          $current_balance = $ca->current_balance;
                        }else{
                          $current_balance =0;
                        }
                    @endphp   
                    <input type="text" name="amount" class="form-control" @if ($ob)
                        value="{{$ob->current_balance}}"
                    @endif>
                  </div>     &nbsp;
                  <input type="hidden" name="customer_id" value="{{$data->id}}">
                  <button type="submit" class="btn btn-primary">Save</button> 
                </form>
                <h5 style="float: right"><a href="customer-ledger/{{$data->id}}" style="background: #ddd; padding: 3px 15px; color: #000">Customer Ledger</a></h5>

                {{-- <h4 style="float: left">All Invoice History:</h4>   --}}
                
                {{-- <h5 class="float-right" style="margin-right: 50px;">@if($ob != null)OB: {{$ob->current_balance}} Tk|@endif Current Balance: <span class="@if ($current_balance>0)text-success @else text-danger @endif"> {{number_format($current_balance, 2)}} Tk</span></h5> --}}

  
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col">SN</th>                         
                        <th  scope="col"> Date </th>
                        <th  scope="col"> Inv ID </th>	
                        <th  scope="col"> Total Amount</th>
                        <th  scope="col"> Paid</th>
                        <th  scope="col"> Due</th>
                        <th  scope="col"> Status </th>                        
                        <th  scope="col" class="d-none"> Balance </th>
                        <th  scope="col"> Action </th>  
                    </tr>
                  </thead>
                  <tbody>
                @php
                  $orderData = DB::table('orders')      
                      ->where('customer_id', $data->id)
                      ->orderby('id', 'desc')
                      ->where('active', 'on')
                      ->get(); 
                @endphp
                @foreach($orderData as $order)     
                    <tr>
                      <th scope="row">{{$loop->iteration}}.</th>
                      <td>{{bdtime($order->created_at)}}</td>
                      <td><a title="Invoice Preview" href="invoice-preview/{{$order->id}}">Inv#{{$order->inv_id}} </a></td>
                      <td>{{number_format($order->total_price, 2)}}</td>
                      <td>{{number_format($order->paid_amount, 2)}}</td>
                      <td>{{number_format($order->due_amount, 2)}}</td>                      
                      <td class="@if($order->status=='Due') text-danger @else text-success @endif">{{$order->status}}</td>
                      
                      @php
                        $payment = DB::table('payments')  
                              ->where('order_id', $order->id)
                              ->orderby('id', 'desc')
                              ->first();   
                        if($payment != null){
                          $ca = DB::table('customer_accounts')      
                              ->where('customer_id', $data->id)
                              ->where('invoice_id', $order->id)
                              ->orWhere('payment_id', $payment->id)
                              ->orderby('id', 'desc')
                              ->first();   
                        }
                        
                      @endphp
                      <td class="d-none">
                        @if ($ca)
                        {{number_format($ca->current_balance, 2)}}
                        @endif
                      </td>
                      
                      <td class="align-middle">
                        <span class="d-none d-lg-inline">
                            <a  title="Details" href="invoice-preview/{{$order->id}}" target="_blank" class="v-hover">
                                <i class="fa fa-eye text-blue-m1 text-120"></i>
                            </a>
                        </span>
                        <span class="d-none d-lg-inline">
                            <a  title="PDF Download" href="invoice/{{$order->id}}" target="_blank" class="v-hover">
                                <i class="fa fa-download text-blue-m1 text-120"></i>
                            </a>
                        </span>
                       
                        <span class="d-lg-none text-nowrap">
                            <a title="Edit" href="#" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                <i class="fa fa-pencil-alt mx-1"></i>
                                <span class="ml-1 d-md-none">Print</span>
                            </a>
                        </span>
                                                                                      
                        <span class="d-none d-lg-inline">
                            <a  title="Edit" href="edit-invoice/{{$order->id}}" class="v-hover">
                                <i class="fa fa-edit text-blue-m1 text-120"></i>
                            </a>
                        </span>
                        <span class="d-lg-none text-nowrap">
                            <a title="Edit" href="edit-invoice/{{$order->id}}" class="btn btn-outline-info shadow-sm px-4 btn-bgc-white">
                                <i class="fa fa-pencil-alt mx-1"></i>
                                <span class="ml-1 d-md-none">Edit</span>
                            </a>
                        </span>
                                                                                      

                        <span class="d-none d-lg-inline">
                            <a data-rel="tooltip" title="Delete" href="/delete-invoice/{{$order->id}}" onclick="confirmDelete()" class="v-hover">
                                <i class="fa fa-trash text-blue-m1 text-120"></i>
                            </a>
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

                <br> <br>
              
                @php
                    $checks = DB::table('bank_checks')      
                      ->where('customer_id', $data->id)
                      ->orderby('id', 'desc')
                      ->get(); 
                      
                @endphp 
                @if ($checks->count() != 0)
                  <h4>Bank Check:</h4>   
                  <table class="table table-striped">
                    <thead>
                      <tr>
                          <th scope="col">SN</th>
                          <th class="border-0">Date </th>                   
                          <th class="border-0">Invoice</th>  
                          <th class="border-0">Check Name</th>  
                          <th class="border-0">Bank</th>  
                          <th class="border-0">Amount</th>                     
                          <th class="border-0">Balance</th>  
                          <th class="border-0">Status</th>  
                          {{-- <th class="border-0 bgc-white shadow-sm w-2" style="width: 20%"> Date</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                    
                      
                
                  @foreach($checks as $item)   
                  @php
                      $bank = DB::table('banks')      
                      ->where('id', $item->bank_id)
                      ->first(); 
                  @endphp  
                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td> <span class="text-105"> {{$item->created_at}} </span> </td>
                        <td><a title="Invoice Preview" href="invoice-preview/{{$item->invoice_id}}">Invocie#{{$item->invoice_id}} </a></td>
                        <td> <span class="text-105"> {{$item->name}} </span> </td>
                        <td> <span class="text-105"> {{$bank->title}} </span> </td>
                        <td> <span class="text-105"> {{$item->amount}} </span> </td>
                        <td> <span class="text-105"> </span> </td>
                        <td> <span class="text-105"> {{$item->status}} </span> </td>

                      </tr>
                      @endforeach
                    
                    </tbody>
                  </table>
                @endif
                               
              </div>
            </div>
          </div>
        </div>           
      </div>
    </div>

  </div>
 
@endsection